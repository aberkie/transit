<?php
	
namespace Craft;

class Transit_StationService extends BaseApplicationComponent
{
	
	protected $transitRecord;
	protected $API_KEY;
	
	protected $default_service = "WMATA";
	
	public function __construct($transitRecord = null)
	{
		if(is_null($this->transitRecord)) 
		{
			$this->transitRecord = Transit_StationRecord::model();
		}
		
		$api_key = craft()->transit_key->getKey($this->default_service);
		
		$this->API_KEY = $api_key;
		
	}
	
	public function getAllStations()
	{
		$records = $this->transitRecord->findAll(array('order'=>'name'));
		
		return Transit_StationModel::populateModels($records);
	}

	public function getNextTrains($station_code)
	{
		$service = "StationPrediction";
		$method = "GetPrediction/";
		$method.= "$station_code";
		$cache_key = "getNextTrain_$station_code";
		$return = "";
		
		$cache = craft()->cache->get($cache_key);
		if(! $cache)
		{
			$next_trains = $this->call($service, $method);
			$return = $next_trains['Trains'];
			craft()->cache->set("getNextTrain_$station_code", $return, 30);
		} else {
			$return = craft()->cache->get($cache_key);
		}
				
		return $return;
		
	}

	public function installStations()
	{
		$service = "Rail";
		$method = "jStations";
		$stations = $this->call($service, $method);
		
		$stations = $stations['Stations'];
		
		$new_stations = array();
		
		foreach($stations as $station){
			
			$line_codes = ['LineCode1', 'LineCode2', 'LineCode3', 'LineCode4'];
			$lines = array();
			
			foreach($line_codes as $line_code)
			{
				if($station[$line_code] !== null)
				{
					$lines[] = $station[$line_code];
				}
			}
			
			$line_str = implode (", ", $lines);
			$station_name = $station['Name']." ($line_str)";
			
			$new_stations[] = array(
				'address_city' => $station['Address']['City'],
				'address_state' => $station['Address']['State'],
				'address_street' => $station['Address']['Street'],
				'address_zip' => $station['Address']['Zip'],
				'code' => $station['Code'],
				'display_name' => $station_name,
				'lat' => $station['Lat'],
				'line_code_1' => $station['LineCode1'],
				'line_code_2' => $station['LineCode2'],
				'line_code_3' => $station['LineCode3'],
				'line_code_4' => $station['LineCode4'],
				'lon' => $station['Lon'],
				'name' => $station['Name'],
				'station_together_1' => $station['StationTogether1'],
				'station_together_2' => $station['StationTogether2']
			);
		}		
		
		//Clear out stations for updating
		craft()->db->createCommand()->truncateTable('transit_stations');
		
		foreach($new_stations as $station)
		{
			craft()->db->createCommand()->insert('transit_stations', $station);
		}
		return true;
	}
	
	private function call($service, $method, $params = null)
	{
		$base = "https://api.wmata.com/$service.svc/json/";
		$key = $this->API_KEY;
		$key_string = "api_key=$key";
		
		$url = $base.$method."?".$key_string;
						
		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$result = curl_exec($ch);
		if($result === false)
		{
			curl_close($ch);
			return false;
		} else {
			curl_close($ch);
			$json = json_decode($result, true);
			
			if(isset($json['statusCode']))
			{
				return false;
			} else {
				return $json;
			}
		}
	}
}
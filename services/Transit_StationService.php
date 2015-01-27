<?php
	
namespace Craft;

class Transit_StationService extends BaseApplicationComponent
{
	
	protected $transitRecord;
	
	public function __construct($transitRecord = null)
	{
		if(is_null($this->transitRecord)) 
		{
			$this->transitRecord = Transit_StationRecord::model();
		}
	}
	
	public function getAllStations()
	{
		$records = $this->transitRecord->findAll(array('order'=>'Name'));
		
		return Transit_StationModel::populateModels($records);
	}

	public function getStationInformation($station_code)
	{
		$condition = "Code = '$station_code'";
		$record = $this->transitRecord->find($condition);
		
		if($record)
		{
			$model = Transit_StationModel::populateModel($record);
			return $model;
		} else {
			return false;
		}
		
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
			$next_trains = craft()->transit_api->call($service, $method);
			$return = $next_trains['Trains'];
			craft()->cache->set($cache_key, $return, 30);
		} else {
			$return = craft()->cache->get($cache_key);
		}
				
		return $return;
		
	}

	public function installStations()
	{
		$service = "Rail";
		$method = "jStations";
		$stations = craft()->transit_api->call($service, $method);
		
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
				'Address_City' => $station['Address']['City'],
				'Address_State' => $station['Address']['State'],
				'Address_Street' => $station['Address']['Street'],
				'Address_zip' => $station['Address']['Zip'],
				'Code' => $station['Code'],
				'Display_Name' => $station_name,
				'Lat' => $station['Lat'],
				'LineCode1' => $station['LineCode1'],
				'LineCode2' => $station['LineCode2'],
				'LineCode3' => $station['LineCode3'],
				'LineCode4' => $station['LineCode4'],
				'Lon' => $station['Lon'],
				'Name' => $station['Name'],
				'StationTogether1' => $station['StationTogether1'],
				'StationTogether2' => $station['StationTogether2']
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
}
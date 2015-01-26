<?php
	
namespace Craft;

class Transit_LineService extends BaseApplicationComponent
{
	protected $lineRecord;
	
	public function __construct($lineRecord = null)
	{
		if(is_null($this->lineRecord))
		{
			$this->lineRecord = Transit_LineRecord::model();
		}
	}
	
	public function getAllLines()
	{
		$lines = $this->lineRecord->findAll(array('order'=>'display_name'));
		
		return Transit_LineModel::populateModels($lines);
	}
	
	public function getIncidents()
	{
		$service = "Incidents";
		$method = "Incidents";
		$cache_key = "railIncidents";
		
		$return = "";
		$cache = craft()->cache->get($cache_key);
		if(! $cache)
		{
			$incidents = craft()->transit_api->call($service, $method);
			$return = $incidents['Incidents'];
			craft()->cache->set($cache_key, $return, 3600);
		} else {
			$return = craft()->cache->get($cache_key);
		}
		
		return $return;

	}
	
	public function installLines()
	{
		$service = "Rail";
		$method = "jLines";
		$lines = craft()->transit_api->call($service, $method);
		
		$lines = $lines['Lines'];
		
		$new_lines = array();
		
		foreach($lines as $line)
		{
			$new_lines[] = array(
				'display_name' => $line['DisplayName'],
				'end_station_code' => $line['EndStationCode'],
				'internal_destination_1' => $line['InternalDestination1'],
				'internal_destination_2' => $line['InternalDestination2'],
				'line_code' => $line['LineCode'],
				'start_station_code' => $line['StartStationCode']
			);
		}
		
		craft()->db->createCommand()->truncateTable('transit_lines');
		
		foreach($new_lines as $line)
		{
			craft()->db->createCommand()->insert('transit_lines', $line);
		}
		
		return true;
	}
}
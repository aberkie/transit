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
		
		$incidents = craft()->transit_api->call($service, $method);
		$incidents = $incidents['Incidents'];
		$incidents = array(array(
			"DateUpdated"=> "2010-07-29T14:21:28",
			"DelaySeverity"=> null,
			"Description"=> "Red Line: Expect residual delays to Glenmont due to an earlier signal problem outside Forest Glen.",
			"EmergencyText"=> null,
			"EndLocationFullName"=> null,
			"IncidentID"=> "3754F8B2-A0A6-494E-A4B5-82C9E72DFA74",
			"IncidentType"=> "Delay",
			"LinesAffected"=> "RD;",
			"PassengerDelay"=> 0,
			"StartLocationFullName"=> null
		));
		return $incidents;
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
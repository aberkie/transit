<?php
	
namespace Craft;

class Transit_LineRecord extends BaseRecord
{
	public function getTableName()
	{
		return 'transit_lines';
	}
	
	protected function defineAttributes()
	{
		return array(
			'display_name' => AttributeType::String,
			'end_station_code' => AttributeType::String,
			'internal_destination_1' => AttributeType::String,
			'internal_destination_2' => AttributeType::String,
			'line_code' => AttributeType::String,
			'start_station_code' => AttributeType::String
		);
	}
	
	public function create()
	{
		$class = get_class($this);
		$record = new $class;
		
		return $record;
	}
}
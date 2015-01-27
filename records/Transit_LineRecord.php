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
			'DisplayName' => AttributeType::String,
			'EndStationCode' => AttributeType::String,
			'InternalDestination1' => AttributeType::String,
			'InternalDestination2' => AttributeType::String,
			'LineCode' => AttributeType::String,
			'StartStationCode' => AttributeType::String
		);
	}
	
	public function create()
	{
		$class = get_class($this);
		$record = new $class;
		
		return $record;
	}
}
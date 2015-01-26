<?php
	
namespace Craft;

class Transit_KeyRecord extends BaseRecord
{
	public function getTableName()
	{
		return 'transit_keys';
	}

	protected function defineAttributes()
	{
		return array(
			'service' => AttributeType::String,
			'api_key' => AttributeType::String
		);
	}
	
	public function create()
	{
		$class = get_class($this);
		$record = new $class();
		
		return $record;
	}
}
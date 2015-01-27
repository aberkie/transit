<?php
	
namespace Craft;

class Transit_LineModel extends BaseModel
{
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
}
<?php
	
namespace Craft;

class Transit_StationModel extends BaseModel
{
	
	protected function defineAttributes()
	{
		return array(
			'Address_City' => AttributeType::String,
			'Address_State' => AttributeType::String,
			'Address_Street' => AttributeType::String,
			'Address_zip' => AttributeType::String,
			'Code' => AttributeType::String,
			'Display_Name' => AttributeType::String,
			'Lat' => AttributeType::String,
			'LineCode1' => AttributeType::String,
			'LineCode2' => AttributeType::String,
			'LineCode3' => AttributeType::String,
			'LineCode4' => AttributeType::String,
			'Lon' => AttributeType::String,
			'Name' => AttributeType::String,
			'StationTogether1' => AttributeType::String,
			'StationTogether2' => AttributeType::String
		);
	}
}
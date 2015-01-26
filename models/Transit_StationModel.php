<?php
	
namespace Craft;

class Transit_StationModel extends BaseModel
{
	protected function defineAttributes()
	{
		return array(
			'address_city' => AttributeType::String,
			'address_state' => AttributeType::String,
			'address_street' => AttributeType::String,
			'address_zip' => AttributeType::String,
			'code' => AttributeType::String,
			'display_name' => AttributeType::String,
			'lat' => AttributeType::String,
			'line_code_1' => AttributeType::String,
			'line_code_2' => AttributeType::String,
			'line_code_3' => AttributeType::String,
			'line_code_4' => AttributeType::String,
			'lon' => AttributeType::String,
			'name' => AttributeType::String,
			'station_together_1' => AttributeType::String,
			'station_together_2' => AttributeType::String
		);
	}
}
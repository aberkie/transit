<?php
	
namespace Craft;

class Transit_LineModel extends BaseModel
{
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
}
<?php
	
namespace Craft;

class Transit_KeyModel extends BaseModel
{
	protected function defineAttributes()
	{
		return array(
			'service' => AttributeType::String,
			'api_key' => AttributeType::String
		);
	}
}
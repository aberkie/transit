<?php
	
namespace Craft;

class Transit_StationsFieldType extends BaseFieldType
{
	public function getName()
	{
		return Craft::t('Transit Stations');
	}
	
	public function defineContentAttribute()
	{
		return AttributeType::Mixed;
	}
	
	public function getInputHtml($name, $value)
	{
		$stations = craft()->transit_station->getAllStations();
		return craft()->templates->render('transit/_fieldtypes/stations', array(
			'name' => $name,
			'options' => $stations,
			'value' => $value
		));
	}
}
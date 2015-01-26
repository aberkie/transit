<?php
	
namespace Craft;

class Transit_LinesFieldType extends BaseFieldType
{
	public function getName()
	{
		return Craft::t('Metro Lines');
	}
	
	public function defineContentAttribute()
	{
		return AttributeType::Mixed;
	}
	
	public function getInputHtml($name, $value)
	{
		$stations = craft()->transit_line->getAllLines();
		return craft()->templates->render('transit/_fieldtypes/lines', array(
			'name' => $name,
			'options' => $stations,
			'value' => $value
		));
	}
}
<?php
	
namespace Craft;

class Transit_RailIncidentsWidget extends BaseWidget{
	
	public function getName()
	{
		return Craft::t('Metro Rail Incidents');
	}
	
	public function getBodyHtml()
	{
		$incidents = craft()->transit_line->getIncidents();
		return craft()->templates->render('transit/_widgets/rail_incidents', array(
			'incidents' => $incidents
		));
	}
}
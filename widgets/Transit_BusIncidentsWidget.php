<?php
	
namespace Craft;

class Transit_BusIncidentsWidget extends BaseWidget{
	
	public function getName()
	{
		return Craft::t('Metro Bus Incidents');
	}
	
	public function getBodyHtml()
	{
		$incidents = craft()->transit_incident->getBusIncidents();
		return craft()->templates->render('transit/_widgets/bus_incidents', array(
			'incidents' => $incidents
		));
	}
}
<?php
	
namespace Craft;

class Transit_BusService extends BaseApplicationComponent
{
	
	public function __construct($lineRecord = null)
	{

	}
	

	
	public function getIncidents()
	{
		$service = "Incidents";
		$method = "BusIncidents";
		$cache_key = "busIncidents";
		
		$return = "";
		
		$cache = craft()->cache->get($cache_key);
		if(! $cache)
		{
			$incidents = craft()->transit_api->call($service, $method);
			$return = $incidents['BusIncidents'];
			craft()->cache->set($cache_key, $return, 3600);
		} else {
			$return = craft()->cache->get($cache_key);
		}
		return $return;
	}
}
<?php

namespace Craft;

class Transit_IncidentService extends BaseApplicationComponent
{
	public function getRailIncidents()
	{
		$service = "Incidents";
		$method = "Incidents";
		$cache_key = "railIncidents";
		
		$return = "";
		$cache = craft()->cache->get($cache_key);
		if(! $cache)
		{
			$incidents = craft()->transit_api->call($service, $method);
			$return = $incidents['Incidents'];
			craft()->cache->set($cache_key, $return, 3600);
		} else {
			$return = craft()->cache->get($cache_key);
		}
		
		return $return;

	}

	public function getBusIncidents()
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
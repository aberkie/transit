<?php
	
namespace Craft;

class TransitVariable
{
	public function getAllStations()
	{
		return craft()->transit_station->getAllStations();
	}
	
	public function getKey()
	{
		return craft()->transit_key->getKey();
	}
	
	public function getNextTrains($station)
	{
		return craft()->transit_station->getNextTrains($station);
	}
}
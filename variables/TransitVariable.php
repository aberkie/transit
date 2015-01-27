<?php
	
namespace Craft;

class TransitVariable
{
	public function getKey()
	{
		return craft()->transit_key->getKey();
	}
	
	/* STATION VARIABLES */
	public function getAllStations()
	{
		return craft()->transit_station->getAllStations();
	}
	
	public function getNextTrains($station)
	{
		return craft()->transit_station->getNextTrains($station);
	}
	
	public function getStationInformation($station)
	{
		return craft()->transit_station->getStationInformation($station);
	}
}
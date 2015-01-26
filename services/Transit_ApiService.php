<?php
	
namespace Craft;

class Transit_ApiService extends BaseApplicationComponent
{
	
	protected $API_KEY;
	protected $default_service = "WMATA";
	
	
	public function __construct()
	{
		$api_key = craft()->transit_key->getKey($this->default_service);
		
		$this->API_KEY = $api_key;
	}
	
	public function call($service, $method, $params = null)
	{
		$base = "https://api.wmata.com/$service.svc/json/";
		$key = $this->API_KEY;
		$key_string = "api_key=$key";
		
		$url = $base.$method."?".$key_string;
						
		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$result = curl_exec($ch);
		if($result === false)
		{
			curl_close($ch);
			return false;
		} else {
			curl_close($ch);
			$json = json_decode($result, true);
			
			if(isset($json['statusCode']))
			{
				return false;
			} else {
				return $json;
			}
		}
	}
}
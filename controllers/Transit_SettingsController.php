<?php
	
namespace Craft;

class Transit_SettingsController extends BaseController
{
	
	public function actionSaveKey()
	{
		$new_key = false;
		$this->requirePostRequest();
		
		$api_key = craft()->request->getPost('api_key');
		$service = craft()->request->getPost('service');
		
		if($service == "")
		{
			$new_key = true;
			$service = "WMATA";
		}
		
		$api_model = array(
			"service" => $service,
			"api_key" => $api_key	
		);
		
		if($api_key == "")
		{
			craft()->userSession->setError(Craft::t('Key Field Required'));
			return; 
		} else {
			if($new_key)
			{
				$success = craft()->db->createCommand()->insert('transit_keys', $api_model);
				
				if($success)
				{
					craft()->userSession->setNotice(Craft::t('API Key saved'));
				}
			} else {
				
				$updates = array(
					"api_key" => $api_key,
				);
				
				$condition = "service = '$service'";
							
				$success = craft()->db->createCommand()->update('transit_keys', $updates, $condition);
				if($success)
				{
					craft()->userSession->setNotice(Craft::t('API Key saved'));
				}
			}
		}
	}
}
<?php
	
namespace Craft;

class Transit_StationsController extends BaseController
{
	
	public function actionRefreshStations()
	{
		$this->requirePostRequest();
		
		$success = craft()->transit_station->installStations();
		
		if($success)
		{
			craft()->userSession->setNotice(Craft::t('Stations Refreshed'));
		} else {
			craft()->userSession->setError(Craft::t('Refresh Failed'));
		}
	}
}
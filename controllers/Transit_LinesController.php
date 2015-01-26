<?php
	
namespace Craft;

class Transit_LinesController extends BaseController
{
	
	public function actionRefreshLines()
	{
		$this->requirePostRequest();
		
		$success = craft()->transit_line->installLines();
		
		if($success)
		{
			craft()->userSession->setNotice(Craft::t('Lines Refreshed'));
		} else {
			craft()->userSession->setError(Craft::t('Refresh Failed'));
		}
	}
}
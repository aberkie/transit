<?php
	
namespace Craft;

class Transit_KeyService extends BaseApplicationComponent
{
	
	protected $keyRecord;
	
	public function __construct($keyRecord = null)
	{
		if(is_null($this->keyRecord))
		{
			$this->keyRecord = Transit_KeyRecord::model();
		}
	}
	
	public function getKey($service = null)
	{
		if($service === null)
		{
			$records = $this->keyRecord->findAll();
		
			return Transit_KeyModel::populateModels($records);			
		} else {
			
			$condition = "service = '$service'";
			$records = $this->keyRecord->find($condition);
			
			$model = Transit_KeyModel::populateModel($records);
			
			return $model->api_key;
			
		}

	}
	
}
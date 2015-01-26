<?php
	
namespace Craft;

class TransitPlugin extends BasePlugin
{
	// ****
	// BASIC SETTINGS
	// ****
	function getName()
	{
		return Craft::t('Transit');
	}
	
	function getVersion()
	{
		return '0.1';
	}
	
	function getDeveloper()
	{
		return 'Aaron Berkowitz';
	}
	
	function getDeveloperUrl()
	{
		return 'https://github.com/aberkie';
	}
	
	// ****
	// PLUGIN SETTINGS
	// ****	
	

	public function hasCpSection()
	{
		return true;
	}
}
<?php 
namespace MediaLocation;

/**
* Primary Plugin class
*/
class Bootstrap 
{
	function __construct()
	{
		define('MEDIALOCATION_VERSION', '1.0.0');
		$this->pluginInit();
	}

	/**
	* General Theme Functions
	*/
	public function pluginInit()
	{
		new Settings\Settings;
		new Activation\Dependencies;
		new API\RegisterEndpoints;
		new Entities\MediaLibrary\Fields;
		new Events\RegisterAdminEvents;
	}
}
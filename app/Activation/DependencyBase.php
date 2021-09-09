<?php
namespace MediaLocation\Activation;

use MediaLocation\Settings\SettingsRepository;

abstract class DependencyBase
{
	/**
	* Settings Repository
	* @var obj
	*/
	protected $settings;

	public function __construct()
	{
		$this->settings = new SettingsRepository;
		$this->plugin_dir = \MediaLocation\Helpers::plugin_url();
	}

	/**
	* Register the Google Maps Script
	* Only Enqueue when needed
	*/
	protected function googleMaps()
	{
		if ( !is_admin() ) return;
		$api_key = $this->settings->googleMapsApi();
		if ( !$api_key ) return;
		$maps_url = 'https://maps.google.com/maps/api/js?key=' . $api_key . '&libraries=places';
		wp_register_script(
			'google-maps', 
			$maps_url
		);
	}
}
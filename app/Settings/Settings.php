<?php 
namespace MediaLocation\Settings;

use MediaLocation\Settings\SettingsRepository;

/**
* Settings page
*/
class Settings 
{
	/**
	* Settings Repository
	*/
	private $settings;	

	public function __construct()
	{
		$this->settings = new SettingsRepository;
		add_action( 'admin_menu', [$this, 'registerPage'] );
		add_action( 'admin_init', [$this, 'registerSettings'] );
	}

	/**
	* Add the admin menu item
	*/
	public function registerPage()
	{
		add_options_page( 
			'Media Location',
			'Media Location',
			'manage_options',
			'media-location', 
			[$this, 'settingsPage']
		);
	}

	/**
	* Register the settings
	*/
	public function registerSettings()
	{
		register_setting( 'media-location-general', 'media_location_google_api_key' );
	}

	/**
	* Display the Settings Page
	*/
	public function settingsPage()
	{
		$tab = ( isset($_GET['tab']) ) ? sanitize_text_field($_GET['tab']) : 'general';
		include( \MediaLocation\Helpers::view('settings/settings') );
	}
}
<?php 
namespace MediaLocation\Activation;

class Dependencies extends DependencyBase
{
	public function __construct()
	{
		parent::__construct();
		add_action( 'admin_enqueue_scripts', [$this, 'adminStyles']);
		add_action( 'admin_enqueue_scripts', [$this, 'adminScripts']);
	}

	/**
	* Theme Scripts – enqueue any unminified scripts needed here
	*/
	public function adminScripts()
	{
		$this->googleMaps();
		wp_enqueue_script('google-maps');
		wp_enqueue_script(
			'media-location-scripts',
			$this->plugin_dir . '/assets/js/admin-scripts.min.js',
			['jquery', 'jquery-ui-datepicker'],
			MEDIALOCATION_VERSION,
			true
		);
		$localized_data = [
			'rest_url' => get_rest_url() . 'media-location/v1',
			'nonce' => wp_create_nonce('media-location-nonce'),
		];
		wp_localize_script('media-location-scripts', 'media_location', $localized_data);
	}

	/**
	* Custom Admin Styles
	*/
	public function adminStyles()
	{
		wp_enqueue_style(
			'media-location-admin',
			$this->plugin_dir . '/assets/css/style-admin.css'
		);
	}
}
<?php
namespace MediaLocation\Settings;

class SettingsRepository
{
	public function googleMapsApi()
	{
		$option = get_option('media_location_google_api_key');
		return ( $option && $option !== '' ) ? $option : null;
	}
}
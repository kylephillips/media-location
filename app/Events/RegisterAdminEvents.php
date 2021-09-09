<?php
namespace MediaLocation\Events;

use MediaLocation\Listeners\UpdateLocation;

class RegisterAdminEvents
{
	public function __construct()
	{
		add_action('wp_ajax_media_location_update', [$this, 'locationUpdated']);
	}

	public function locationUpdated()
	{
		new UpdateLocation;
	}
}
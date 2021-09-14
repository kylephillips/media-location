<?php
namespace MediaLocation\Entities\MediaLibrary;

use ReplaceMedia\Services\MediaAttributes;

/**
* Add the "Replace Media" form field to the media library
*/
class Fields
{
	/**
	* MediaAttributes
	*/
	private $attributes;

	public function __construct()
	{
		add_filter('attachment_fields_to_edit', [$this, 'formFields'], 10, 2);
	}

	public function formFields($form_fields, $post)
	{
		$place_id = get_post_meta($post->ID, 'media_location_place_id', true);
		$place_name = get_post_meta($post->ID, 'media_location_place_name', true);
		$latitude = get_post_meta($post->ID, 'media_location_latitude', true);
		$longitude = get_post_meta($post->ID, 'media_location_longitude', true);
		$formatted_address = get_post_meta($post->ID, 'media_location_formatted_address', true);
		$date = get_post_meta($post->ID, 'media_location_date', true);

		if ( !$post ) return $form_fields;

		// Date Field
		ob_start();
		include(\MediaLocation\Helpers::view('date-field'));
		$html = ob_get_contents();
		ob_end_clean();
		$form_fields['media-location-date'] = [
			'label' => __('Date', "media-location"), 
			'input' => 'html', 
			'html' => $html
		];

		// Location Field
		ob_start();
		include(\MediaLocation\Helpers::view('location-field'));
		$html = ob_get_contents();
		ob_end_clean();
		$form_fields['media-location'] = [
			'label' => __('Location', "media-location"), 
			'input' => 'html', 
			'html' => $html
		];

		return $form_fields;
	}
}
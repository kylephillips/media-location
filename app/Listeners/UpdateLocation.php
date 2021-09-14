<?php
namespace MediaLocation\Listeners;

class UpdateLocation extends ListenerBase
{
	public function __construct()
	{
		parent::__construct();
		$this->savePlace();
		$this->respond();
	}

	/**
	* Save the place details or delete if empty
	*/
	private function savePlace()
	{
		if ( !isset($this->data['id']) ) {
			$this->response = ['status' => 'error', 'message' => __('No Attachment ID Provided', 'media-location')];
			return $this->respond();
		}

		$fields = ['place_id', 'place_name', 'formatted_address', 'latitude', 'longitude', 'has_place'];

		if ( $this->data['date'] !== '' ){
			update_post_meta(intval($this->data['id']), 'media_location_date', $this->data['date']);
		} else {
			delete_post_meta(intval($this->data['id']), 'media_location_date');
		}

		// If the place ID has been removed, delete this location
		if ( $this->data['has_place'] == '' ) :
			foreach ( $fields as $field ){
				delete_post_meta(intval($this->data['id']), 'media_location_' . $field);
			}
			$this->response = ['status' => 'success'];
			return;
		endif;

		// Update fields
		foreach ( $fields as $field ) :
			if ( isset($this->data[$field]) ) {
				update_post_meta(intval($this->data['id']), 'media_location_' . $field, sanitize_text_field($this->data[$field]));
			}
		endforeach;
		$this->response = ['status' => 'success'];
	}
}
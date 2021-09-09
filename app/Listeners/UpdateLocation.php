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
		$fields = ['place_id', 'place_name', 'formatted_address', 'latitude', 'longitude'];
		foreach ( $fields as $field ) :
			if ( isset($this->data[$field]) ) {
				update_post_meta(intval($this->data['id']), 'media_location_' . $field, sanitize_text_field($this->data[$field]));
			} else {
				delete_post_meta(intdiv($this->data['id'], 'media_location_' . $field));
			}
		endforeach;
		$this->response = ['status' => 'success'];
	}
}
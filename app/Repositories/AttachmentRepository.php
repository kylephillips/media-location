<?php
namespace MediaLocation\Repositories;

class AttachmentRepository
{
	public function getAttachment($id)
	{
		$post = get_post($id);
		$meta = get_post_meta($id);
		$fields = ['place_id', 'place_name', 'formatted_address', 'latitude', 'longitude'];
		foreach ( $fields as $field ) :
			$post->$field = ( isset($meta['media_location_' . $field]) && $meta['media_location_' . $field] !== '' )
				? $meta['media_location_' . $field][0] : null;
		endforeach;
		return $post;
	}
}
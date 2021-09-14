<?php $value = ( $formatted_address ) ? $formatted_address : ''; ?>
<div class="media-location-place-input">
	<input type="search" data-media-location-place-input placeholder="<?php _e('Enter a Location', 'media-location'); ?>" value="<?php echo $value; ?>" />
</div>

<input type="hidden" data-media-location-has_place value="<?php echo $place_id; ?>">
<input type="hidden" data-media-location-place_id value="<?php echo $place_id; ?>">
<input type="hidden" data-media-location-place_name value="<?php echo $place_name; ?>">
<input type="hidden" data-media-location-latitude value="<?php echo $latitude; ?>">
<input type="hidden" data-media-location-longitude value="<?php echo $longitude; ?>">
<input type="hidden" data-media-location-formatted_adddress value="<?php echo $formatted_address; ?>">

<div class="media-location-edit-map" data-media-location-map="<?php echo $post->ID; ?>"></div>

<button class="button" data-media-location-save><?php _e('Save Location', 'media-location');?></button>
<?php settings_fields( 'media-location-general' ); ?>
<div class="media-location-settings">
	<div class="row">
		<div class="title">
			<h4><?php _e('Google API Key', 'media-location'); ?></h4>
			<p><?php _e('The Javascript Maps and Places libraries must be enabled for this key. If there is another plugin that already enqueues the Google Maps script, leave this blank.', 'media-location'); ?></p>
		</div>
		<div class="field">
			<input type="text" name="media_location_google_api_key" value="<?php echo $this->settings->googleMapsApi(); ?>">
		</div>
	</div>
</div><!-- .media-location-settings -->
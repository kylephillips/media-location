/**
* Maps Functionality in Admin Media
* 
*/
var MediaLocationAdmin = MediaLocationAdmin || {};
MediaLocationAdmin.MapForm = function()
{
	var self = this;
	var $ = jQuery;

	self.post = null;
	self.place = null;
	self.map = null;
	self.mapMarker = null;

	self.selectors = {
		map : 'data-media-location-map',
		placeInput : 'data-media-location-place-input',
		dateInput : 'data-media-location-date-input',
		saveButton : 'data-media-location-save',
		placeIdField : 'data-media-location-has_place'
	}

	self.bindEvents = function()
	{
		if ( wp.media ){
			wp.media.view.Modal.prototype.on('open', function(data) {
				setTimeout(function(){
					self.initiateMedia();
				}, 200);
			});
			$(document).on('click', '.media-modal-content .attachments .attachment', function(){
				setTimeout(function(){
					self.initiateMedia();
				}, 300);
			});
		}
		// Temporary workaround for navigating media panel (ideally hook into event)
		$(document).on('click', '.edit-attachment-frame .edit-media-header', function(){
			setTimeout(function(){
				console.log('getting info');
				self.initiateMedia();
			}, 300);
		});
		$(document).on('click', '[' + self.selectors.saveButton + ']', function(e){
			e.preventDefault();
			self.updateLocation();
			self.enableDatePicker();
		});
		$(document).on('media-location-post-details-retrieved', function(){
			self.updateMap();
		});
		$(document).on('media-location-place-changed', function(){
			self.updateMap();
		});
		$(document).on('search', '[' + self.selectors.placeInput + ']', function(){
			var value = $(this).val();
			if ( value !== '' ) return;
			self.updatePlaceIdField(null);
			self.post.latitude = null;
			self.place = null;
			self.updateMap();
		});
	}

	self.initiateMedia = function()
	{
		self.getAttachmentData();
		self.enableAutocomplete();
		self.enableDatePicker();
	}

	/**
	* Enable Places Autocomplete on our input
	*/
	self.enableAutocomplete = function()
	{
		var input = $('[' + self.selectors.placeInput + ']');
		var autocomplete = new google.maps.places.Autocomplete(input[0]);
		google.maps.event.addListener(autocomplete, 'place_changed', function(){
			self.place = autocomplete.getPlace();
			$(document).trigger('media-location-place-changed');
		});
	}

	/**
	* Enable the datepicker
	*/ 
	self.enableDatePicker = function()
	{
		$('[' + self.selectors.dateInput + ']').datepicker({
			changeMonth: true,
			changeYear: true,
			beforeShow: function(input, inst) {
				$('#ui-datepicker-div').addClass('media-location-datepicker');
			}
		});
	}

	/**
	* Get the attachment data, including our lat/lng/place, through our custom endpoint
	* @see MediaLocation\API\RegisterEndpoints
	*/
	self.getAttachmentData = function()
	{
		var id = $('[' + self.selectors.map + ']').attr(self.selectors.map);
		$.ajax({
			url : media_location.rest_url + '/attachment',
			type : 'GET',
			data : {
				id : id
			},
			success: function(data){
				self.post = data;
				self.updatePlaceIdField(data.place_id);
				$(document).trigger('media-location-post-details-retrieved', [self.post]);
			},
			error: function(data){
				console.log(data);
			}
		});
	}

	/**
	* Update the map
	*/
	self.updateMap = function()
	{
		var container = $('[' + self.selectors.map + ']');
		var infoWindow = new google.maps.InfoWindow();

		var latitude = ( self.post.latitude ) ? parseFloat(self.post.latitude) : 35.3256357;
		var longitude = (self.post.longitude ) ? parseFloat(self.post.longitude) : -42.6099961;
		var zoom = ( self.post.latitude ) ? 14 : 1;

		if ( self.place ){
			latitude = self.place.geometry.location.lat();
			longitude = self.place.geometry.location.lng();
			zoom = 14;
			self.updatePlaceIdField(self.place.place_id);
		}
		var position = new google.maps.LatLng( latitude, longitude );
		
		var mapOptions = {
			mapTypeId: 'roadmap',
			mapTypeControl: false,
			zoom: zoom,
			panControl : false,
			disableDefaultUI: false,
			streetViewControl : false,
			zoomControl : false,
			center : position
		}

		self.map = new google.maps.Map( container[0], mapOptions );

		if ( (!self.post.latitude || !self.post.longitude) && !self.place ) return;
		
		if ( self.mapMarker ){
			self.mapMarker.setMap(null);
			self.mapMarker = null;
		}
		self.mapMarker = new google.maps.Marker({
			position: position,
			map: self.map,
			title : 'location'
		});	
	}

	/**
	* Update the location
	*/
	self.updateLocation = function()
	{
		self.toggleLoading(true);
		var data = {};
		data.action = 'media_location_update';
		data.nonce = media_location.nonce;
		data.id = $('[' + self.selectors.map + ']').attr(self.selectors.map);
		data.place_id = ( self.place ) ? self.place.place_id : $('[data-media-location-place_id]').val();
		data.place_name = ( self.place ) ? self.place.name : $('[data-media-location-place_name]').val();
		data.latitude = ( self.place ) ? self.place.geometry.location.lat() : $('[data-media-location-latitude]').val();
		data.longitude = ( self.place ) ? self.place.geometry.location.lng() : $('[data-media-location-longitude]').val();
		data.formatted_address = ( self.place ) ? self.place.formatted_address : $('[data-media-location-formatted_adddress]').val();
		data.has_place = $('[' + self.selectors.placeIdField + ']').val();
		data.date = $('[' + self.selectors.dateInput + ']').val();
		$.ajax({
			url : ajaxurl,
			type : 'POST',
			data : data,
			success: function (data){
				self.toggleLoading(false);
			},
			error: function(data){
				console.log(data);
				self.toggleLoading(false);
			}
		});
	}

	/**
	* Update the Place ID field - for keeping locations on save without change, and for removing locations
	*/
	self.updatePlaceIdField = function(value)
	{
		var field = $('[' + self.selectors.placeIdField + ']');
		if ( value ){
			$(field).val(value);
			return;
		}
		$(field).val('');
	}

	/**
	* Toggle Loading State
	*/
	self.toggleLoading = function(loading)
	{
		var button = $('[' + self.selectors.saveButton + ']');
		if ( loading ){
			$(button).attr('disabled', true);
			return;
		}
		$(button).removeAttr('disabled');
	}
	
	return self.bindEvents();
}
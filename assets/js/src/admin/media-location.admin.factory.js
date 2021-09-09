/**
* Primary Plugin Admin Scripts Initialization
*
*/
var MediaLocationAdmin = MediaLocationAdmin || {};

jQuery(document).ready(function(){
	new MediaLocationAdmin.Factory;
});

/**
* Primary factory class
*/
MediaLocationAdmin.Factory = function()
{
	self.build = function()
	{
		new MediaLocationAdmin.MapForm;
	}

	return self.build();
}
jQuery.noConflict(); // Reverts '$' variable back to other JS libraries
jQuery(document).ready( function(){ 
	var mediaUploader;
	jQuery('#upload-document').click(function(e) {
    e.preventDefault();

    // Create the media frame.
      var file_frame = wp.media.frames.file_frame = wp.media({
		title: 'Select or upload image',
		button: {
            text: 'Select'
		},
         multiple: false  // Set to true to allow multiple files to be selected
      });

		file_frame.on('select', function () {
			 // We set multiple to false so only get one image from the uploader
	 
			 var attachment = file_frame.state().get('selection').first().toJSON();
	 
			jQuery('#showLink').html(attachment.url);
			jQuery('#document_link').val(attachment.url);
			jQuery('#fileError').text("");
		  });
 
      // Finally, open the modal
      file_frame.open();
	});
	jQuery("#removeDoc").on('click',function(){
		jQuery(this).parent().parent().remove();
		jQuery("#uploadDoc").show();
		jQuery('#document_link').val('');
	});	
});  


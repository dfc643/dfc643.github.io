jQuery(document).ready(function($) {
	var $et_no_images = $('#et_no_images'),
		$et_pagination_link = $('#et_attachments_pagination a'),
		$et_used_images_container = $('#et_used_images'),
		$et_available_images_container = $('#et_available_images'),
		$et_used_li = $('#et_used_images li');
	
	$et_used_images_container.sortable( {
		forcePlaceholderSize: true,
		cancel: '.et_delete, .et_image_edit, input, textarea, label, .et_image_save'
	} );
	
	$('body').delegate('#et_available_images li','click', function(){
		var $this_li = $(this),
			$cloned_li,
			title, description, attachment_id;
		
		if ( $this_li.hasClass('et_added') ) return;
		
		$this_li.addClass('et_added');
		title = $this_li.attr('data-attachment_title');
		description = $this_li.attr('data-attachment_description');
		attachment_id = $this_li.attr('data-attachment_id');
		
		$cloned_li = $this_li.clone().removeClass('et_added').removeAttr('data-attachment_title').removeAttr('data-attachment_description');
		
		$et_used_images_container.append( $cloned_li );
		$cloned_li.append( '<div class="et_image_options">' + '<input type="hidden" name="et_used_image_id[]" value="' + attachment_id + '" />' + '</div>' );

		if ( $et_no_images.is(':visible') ) $et_no_images.hide();
	} );
	
	$('body').delegate('span.et_delete','click', function(){
		var $this = $(this),
			attachment_id = $this.parent('li').attr('data-attachment_id');
		
		$et_available_images_container.find('li[data-attachment_id="'+attachment_id+'"]').removeClass('et_added');
		$this.parent('li').remove();
		
		if ( ! $et_used_images_container.find('li').length ) $et_no_images.show();
	} );
	
	$et_pagination_link.click( function(){
		var $this_link = $(this),
			link_value = $this_link.text(),
			nonce = $this_link.closest('#et_settings_meta_box').find('input#et_settings_nonce').val();
		
		if ( $this_link.hasClass('et_active_page') ) return false;
		
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data:
			{
				action : 'et_show_attachments_page',
				et_settings_nonce : nonce,
				et_page: link_value
			},
			success: function(data){
				$this_link.addClass('et_active_page').siblings().removeClass();
				$et_available_images_container.html(data);
				$et_available_images_container.find('li').each( function(){
					var $this = $(this),
						attachment_id = $this.attr('data-attachment_id');
						
					if ( $et_used_images_container.find('li[data-attachment_id="' + attachment_id + '"]').length ) $this.addClass('et_added');
				} );
			}
		});
		
		return false;
	} );
	
	if ( $et_used_images_container.find('li').length ) $et_no_images.hide();
});
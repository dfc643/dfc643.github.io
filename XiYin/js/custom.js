(function($){
	$(document).ready(function(){
		var $audio_slider 		= $('.audio_slider'),
			$audio_box 			= $audio_slider.find( '.audio_image' ),
			$homepage_player 	= $('#et_main_audio_player'),
			$comment_form 		= $('form#commentform'),
			$main_playlist		= $('#main_audio_playlist'),
			$main_menu 			= $('ul.nav'),
			$et_main_nav		= $('#main-nav .container');
			
		if ( $et_main_nav.length ) $et_main_nav.prepend( '<div id="mobile_links">' + '<a href="#" class="mobile_nav closed">' + et_custom.mobile_nav_text + '<span></span>' + '</a>' + '</div>' );
			
		$main_menu.superfish({ 
			delay		: 300, // delay on mouseout 
			animation	: { opacity : 'show', height : 'show' }, // fade-in and slide-down animation 
			speed		: 'fast', // faster animation speed 
			autoArrows	: true, // disable generation of arrow mark-up 
			dropShadows	: false // disable drop shadows 
		});
	
		if ( $homepage_player.length && $audio_slider.length && $audio_box.length > 1 ){
			if ( $( 'html#ie8' ).length ) {
				$audio_box.hide().eq(0).show();
			}
			
			$audio_box.find( '.audio_meta' ).append( '<a href="#" class="et_player_prev"></a>' + '<a href="#" class="et_player_next"></a>' );
			
			$( '.et_player_prev' ).click( function(){
				et_main_playlist.previous();
				et_change_audiotrack( 'previous' );
				return false;
			} );
			
			$( '.et_player_next' ).click( function(){
				et_main_playlist.next();
				et_change_audiotrack( 'next' );
				return false;
			} );
			
			$main_playlist.find( 'li' ).click( function(){
				var $this_item 		= $(this),	
					this_item_index = $this_item.index();
				
				if ( $this_item.hasClass( 'active_song' ) ) return;
				
				et_main_playlist.play( this_item_index );
				et_change_audiotrack( this_item_index );
			} );
			
			$homepage_player.bind( $.jPlayer.event.ended, function(event) {
				et_change_audiotrack( 'next' );
			} );
		}
		
		$('#main-area').fitVids();
		
		$comment_form.find('input:text, textarea').each(function(index,domEle){
			var $et_current_input = jQuery(domEle),
				$et_comment_label = $et_current_input.siblings('label'),
				et_comment_label_value = $et_current_input.siblings('label').text();
			if ( $et_comment_label.length ) {
				$et_comment_label.hide();
				if ( $et_current_input.siblings('span.required') ) { 
					et_comment_label_value += $et_current_input.siblings('span.required').text();
					$et_current_input.siblings('span.required').hide();
				}
				$et_current_input.val(et_comment_label_value);
			}
		}).bind('focus',function(){
			var et_label_text = jQuery(this).siblings('label').text();
			if ( jQuery(this).siblings('span.required').length ) et_label_text += jQuery(this).siblings('span.required').text();
			if (jQuery(this).val() === et_label_text) jQuery(this).val("");
		}).bind('blur',function(){
			var et_label_text = jQuery(this).siblings('label').text();
			if ( jQuery(this).siblings('span.required').length ) et_label_text += jQuery(this).siblings('span.required').text();
			if (jQuery(this).val() === "") jQuery(this).val( et_label_text );
		});

		$comment_form.find('input#submit').click(function(){
			if (jQuery("input#url").val() === jQuery("input#url").siblings('label').text()) jQuery("input#url").val("");
		});
		
		et_duplicate_menu( $('ul.nav'), $('#main-nav #mobile_links'), 'mobile_menu', 'et_mobile_menu' );
		
		if ( $('ul.et_disable_top_tier').length ) $("ul.et_disable_top_tier > li > ul").prev('a').attr('href','#');
		
		function et_change_audiotrack( option ){
			var $current_item 		= $main_playlist.find( '.active_song' ),
				current_item_index 	= $current_item.index(),
				play_next_index;
				
			if ( 'next' == option && ! $current_item.next( 'li' ).length ) return;
			if ( 'previous' == option && ! $current_item.prev( 'li' ).length ) return;
			
			if ( 'next' == option ) play_next_index = current_item_index + 1;
			else if ( 'previous' == option ) play_next_index = current_item_index - 1;
			else play_next_index = option;
			
			$audio_slider.find( '.audio_image' ).eq( current_item_index ).animate( { opacity : 0 }, 200, function(){
				$(this).css( 'display', 'none' );
				$audio_slider.find( '.audio_image' ).eq( play_next_index ).css( { 'display' : 'block', 'opacity' : '0' } ).animate( { opacity : 1 }, 200 );
			} );
			
			$current_item.removeClass( 'active_song' );
			$main_playlist.find( 'li' ).eq( play_next_index ).addClass( 'active_song' );
		}

		function et_duplicate_menu( menu, append_to, menu_id, menu_class ){
			var $cloned_nav;
			
			menu.clone().attr('id',menu_id).removeClass().attr('class',menu_class).appendTo( append_to );
			$cloned_nav = append_to.find('> ul');
			$cloned_nav.find('.menu_slide').remove();
			$cloned_nav.find('li:first').addClass('et_first_mobile_item');
			
			append_to.find( '.mobile_nav' ).click( function(){
				if ( $(this).hasClass('closed') ){
					$(this).removeClass( 'closed' ).addClass( 'opened' );
					$cloned_nav.slideDown( 500 );
				} else {
					$(this).removeClass( 'opened' ).addClass( 'closed' );
					$cloned_nav.slideUp( 500 );
				}
				return false;
			} );
			
			append_to.find('a').click( function(event){
				event.stopPropagation();
			} );
		}
	});
})(jQuery)
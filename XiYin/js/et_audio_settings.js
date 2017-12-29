(function($){
	$(document).ready( function(){
		$et_audio_format 		= $( '#post-format-audio' ),
		$et_audio_settings_box 	= $( '#et_audio_post_settings' ),
		$et_post_format_cb		= $( 'input.post-format' );
		
		if ( $et_audio_format.is( ':checked' ) )
			$et_audio_settings_box.show();
			
		$et_post_format_cb.click( function(){
			if ( 'post-format-audio' != $(this).attr( 'id' ) ) $et_audio_settings_box.hide();
			else $et_audio_settings_box.show();
		} );
	} );
})(jQuery)
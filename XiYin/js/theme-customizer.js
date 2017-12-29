/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	wp.customize( 'et_harmony[link_color]', function( value ) {
		value.bind( function( to ) {
			$( '#main-area a' ).css( 'color', to );
		} );
	} );
	
	wp.customize( 'et_harmony[font_color]', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( 'color', to );
		} );
	} );
	
	wp.customize( 'et_harmony[logo_color]', function( value ) {
		value.bind( function( to ) {
			$( '#main-header hgroup h1, #main-header hgroup h2' ).css( 'color', to );
		} );
	} );
} )( jQuery );
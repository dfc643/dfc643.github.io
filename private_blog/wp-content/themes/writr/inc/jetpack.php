<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Writr
 */

function writr_jetpack_setup() {

	/**
	 * Add theme support for Infinite Scroll.
	 * See: http://jetpack.me/support/infinite-scroll/
	 */
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );

	/**
	 * Add theme support for Social Links.
	 * See: http://jetpack.me/support/social-links/
	 */
	add_theme_support( 'social-links', array(
    	'facebook',
    	'twitter',
    	'google_plus',
    	'linkedin',
    	'tumblr',
	) );

	/**
	 * Add theme support for Responsive Videos.
	 */
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'writr_jetpack_setup' );
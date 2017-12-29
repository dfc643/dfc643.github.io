=== ILWP Colored Tag Cloud ===
Contributors: stevejohnson
Donate link: http://ilikewp.com/donate/
Tags: tag cloud, colored tag cloud
Requires at least: 2.8
Tested up to: 4.2.4
stable tag: 2.4.2

Displays a configurable colored tag cloud as a widget, or in your template, or both.

== Description ==

Displays a configurable colored tag cloud as a widget, or in your template, or both.

== Installation ==

Installation is easy:
* Install automatically through the Add New plugin page in WordPress, -or-

To manually install:

* Download and unzip the plugin file.
* Copy the folder to the plugins directory of your blog.
* Enable the plugin in your admin panel.
* Each widget can now be configured in its widget menu

== Using in templates ==
Use the function in your theme files if desired. It is always advisable to wrap
the function call in an 'if function_exists' statement.

Usage:
if ( function_exists( 'ilwp_colored_tag_cloud' )
	ilwp_colored_tag_cloud( $options = array() );

Available options, and their defaults:

		$default_colors = array(	'aqua', 'black', 'blue', 'fuchsia',
									'gray', 'green', 'lime', 'maroon',
									'navy', 'olive', 'purple', 'red',
									'silver', 'teal', 'white', 'yellow');

		$default['min_size']		= 8;
		$default['max_size']		= 40;
		$default['number']			= 0;
		$default['use_colors']		= 1;
		$default['use_color_names']	= 1;
		$default['sort']			= 'random';
		$default['order']			= 'ASC';
		$default['color_names']		= $default_colors;

== Changelog ==
= 2.4.1 =
* Fixed an echo error in the shortcode handler.

= 2.4 =
* Added a shortcode handler, see the plugin page at http://ilikewp.com/colored-tag-cloud-for-wordpress-blogs/ for details on usage.

= 2.3 =
* Removed deprecated functions, tested with WP v 3.6-alpha

= 2.1 =
* Minor update for later WP versions 3.1 and up.

= 2.0.2 =
* Added a sort order option, allowing users to sort the cloud in either direction. Added functionality so that if 'color names' field is left blank, colors default to the default color set.

= 2.0.1 =
* v2.0 introduced an error, "missing argument in line 30" for users calling the function directly from their templates. This has been fixed.

= 2.0 =
* Added sort option - Name, Most Used, Random
* Updated to multi-instance widget using WordPress WP_Widget API

= 1.3 =
* Updated for WP 3.0.

= 1.2 =
* changed the way default options are handled on initialization
* changed to retrieve top tags before random sort of tag cloud

= 1.1 =
* Added option to control # of tags displayed.

== Upgrade Notice ==

= 2.0.2 =
* This is a minor upgrade, adding a sort order to the options panel for each widget.

= 2.0.1 =
* You should apply this upgrade if you are calling the ilwp_colored_tag_cloud function directly from your template.
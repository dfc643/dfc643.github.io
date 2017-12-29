=== Writr ===

Contributors: automattic
Requires at least: 4.1
Tested up to: 4.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Writr is a minimalist, content-oriented tumblelog theme perfect for your personal blog. It comes packed with 6 different color schemes: turquoise (default), blue, green, grey, purple, and red. With a modern look and attention to crisp typography, Writr put the focus on your content.

* Responsive layout.
* Custom Header.
* Jetpack.com compatibility for Infinite Scroll, Responsive Videos and Social Links.
* The GPL v2.0 or later license. :) Use it to make something cool.

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Credits ==

* Based on Underscores http://underscores.me/, (C) 2012-2017 Automattic, Inc., licensed under [GPL2](https://www.gnu.org/licenses/gpl-2.0.html)
* normalize.css http://necolas.github.io/normalize.css/, (C) 2012-2017 Nicolas Gallagher and Jonathan Neal, licensed under [MIT](http://opensource.org/licenses/MIT)
* Genericons: font by Automattic (http://automattic.com/), licensed under [GPL2](https://www.gnu.org/licenses/gpl-2.0.html)
* Images: images by Unsplash (https://unsplash.com), licensed under [CC0](http://creativecommons.org/choose/zero/)

== Changelog ==

= 24 November 2017 =
* Update copyright date
* Be more specific with CSS element `#site-navigation .menu-toggle` to make sure the correct colour is applied

= 5 May 2017 =
* Check for post parent object before outputting post parent information to prevent fatals.

= 3 May 2017 =
* Check for post parent before outputting next, previous, and image attachment information to prevent fatals.

= 22 March 2017 =
* add Custom Colors annotations directly to the theme
* move fonts annotations directly into the theme

= 2 February 2017 =
* remove from CSS in wp-content/themes/pub

= 26 January 2017 =
* Check for is_wp_error() before outputting results from get_the_tag_list() to avoid fatal errors.

= 9 June 2016 =
* Add Headstart annotations;

= 7 June 2016 =
* Update screenshot
* Increase minimum WordPress version needed
* Use title-tag
* Add credits to readme
* Make sure Entry Format Badge isn't being display on small screens.

= 27 May 2016 =
* fix the behavior of `*_the_attached_image()` for PHP 7 compat

= 26 May 2016 =
* Style jetpack-video-wrapper only if it's the 1st element

= 12 May 2016 =
* Add new classic-menu tag.

= 12 April 2016 =
* Fix menu expansion on mobile. Closes #3769

= 2 November 2015 =
* Made selector to show/hide menu-toggle more specific, so it cannot be overwritten by Genericon styles when creating child theme.

= 20 August 2015 =
* Add text domain and/or remove domain path. (T-Z)

= 19 August 2015 =
* Remove colour scheme setting in theme options for .com.

= 14 August 2015 =
* Be more specific when targeting genericon post format to prevent font-size being overridden in a child theme.

= 31 July 2015 =
* Remove `.screen-reader-text:hover` and `.screen-reader-text:active` style rules.

= 15 July 2015 =
* Always use https when loading Google Fonts.

= 8 April 2015 =
* Fix site-branding position so if site-title/site-desc are being hidden it doesn't break layout on mobile devices when sidebar is open.
* Add z-index property to dropdown-icon so it's clickable on mobile devices.
* Remove media query regarding small screens like iPhone 4.

= 5 March 2015 =
* Allow videos to expand to the full size of the column rather than restricted to 460px;

= 26 January 2015 =
* Make sure the body's padding isn't overwritten by the post editor's own styles.

= 29 November 2014 =
* Prefix an Eventbrite template tag. Bump version to 1.2.1.

= 26 November 2014 =
* Add support for upcoming Eventbrite services.

= 6 November 2014 =
* Revert the js fix for sub menus as testing on Penscratch

= 5 November 2014 =
* Fix for menus
* Patch attempt for mobile menus not showing on larger screens

= 27 October 2014 =
* Style comment navigation
* Make navigation selectors more specific so posts tagged "navigation" don't inherit post or paging navigation formatting.

= 22 August 2014 =
* Fix typo in sanitization callback -- color scheme theme option wasn't working.

= 7 August 2014 =
* Update clearing selectors; greedy selectors were causing an odd printing error in Firefox.

= 24 July 2014 =
* change theme/author URIs and footer links to `wordpress.com/themes`.

= 8 July 2014 =
* Increase content width to match max mobile width

= 4 July 2014 =
* Declare get_sidebar() in header.php to avoid moving #secondary using Javascript -- Was creating issues with Twitter Widget that couldn't be displayed.
* Reorganise javascript file and cleanup
* De-unregister Gallery Widget. Found a fix with .resize().
* Add sanitization callback to Theme Options in customizer

= 3 July 2014 =
* New Javascript to reorganize elements and fix sidebar positioning issue. See #2469, #2478.

= 1 June 2014 =
* add/update pot files.

= 8 May 2014 =
* Add margin bottom to .jetpack-video-wrapper and not just video post format specific

= 6 May 2014 =
* Revert 17280 so site-footer stay floated.

= 14 April 2014 =
* Remove self-hosted responsive video to instead add theme support for jetpack's responsive videos

= 13 March 2014 =
* Fix bug where new blogs with no new posts displayed the footer underneath the content area when logged out.

= 6 March 2014 =
* Fix an issue where the main and sub-menu toggles were being cut off on small devices like the iPhone 4.

= 4 March 2014 =
* Some more tweaks to the sharing and likes display.
* Fix display issues for the likes & sharing widgets.

= 28 February 2014 =
* Change text strings to reduce theme string proliferation.

= 5 February 2014 =
* Setting relative positioning on the body tag creates problems with the positioning of the admin bar/header. Removing it does not

= 24 January 2014 =
* Add custom style for a11s new sharedaddy

= 23 January 2014 =
* correct escaping for attribute text.

= 15 January 2014 =
* Add background color to .content-area -- Partially "fixes" #2146

= 2 January 2014 =
* Removed WPCOM responsive video support and updated inbuilt version. I prefer to use inbuilt instead of WPCOM because Writr is also available on .org

= 17 December 2013 =
* Remove writr_embed_html() extra arguments
* Update responsive videos plugin with add_theme_support()

= 9 December 2013 =
* Remove negative top margin for entry-thumbnail.

= 6 December 2013 =
* Hide Color Scheme option on WordPress.com.
* update Width terms to Layout.

= 4 December 2013 =
* Update PO file with latest version

= 3 December 2013 =
* Update changelog with latest version description
* Increase version number to 1.0.7
* Add Featured Image on single post/page.
* Add Google+ as a Connect option to Writr.
* Increase VideoPress width when wider content area is enabled for a12s.

= 18 November 2013 =
* Remove transition effects from text areas to prevent the comments form from becoming jumpy after 7 lines of text.

= 15 November 2013 =
* better check for default color scheme option to avoid a 404 for empty CSS file.

= 12 November 2013 =
* Add style for Related Posts

= 11 November 2013 =
* Fix Google+ sharing margin/padding issue + Fix RTL video wrapper typo and add WPCOM responsive videos support

= 7 November 2013 =
* tighten up the theme description.
* Add support for WPCOM Responsive videos plugin

= 6 November 2013 =
* Update theme's description
* Fix Walker_Nav_Menu() php errors + Add readme.txt + Update version number and description

= 4 November 2013 =
* Add wider editor style -- depending on theme options
* Add styles for Links widget, Twitter widget, Top Posts & Pages widget
* Fix margin issue between page pagination and like/share

= 2 November 2013 =
* Update version number

= 1 November 2013 =
* New responsive video JS to let users change the size of the videos and not be 100% automatically
* Generate a .pot file
* Add new theme option: Wider Content Area
* Changed version number
* Back to version 1.0 -- I don't like a wider version of Writr
* New version, 1.1:

= 31 October 2013 =
* fixed undefined writr_categorized_blog function in 404.php.
* Display navigation only if user configured Primary Menu
* New screenshot without the categories
* Remove categories from the front end

= 29 October 2013 =
* Changed removeAttr( 'style' ) to css( 'margin-top', 0 ) to avoid removing the display block if the screen is resized
* Check if theme has widgets. If not adds a negative margin-top to #colophon instead of #secondary

= 28 October 2013 =
* Remove orange tag since the orange color scheme has been previously removed
* Fix margin issue if comments are closed

= 25 October 2013 =
* Removed .current_page_item & .current-menu-item styles from mobile devices
* Add add_size_image to make sure the featured thumbnail will 100% fit the .entry-thumbnail area
* New dropdown submenu design + New responsive design RTL style

= 24 October 2013 =
* Cleaned JS + Removed whitespace
* Add dropdown submenu on mobile devices
* Multiple changes:

= 23 October 2013 =
* Update theme screenshot
* Change wpcom bg color back to white to fix Comments color scheme issue + Wrap $themecolors in a conditional statement

= 22 October 2013 =
* Update theme version: "-wpcom" added
* Color annotations:
* Change video CSS classes to avoid conflict with VideoPress + Fix VideoPress padding and margin
* Unregister Gallery Widget, not working properly - will need patch
* Add style for Goodreads widget

= 21 October 2013 =
* Add style for WPStats image
* Remove all of the trailing whitespace
* Add style for Recent comments widget
* Update style for Grid view Widget
* Add style for Milestone widget
* Add style for Instagram widget
* Add style for Image widget
* Add style for Gravatar widget
* Add style for Flickr widget
* Add style for Contact Info widget
* Add styles for Category Cloud & Tag Cloud Widgets
* Add style for grid view widget
* Add print rules + Hide widget-title if empty

= 11 October 2013 =
* Add style for Akismet widget
* Add style for About.me widget + Modified footer style
* Multiple changes:

= 10 October 2013 =
* Change default colour to Turquoise and remove Orange stylesheet
* Remove default widget if user has no widget
* Initial import of the .org version of the Writr theme

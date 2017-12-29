<?php
/**
 * Plugin Name: ILWP Colored Tag Cloud
 * Plugin URI: http://ilikewp.com/colored-tag-cloud/
 * Description: An expansion of the standard WP tag cloud widget. Adds colors, min/max sizes, sort order and other options. For more info on the <acronym title="I Like WordPress!">ILWP</acronym> Colored Tag Cloud plugin, please <a href="http://ilikewp.com/colored-tag" title="The ILWP Colored Tag Cloud plugin home page">visit the plugin page</a>. Feel free to leave comments or post feature requests.
 * Version: 2.4.2
 * Author: Steve Johnson
 * Author URI: http://ilikewp.com/
 */

/*  Copyright 2009-2012 Steve Johnson  ( email : steve@ilikewp.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    ( at your option ) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

	define( 'ILWP_CTC_VERSION', '2.3' );
	define( 'CTC_DEBUG', false );
	
	function ilwp_tag_cloud( $args = '' ) {
		// for those calling the function directly from template,
		// add default arguments
		
		$defaults = array(
			'color_names'		=> array( 'aqua', 'black', 'blue', 'fuchsia',
									'gray', 'green', 'lime', 'maroon',
									'navy', 'olive', 'purple', 'red',
									'silver', 'teal', 'white', 'yellow' ),
			'min_size'			=> 8,
			'max_size'			=> 40,
			'use_colors'		=> 1,
			'number'			=> 0,
			'sort'				=> 'random',
			'order'			=> 'ASC',
			'title'			=> '',
		);

		$args = wp_parse_args( $args, $defaults );
		
		## if they leave the colors field blank
		if ( '' == $args['color_names'][0] )
			$args['color_names'] = $default_colors;
		
		// Always query top tags
		$tags = get_tags( array( 'orderby' => 'count', 'order' => 'DESC' ) );
		if ( empty( $tags ) || 2 > sizeof( $tags ) || !is_array( $tags ) )
			return;

		$return = ilwp_generate_tag_cloud( $tags, $args ); // Here's where those top tags get sorted according to $args

		if ( is_wp_error( $return ) )
			return false;
		return $return;
	}

	function ilwp_generate_tag_cloud( $tags, $args = '' ) {
		global $wp_rewrite;

		extract( $args );
		// $min_size, $max_size, $number, $color_names, $use_colors, $sort, $order

		if ( 'random' == $sort ) {
			shuffle( $tags );
		} else {
			// SQL cannot save you; this is a second ( potentially different ) sort on a subset of data.
			if ( 'name' == $sort )
				uasort( $tags, create_function( '$a, $b', 'return strnatcasecmp( $a->name, $b->name );' ) );
			else
				uasort( $tags, create_function( '$a, $b', 'return ( $a->count > $b->count );' ) );
			if ( 'DESC' == $order )
				$tags = array_reverse( $tags, true );
		}

		if ( $number > 0 )
			$tags = array_slice( $tags, 0, $number );
		
		$counts = $tag_links = array();
		foreach ( $tags as $tag ) {
			$counts[ $tag->name ] = $tag->count;
			$tag_links[ $tag->name ] = get_tag_link( $tag->term_id );
			$tag_ids[ $tag->name ] = $tag->term_id;
		}
		
		$min_count = min( $counts );
		$spread = max( $counts ) - $min_count;
		if ( $spread <= 0 )
			$spread = 1;
		$font_spread = $max_size - $min_size;
		
		if ( $font_spread <= 0 )
			$font_spread = 1;
		$font_step = $font_spread / $spread;
		
		
		$a = array();
		
		$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? ' rel="tag"' : '';
		$c = sizeof( $color_names );
		foreach ( $counts as $tag => $count ) {
			$tag_id = $tag_ids[$tag];
			$tag_link = esc_url( $tag_links[$tag] );
			if ( $use_colors ) :
				$color = rand( 0, $c - 1 );
				$colorstyle = " color: " . $color_names[$color] . ";";
			else :
				$colorstyle = "";
			endif;
			$a[] = "<a href='$tag_link' class='tag-link-$tag_id' title='" . esc_attr( sprintf( _n( '%d post is','%d posts are', $count ), $count ) ) . " tagged with &ldquo;$tag&rdquo;'$rel style='font-size: " .
				( $min_size + ( ( $count - $min_count ) * $font_step ) )
				. "px; $colorstyle'>$tag</a>";
		}
		$cloud = join( "\n", $a );
		$cloud = "<div class='colored-tag-cloud'>" . $cloud . "</div>" . PHP_EOL;
		return $cloud;
	}
	
	function ilwp_tc_setup() {
		if ( '2.3' != get_option( 'widget_ilwp_tag_cloud_version', true ) )
			update_option( 'widget_ilwp_tag_cloud_version', '2.3' );
		// removes earlier version option settings
		if ( get_option( 'ilwp_widget_tag_cloud' ) )
			delete_option( 'ilwp_widget_tag_cloud' );
	}
	add_action( 'init', 'ilwp_tc_setup' );
	
	/**
	* ILWPColoredTagCloud shortcode handler
	*/
	function ilwp_shortcode( $atts ) {
		/** never trust user input */
		if ( isset( $atts['color_names'] ) ) {
			$colors = explode( ',', $atts['color_names'] );
			foreach ( $colors as $key => $color ) {
				$color = strtolower( $color );
				/** strip everything but a-z */
				$colors[$key] = preg_replace( "/[^a-z]/i", '', $color );
			}
			$atts['color_names'] = $colors;
		}
		if ( isset( $atts['number'] ) )
			$atts['number'] = intval( $atts['number'] );
		if ( isset( $atts['max_size'] ) )
			$atts['max_size'] = intval( $atts['max_size'] );
		if ( isset( $atts['min_size'] ) )
			$atts['min_size'] = intval( $atts['min_size'] );
		if ( isset( $atts['sort'] ) )
			$atts['sort'] = ( in_array( $atts['sort'], array( 'count', 'name', 'random' ) ) ) ? strtolower( $atts['sort'] ) : 'random';
		if ( isset( $atts['order'] ) )
			$atts['order'] = ( 'ASC' == strtoupper( $atts['order'] ) ) ? 'ASC' : 'DESC';
		if ( isset( $atts['use_colors'] ) )
			$atts['use_colors'] = ( in_array( $atts['use_colors'], array( 0, false, 'no') ) ) ? 0 : 1;
		
		return ilwp_tag_cloud( $atts );
	}
	add_shortcode( 'coloredtagcloud', 'ilwp_shortcode' );
	
	/**
	* ILWPColoredTagCloud Widget
	*/
	class ILWPColoredTagCloud extends WP_Widget {

		function ILWPColoredTagCloud() {
			$widget_ops = array( 'classname' => 'ilwp_widget_tag_cloud', 'description' => __( "A really cool COLORED tag cloud" ) );
			$control_ops = array( 'width' => 400, 'height' => 350 );
			parent::__construct( 'ilwp_tag_cloud', __( 'ILWP Colored Tag Cloud' ), $widget_ops, $control_ops );
		}

		/** @see WP_Widget::widget */
		function widget( $args, $instance ) {
			extract( $args );

			$title = ( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Tags' ) ;
			
			echo $before_widget;
			echo $before_title . $title . $after_title;
			echo ilwp_tag_cloud( $instance );
			echo $after_widget . "\n\n";
		}

		/** @see WP_Widget::update */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['number'] = ( 0 == $new_instance['number'] ) ? 0 : intval( $new_instance['number'] );
			$instance['min_size'] = ( $new_instance['min_size'] > 10 ) ? 10 : intval( $new_instance['min_size'] );
			$instance['max_size'] = ( $new_instance['max_size'] > 40 && $instance['min_size'] < $new_instance['max_size'] ) ? 40 : intval( $new_instance['max_size'] );
			if ( $instance['max_size'] < $instance['min_size'] + 2 )
				$instance['max_size'] = intval( $instance['min_size'] + 2 );
			$instance['use_colors'] = $new_instance['use_colors'];
			$instance['sort'] = $new_instance['sort'];
			$instance['order'] = $new_instance['order'];

			## get color names/numbers into an array
				$str = $new_instance['color_names'];
				## replace commas with spaces
				$str = str_replace( ',', ' ', $str );
				## replace spaces with pipes
				$str = preg_replace( '/\s+/', '|', $str );
				$str = trim( $str, "|" );
				$newcolors = explode( '|', $str );				
			$instance['color_names'] = $newcolors;
			
			return $instance;
		}

		/** @see WP_Widget::form */
		function form( $instance ) {

			$defaults = array(
				'color_names'		=> array( 'aqua', 'black', 'blue', 'fuchsia',
										'gray', 'green', 'lime', 'maroon',
										'navy', 'olive', 'purple', 'red',
										'silver', 'teal', 'white', 'yellow' ),
				'min_size'			=> 8,
				'max_size'			=> 40,
				'use_colors'		=> 1,
				'number'			=> 0,
				'sort'				=> 'random',
				'order'			=> 'ASC',
				'title'			=> '',
			);

			$instance = wp_parse_args( $instance, $defaults );

			extract( $instance );

			$title = esc_attr( $instance['title'] );
			$colors = implode( $instance['color_names'], "\r\n" );
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?> <small>( default: Tags )</small>
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
				</label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'number' ); ?>">Display how many tags? <small>( 15-50 recommended, 0 = all ):</small>
					<input class="small-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" />
				</label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'min_size' ); ?>">Smallest tag size <small>( 6-8 recommended, 10 max ):</small>
					<input class="small-text" id="<?php echo $this->get_field_id( 'min_size' ); ?>" name="<?php echo $this->get_field_name( 'min_size' ); ?>" type="text" value="<?php echo $min_size; ?>" />px
				</label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'max_size' ); ?>">Largest tag size <small>( 18-25 recommended, <?php echo $min_size + 2; ?> min, 40 max ):</small>
					<input class="small-text" id="<?php echo $this->get_field_id( 'max_size' ); ?>" name="<?php echo $this->get_field_name( 'max_size' ); ?>" type="text" value="<?php echo $max_size; ?>" />px
				</label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'sort' ); ?>">Sort tags by: 
					<select class="postform" id="<?php echo $this->get_field_id( 'sort' ); ?>" name="<?php echo $this->get_field_name( 'sort' ); ?>" >
						<option value="count" <?php $selected = ( $sort=='count' )? 'selected="selected"' : ""; echo $selected; ?>>Popularity</option>
						<option value="name" <?php $selected = ( $sort=='name' )? 'selected="selected"' : ""; echo $selected; ?>>Alphabetical</option>
						<option value="random" <?php $selected = ( $sort=='random' )? 'selected="selected"' : ""; echo $selected; ?>>Random</option>
					</select>
				</label>
			</p>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					var sortFieldId = '<?php echo $this->get_field_id( 'sort' ); ?>';
					var orderFieldId = '<?php echo $this->get_field_id( 'order' ); ?>';
					var sortVal = $( '#' + sortFieldId ).val();
					if ( sortVal != 'random' ) {
						$( 'p.p-' + orderFieldId ).show();
					}
					else {
						$( 'p.p-' + orderFieldId ).hide();
					}
					$( '#' + sortFieldId ).change( function() {
						var sortval = $( '#' + sortFieldId ).val();
						if ( sortval != 'random' ) {
							$( 'p.p-' + orderFieldId ).show( 'slow' );
						}
						else {
							$( 'p.p-' + orderFieldId ).hide( 'slow' );
						}
					});
					
				});
			</script>
			<p class="p-<?php echo $this->get_field_id( 'order' ); ?>">
				Sort direction? <label style="margin-left: 10px; display: block;" for="<?php echo $this->get_field_id( 'order' ); ?>">Ascending ( least to most, A-Z ): 
					<input class="static_class" id="<?php echo $this->get_field_id( 'order' ); ?>-asc" name="<?php echo $this->get_field_name( 'order' ); ?>" type="radio" value="ASC" <?php if ( 'ASC' == $order ) echo 'checked="checked"'; ?> />
				</label>
				<label style="margin-left: 10px; display: block;" for="<?php echo $this->get_field_id( 'order' ); ?>"> Descending ( most to least, Z-A ): 
					<input class="static_class" id="<?php echo $this->get_field_id( 'order' ); ?>-desc" name="<?php echo $this->get_field_name( 'order' ); ?>" type="radio" value="DESC" <?php if ( 'DESC' == $order ) echo 'checked="checked"'; ?> />
				</label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'use_colors' ); ?>">Use colors? yes: 
					<input class="static_class" id="<?php echo $this->get_field_id( 'use_colors' ); ?>-yes" name="<?php echo $this->get_field_name( 'use_colors' ); ?>" type="radio" value="1" <?php if ( 1 == $use_colors ) echo 'checked="checked"'; ?> />
				</label>
				<label for="<?php echo $this->get_field_id( 'use_colors' ); ?>"> or no: 
					<input class="static_class" id="<?php echo $this->get_field_id( 'use_colors' ); ?>-no" name="<?php echo $this->get_field_name( 'use_colors' ); ?>" type="radio" value="0" <?php if ( 0 == $use_colors ) echo 'checked="checked"'; ?> />
				</label>
			</p>
			<fieldset id="ctc-widget-colors">
				<p>
					<label for="<?php echo $this->get_field_id( 'color_names' ); ?>">Color names:<br />
						<textarea class="widefat" id="<?php echo $this->get_field_id( 'color_names' ); ?>" name="<?php echo $this->get_field_name( 'color_names' ); ?>" rows="8" ><?php echo $colors; ?></textarea><br />
							<small>You can use either named colors or hex color numbers. If you're using a numbered color, you <strong>must</strong> use a hash mark ( # ) in front of the color code. You can use the shorthand 3-digit or full-length 6-digit number. You can separate colors by spaces, comma, or the &lt;enter&gt; key.<br/><br/>If you leave this field blank, the cloud will default to the following colors: <strong><span style="color: aqua">aqua</span>, <span style="color: black">black</span>, <span style="color: blue">blue</span>, <span style="color: fuchsia">fuchsia</span>, <span style="color: gray">gray</span>, <span style="color: green">green</span>, <span style="color: lime">lime</span>, <span style="color: maroon">maroon</span>, <span style="color: navy">navy</span>, <span style="color: olive">olive</span>, <span style="color: purple">purple</span>, <span style="color: red">red</span>, <span style="color: silver">silver</span>, <span style="color: teal">teal</span>, <span style="color: black">white</span>, <span style="color:yellow">yellow</span></strong>.</small>
					</label>
				</p>
			</fieldset>
			<?php 
		}
	} // class ILWPColoredTagCloud

	add_action( 'widgets_init', create_function( '', 'return register_widget( "ILWPColoredTagCloud" );' ) );

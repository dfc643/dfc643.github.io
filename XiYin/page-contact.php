<?php if ( '' == session_id() ) session_start();
/*
Template Name: Contact Page
*/
?>
<?php 
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );
	
	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
	
	$et_regenerate_numbers = isset( $et_ptemplate_settings['et_regenerate_numbers'] ) ? (bool) $et_ptemplate_settings['et_regenerate_numbers'] : false;
		
	$et_error_message = '';
	$et_contact_error = false;
	
	if ( isset($_POST['et_contactform_submit']) ) {
		if ( !isset($_POST['et_contact_captcha']) || empty($_POST['et_contact_captcha']) ) {
			$et_error_message .= '<p>' . esc_html__('Make sure you entered the captcha. ','Harmony') . '</p>';
			$et_contact_error = true;
		} else if ( $_POST['et_contact_captcha'] <> ( $_SESSION['et_first_digit'] + $_SESSION['et_second_digit'] ) ) {			
			$et_numbers_string = $et_regenerate_numbers ? esc_html__('Numbers regenerated.','Harmony') : '';
			$et_error_message .= '<p>' . esc_html__('You entered the wrong number in captcha. ','Harmony') . $et_numbers_string . '</p>';
			
			if ($et_regenerate_numbers) {
				unset( $_SESSION['et_first_digit'] );
				unset( $_SESSION['et_second_digit'] );
			}
			
			$et_contact_error = true;
		} else if ( empty($_POST['et_contact_name']) || empty($_POST['et_contact_email']) || empty($_POST['et_contact_subject']) || empty($_POST['et_contact_message']) ){
			$et_error_message .= '<p>' . esc_html__('Make sure you fill all fields. ','Harmony') . '</p>';
			$et_contact_error = true;
		}
		
		if ( !is_email( $_POST['et_contact_email'] ) ) {
			$et_error_message .= '<p>' . esc_html__('Invalid Email. ','Harmony') . '</p>';
			$et_contact_error = true;
		}
	} else {
		$et_contact_error = true;
		if ( isset($_SESSION['et_first_digit'] ) ) unset( $_SESSION['et_first_digit'] );
		if ( isset($_SESSION['et_second_digit'] ) ) unset( $_SESSION['et_second_digit'] );
	}
	
	if ( !isset($_SESSION['et_first_digit'] ) ) $_SESSION['et_first_digit'] = $et_first_digit = rand(1, 15);
	else $et_first_digit = $_SESSION['et_first_digit'];
	
	if ( !isset($_SESSION['et_second_digit'] ) ) $_SESSION['et_second_digit'] = $et_second_digit = rand(1, 15);
	else $et_second_digit = $_SESSION['et_second_digit'];
	
	if ( !$et_contact_error ) {
		$et_email_to = ( isset($et_ptemplate_settings['et_email_to']) && !empty($et_ptemplate_settings['et_email_to']) ) ? $et_ptemplate_settings['et_email_to'] : get_site_option('admin_email');
				
		$et_site_name = is_multisite() ? $current_site->site_name : get_bloginfo('name');	
		
		$contact_name 	= wp_strip_all_tags( $_POST['et_contact_name'] );
		$contact_email 	= wp_strip_all_tags( $_POST['et_contact_email'] );

		$headers  = 'From: ' . $contact_name . ' <' . $contact_email . '>' . "\r\n";
		$headers .= 'Reply-To: ' . $contact_name . ' <' . $contact_email . '>';

		wp_mail( apply_filters( 'et_contact_page_email_to', $et_email_to ), sprintf( '[%s] ' . wp_strip_all_tags( $_POST['et_contact_subject'] ), $et_site_name ), wp_strip_all_tags( $_POST['et_contact_message'] ), apply_filters( 'et_contact_page_headers', $headers, $contact_name, $contact_email ) );
		
		$et_error_message = '<p>' . esc_html__('Thanks for contacting us','Harmony') . '</p>';
	}
?>
<?php get_header(); ?>

<div id="main-area">
	<div class="container">
		<div id="content-area" class="clearfix<?php if ( $fullwidth ) echo ' fullwidth'; ?>">
			<div id="left-area">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>
				
				<div id="et-contact" class="responsive">
					<div id="et-contact-message"><?php echo($et_error_message); ?> </div>
					
				<?php if ( $et_contact_error ) { ?>
					<form action="<?php echo(get_permalink(get_the_ID())); ?>" method="post" id="et_contact_form">
						<div id="et_contact_left">
							<p class="clearfix">
								<label for="et_contact_name" class="et_contact_form_label"><?php esc_html_e('Name','Harmony'); ?></label>
								<input type="text" name="et_contact_name" value="<?php if ( isset($_POST['et_contact_name']) ) echo esc_attr($_POST['et_contact_name']); else esc_attr_e('Name','Harmony'); ?>" id="et_contact_name" class="input" />
							</p>
							
							<p class="clearfix">
								<label for="et_contact_email" class="et_contact_form_label"><?php esc_html_e('Email Address','Harmony'); ?></label>
								<input type="text" name="et_contact_email" value="<?php if ( isset($_POST['et_contact_email']) ) echo esc_attr($_POST['et_contact_email']); else esc_attr_e('Email Address','Harmony'); ?>" id="et_contact_email" class="input" />
							</p>
							
							<p class="clearfix">
								<label for="et_contact_subject" class="et_contact_form_label"><?php esc_html_e('Subject','Harmony'); ?></label>
								<input type="text" name="et_contact_subject" value="<?php if ( isset($_POST['et_contact_subject']) ) echo esc_attr($_POST['et_contact_subject']); else esc_attr_e('Subject','Harmony'); ?>" id="et_contact_subject" class="input" />
							</p>
						</div> <!-- #et_contact_left -->
						
						<div id="et_contact_right">
							<p class="clearfix">
								<?php 
									esc_html_e('Captcha: ','Harmony');	
									echo '<br/>';
									echo esc_attr($et_first_digit) . ' + ' . esc_attr($et_second_digit) . ' = ';
								?>
								<input type="text" name="et_contact_captcha" value="<?php if ( isset($_POST['et_contact_captcha']) ) echo esc_attr($_POST['et_contact_captcha']); ?>" id="et_contact_captcha" class="input" size="2" />
							</p>
						</div> <!-- #et_contact_right -->
						
						<div class="clear"></div>
						
						<p class="clearfix">
							<label for="et_contact_message" class="et_contact_form_label"><?php esc_html_e('Message','Harmony'); ?></label>
							<textarea class="input" id="et_contact_message" name="et_contact_message"><?php if ( isset($_POST['et_contact_message']) ) echo esc_textarea($_POST['et_contact_message']); else echo esc_textarea( __('Message','Harmony') ); ?></textarea>
						</p>
							
						<input type="hidden" name="et_contactform_submit" value="et_contact_proccess" />
						
						<input type="reset" id="et_contact_reset" value="<?php esc_attr_e('Reset','Harmony'); ?>" />
						<input class="et_contact_submit" type="submit" value="<?php esc_attr_e('Submit','Harmony'); ?>" id="et_contact_submit" />
					</form>
				<?php } ?>
				</div> <!-- end #et-contact -->
				
			<?php endwhile; ?>
		
			</div> <!-- end #left-area -->
			
			<?php if ( ! $fullwidth ) get_sidebar(); ?>
		</div> <!-- end #content-area -->
	</div> <!-- end .container -->
</div> <!-- end #main-area -->
	
<?php get_footer(); ?>
<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="secondary" class="side" role="complementary">
		<?php if ( has_nav_menu( 'secondary' ) ) : ?>
		<nav id="secondary_nav" role="complementary" class="block widget widget_text">
            <p class="ui red ribbon label">从这里开始</p>
            <?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
        </nav>
        <?php endif; ?>
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
<?php endif; ?>
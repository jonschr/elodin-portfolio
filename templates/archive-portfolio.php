<?php

//* Set up the grid
add_filter( 'post_class', 'rb_portfolio_archive_post_class' );
function rb_portfolio_archive_post_class( $classes ) {
	global $wp_query;
	if( ! $wp_query->is_main_query() )
		return $classes;
		
	$classes[] = 'one-fourth';
	if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 4 )
		$classes[] = 'first';
	return $classes;
}

//* Change out the content
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'rb_portfolio_loop_content' );
function rb_portfolio_loop_content() {
	if ( have_posts() ) {
		
		add_thickbox();

    	while ( have_posts() ) {
    		the_post();
			?>

			<article <?php post_class(); ?>>

    		<?php 
    		rb_portfolio_add_image();
    		//rb_portfolio_featured_post_image(); 
			the_date( 'F Y', '<span class="portfolio-date">', '</span>' );
			genesis_do_post_title();
    		rb_portfolio_add_authors();
    		rb_portfolio_display_thickbox_content();
			?>

    		</article>

			<?php
    	}
    }
}

//* Remove the link from the title
add_filter( 'genesis_post_title_output', 'rb_portfolio_custom_post_title' );
function rb_portfolio_custom_post_title( $title ) {
		
	$post_title = get_the_title( get_the_ID() );
	$primary_title = '<h3 class="entry-title" itemprop="headline">' . $post_title . '</h3>';
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'secondary-title/secondary-title.php' ) ) {
		
		$secondary_title = get_secondary_title();
		
		if ( !empty( $secondary_title ) ) {
			$secondary_title = '<h3 class="entry-subtitle">' . $secondary_title . '</h3>';
		}

		$title = $primary_title . $secondary_title;

	} else {
		
		$title = $primary_title;

	}
		
	return $title;
}

genesis();
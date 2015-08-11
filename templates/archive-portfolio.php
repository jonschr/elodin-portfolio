<?php

//* Change out the content
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'rb_portfolio_loop_content' );

//* Filter the posts if we need to change the loop content
add_filter( 'pre_get_posts', 'be_archive_query' );
function be_archive_query( $query ) {
	
	if( $query->is_main_query() && $query->is_archive() ) {
		$query->set( 'posts_per_page', 27 );
	}
}

//* This function takes care of all of the content
function rb_portfolio_loop_content() {
	the_content();
}

//* Remove the post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//* Remove the default post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

//* Remove the link from the title
add_filter( 'genesis_post_title_output', 'rb_custom_post_title' );
function rb_custom_post_title( $title ) {
	// if( get_post_type( get_the_ID() ) == 'post' ) {
		
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
		
	// }
	return $title;
}

//* Add the featured image (different size)
function featured_post_image() {
	add_thickbox();

	$id = get_the_id();
	$permalink = get_post_meta( get_the_ID(), '_rbp_file_upload', true );
	$thumbnail = get_the_post_thumbnail( $post, 'portfolio-small', array( 'class' => 'post-image aligncenter' ) );
	$content = get_the_content();

	global $wp_query;

	$link = '<a class="dashicons dashicons-admin-links" target="_blank" href="' . $permalink . '"></a>';
	// $info = '<a class="dashicons dashicons-info thickbox" href="#TB_inline?height=500&width=750&inlineId=%s"></a>';
	$info = '<a class="dashicons dashicons-info thickbox" title="' . $get_the_title . '" href="#TB_inline?height=500&width=750&inlineId=portfolio-content-' . ($wp_query->current_post + 1) . '"></a>';

	?>

	<small style="text-align:center;display: block;"><?php edit_post_link( ); ?></small>
	<div class="publication-overlay-bkg">
		<span class="portfolio-links">

			<?php 
			if ( !empty( $permalink ) ) {
				?><span class="portfolio-link"><?php echo $link; ?></span><?php
			}
			
			if ( !empty( $content ) ) {
				?><span class="portfolio-info"><?php echo $info; ?></span><?php
			} ?>
		</span>
		<?php echo $thumbnail; ?>
	</div>

	<?php
}
add_action( 'genesis_entry_header', 'featured_post_image', 5 );

//* Remove the post content, add the date
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//* Add the date
add_action( 'genesis_entry_header', 'rb_add_date', 6 );
function rb_add_date() {
	the_date( 'F Y', '<span class="portfolio-date">', '</span>' );
}

add_action( 'genesis_entry_header', 'rb_add_authors', 10 );
function rb_add_authors() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'co-authors-plus/co-authors-plus.php' ) ) {
		coauthors( ', ', ' and ', '<span class="portfolio-authors">', '</span>' );
	}
}

//* Remove the post meta
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Set up the grid
function be_archive_post_class( $classes ) {
	global $wp_query;
	if( ! $wp_query->is_main_query() )
		return $classes;
		
	$classes[] = 'one-fourth';
	if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 4 )
		$classes[] = 'first';
	return $classes;
}
add_filter( 'post_class', 'be_archive_post_class' );

//* Add the content below everything, but don't display it
add_action ( 'genesis_entry_footer', 'display_thickbox_content' );
function display_thickbox_content() {
	global $wp_query;

	$permalink = get_post_meta( get_the_ID(), '_rbp_file_upload', true );

	echo '<div style="display:none;" id="portfolio-content-' . ($wp_query->current_post + 1) . '">';
		echo '<h1>' . get_the_title() . '</h1>';


		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active( 'secondary-title/secondary-title.php' ) ) {
			
			$secondary_title = get_secondary_title();
			
			if ( !empty( $secondary_title ) ) {
				echo '<h2>' . $secondary_title . '</h2>';
			}
		}

		the_content();
		$permalink = get_post_meta( get_the_ID(), '_rbp_file_upload', true );
		?>
		<p>
			<a target="_blank" href="<?php echo $permalink; ?>" class="button">View the full article...</a>
		</p>

		<?php
	echo '</div>';
}

function do_portfolio_loop() {
	add_thickbox();

	$id = get_the_id();
	$permalink = get_post_meta( get_the_ID(), '_rbp_file_upload', true );
	$thumbnail = get_the_post_thumbnail( $post, 'portfolio-small', array( 'class' => 'post-image aligncenter' ) );
	$content = get_the_content();

	global $wp_query;

	$link = '<a class="dashicons dashicons-admin-links" target="_blank" href="' . $permalink . '"></a>';
	// $info = '<a class="dashicons dashicons-info thickbox" href="#TB_inline?height=500&width=750&inlineId=%s"></a>';
	$info = '<a class="dashicons dashicons-info thickbox" title="' . $get_the_title . '" href="#TB_inline?height=500&width=750&inlineId=portfolio-content-' . ($wp_query->current_post + 1) . '"></a>';

	?>

	<small style="text-align:center;display: block;"><?php edit_post_link( ); ?></small>
	<div class="publication-overlay-bkg">
		<span class="portfolio-links">

			<?php 
			if ( !empty( $permalink ) ) {
				?><span class="portfolio-link"><?php echo $link; ?></span><?php
			}
			
			if ( !empty( $content ) ) {
				?><span class="portfolio-info"><?php echo $info; ?></span><?php
			} ?>
		</span>
		<?php echo $thumbnail; ?>
	</div>
	<?php
}

genesis();
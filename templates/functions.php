<?php
//* Add the featured image (different size)
function rb_portfolio_featured_post_image() {

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

//* Function to output the authors
function rb_portfolio_add_authors() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'co-authors-plus/co-authors-plus.php' ) ) {
		coauthors( ', ', ' and ', '<span class="portfolio-authors">', '</span>' );
	} else {
		the_author();
	}
}

//* Add the content below everything, but don't display it
function rb_portfolio_display_thickbox_content() {
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

function rb_portfolio_add_image() {

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
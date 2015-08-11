<?php
/**
 * Post Types
 *
 * This file registers any custom post types
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @author       Jon Schroeder <jon@redblue.us>
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/**
 * Create Services post type
 *
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */

function rbc_register_post_types() {

	$labels = array(
		'name' => 'Portfolio entries',
		'singular_name' => 'Portfolio entry',
		'add_new' => 'Add new',
		'add_new_item' => 'Add new portfolio entry',
		'edit_item' => 'Edit portfolio entry',
		'new_item' => 'New portfolio entry',
		'view_item' => 'View portfolio entry',
		'search_items' => 'Search portfolio entrys',
		'not_found' =>  'No portfolio entries found',
		'not_found_in_trash' => 'No portfolio entries found in trash',
		'parent_item_colon' => '',
		'menu_name' => 'Portfolio'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'portfolio' ),
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'menu_icon' => 'dashicons-format-image',
		'supports' => array( 'title', 'thumbnail', 'editor', 'genesis-cpt-archives-settings', 'author' )
	);

	register_post_type( 'portfolio', $args );
}
add_action( 'init', 'rbc_register_post_types' );

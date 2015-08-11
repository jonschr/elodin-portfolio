<?php
/*
	Plugin Name: Red Blue Portfolio
	Plugin URI: http://redblue.us
	Description: Just another partners plugin
	Version: 1.1
    Author: Jon Schroeder
    Author URI: http://redblue.us

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
*/

// Plugin directory 
define( 'RBP_DIR', dirname( __FILE__ ) );

//* Register the post type
include_once( 'lib/post_type.php' );

//* Customize the admin panel
include_once( 'lib/admin.php' );

//* Add a custom taxonomy
include_once( 'lib/taxonomy.php' );

//* Add a metabox
include_once( 'lib/metabox/metabox.php' );

//* Include the functions we'll be using in the archive templates
include_once( 'templates/functions.php' );

//* Add a widget
include_once( 'templates/widget-grid.php' );

// * Add the portfolio image size
add_image_size( 'portfolio-small', 260, 410, true );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'partners_add_scripts' );
function partners_add_scripts() {

    wp_enqueue_script( 'jquery-modal', plugins_url( '/js/jquery.simplemodal.js', __FILE__), array( 'jquery' ) );
    
    wp_register_style( 'portfolio-style', plugins_url( '/css/portfolio-style.css', __FILE__) );
    wp_enqueue_style( 'portfolio-style' );

    wp_enqueue_style( 'dashicons' );

}

//* Change the number of posts
add_action( 'pre_get_posts', 'rb_change_number_of_posts' );
function rb_change_number_of_posts( $query ) {
    if ( is_post_type_archive( 'portfolio' ) ) {
        $query->set( 'posts_per_page', '-1' );
    }
}

//* Partners archive template
add_filter( 'archive_template', 'portfolio_archive_template' ) ;
function portfolio_archive_template( $archive_template ) {
     global $post;

     if ( is_post_type_archive ( 'portfolio' ) ) {
          $archive_template = dirname( __FILE__ ) . '/templates/archive-portfolio.php';
     }
     return $archive_template;
}

//* Partners archive template
add_filter( 'single_template', 'portfolio_single_template' ) ;
function portfolio_single_template( $single_template ) {
     global $post;

     if ( is_singular ( 'portfolio' ) ) {
          $single_template = dirname( __FILE__ ) . '/templates/single-portfolio.php';
     }
     return $single_template;
}

//* Redirect single to archive
add_action( 'template_redirect', 'rbp_redirect_partners_single_to_archive' );
function rbp_redirect_partners_single_to_archive()
{
    if ( ! is_singular( 'portfolio' ) )
        return;

    wp_redirect( get_post_type_archive_link( 'portfolio' ), 301 );
    exit;
}
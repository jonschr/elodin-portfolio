<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category Red Blue Testimonials
 * @package  rbt_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

add_action( 'cmb2_init', 'rbt_register_portfolio_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function rbt_register_portfolio_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_rbp_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$rbp = new_cmb2_box( array(
		'id'            => $prefix . 'portfolio_metabox',
		'title'         => __( 'Details', 'cmb2' ),
		'object_types'  => array( 'portfolio', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'cmb_styles' => true, // false to disable the CMB stylesheet
		'closed'     => false, // true to keep the metabox closed by default
	) );

	$rbp->add_field( array(
		'name' => __( 'Portfolio pdf', 'cmb2' ),
		'desc' => __( 'Upload a file (or enter a URL)', 'cmb2' ),
		'id'   => $prefix . 'file_upload',
		'type' => 'file',
	) );
}
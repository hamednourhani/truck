<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the truck directory)
 *
 * Be sure to replace all instances of 'truck_' with your pharmacy's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_truck
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/truck
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}


function ed_metabox_include_front_page( $display, $meta_box ) {
    if ( ! isset( $meta_box['show_on']['key'] ) ) {
        return $display;
    }

    if ( 'front-page' !== $meta_box['show_on']['key'] ) {
        return $display;
    }

    $post_id = 0;

    // If we're showing it based on ID, get the current ID
    if ( isset( $_GET['post'] ) ) {
        $post_id = $_GET['post'];
    } elseif ( isset( $_POST['post_ID'] ) ) {
        $post_id = $_POST['post_ID'];
    }

    if ( ! $post_id ) {
        return !$display;
    }

    // Get ID of page set as front page, 0 if there isn't one
    $front_page = get_option( 'page_on_front' );

    // there is a front page set and we're on it!
    return $post_id == $front_page;
}
//add_filter( 'cmb2_show_on', 'ed_metabox_include_front_page', 10, 2 );
/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' truck_box parameter
 *
 * @param  truck object $cmb truck object
 *
 * @return bool             True if metabox should show
 */
function truck_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template
	if ( $cmb->object_id !== get_option( 'page_on_front' ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  truck_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function truck_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array             $field_args Array of field parameters
 * @param  truck_Field object $field      Field object
 */
function truck_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}



/******************************************************************/
/*--------------------Page Banner -------------------------------*/
/******************************************************************/

add_action('cmb2_init','truck_register_page_banner_metabox');
// add_action('cmb2_init','truck_register_tour_information_metabox');
function truck_register_page_banner_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_truck_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'page_banner',
		'title'         => __( 'Page Banner', 'truck' ),
		'object_types'  => array( 'post','page','product'), // Post type
		// 'show_on_cb' => 'truck_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	

	$cmb_demo->add_field( array(
		'name'       => __( 'Banner', 'truck' ),
		'desc'       => __( 'Choose Banner Mod, SlideShow , Image Banner or Nothing', 'truck' ),
		'id'         => $prefix . 'banner_mod',
		'type'       => 'radio_inline',
		'show_option_none' => true,
		'options'          => array(
			'slider' => __( 'Slider', 'truck' ),
			'image' => __( 'Image', 'truck' ),
			'map' => __( 'Map', 'truck' ),
			
		),	
		
		//'show_on_cb' => 'truck_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	
	$cmb_demo->add_field( array(
		'name'       => __( 'Slider Shortcode', 'truck' ),
		'desc'       => __( 'write this page Revolotion Slider shortcode with alis name here', 'truck' ),
		'id'         => $prefix . 'slider_shortcode',
		'type'       => 'text',
	
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'Banner Image', 'truck' ),
		'desc'       => __( 'Upload an image to show as the banner', 'truck' ),
		'id'         => $prefix . 'image',
		'type'       => 'file',
	
	) );
	$cmb_demo->add_field( array(
		'name'       => __( 'Google Map', 'truck' ),
		'desc'       => __( 'Enter Google Map embed code', 'truck' ),
		'id'         => $prefix . 'map',
		'type'       => 'textarea_code',

	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'Page Title', 'truck' ),
		'desc'       => __( 'show Page Title or Not?', 'truck' ),
		'id'         => $prefix . 'title',
		'type'       => 'radio_inline',
		'options'          => array(
			'yes' => __( 'Yes', 'truck' ),
			'no' => __( 'No', 'truck' ),
			
		),
		'default' => 'yes',
	
	) );

	
	
}
/******************************************************************/
/*--------------------Intro page Links -------------------------------*/
/******************************************************************/
//add_action( 'cmb2_init', 'truck_register_intro_links_metabox' );
//function truck_register_intro_links_metabox() {
//
//	$prefix = '_truck_';
//
//	/**
//	 * Sample metabox to demonstrate each field type included
//	 */
//	$cmb_demo = new_cmb2_box( array(
//			'id'            => $prefix . 'intro_links',
//			'title'         => __( 'Language Links', 'truck' ),
//			'object_types'  => array( 'page' ), // Post type
//
//	) );
//
//
//
//	$cmb_demo->add_field( array(
//			'name'         => __( 'English', 'truck' ),
//			'desc'         => __( 'Enter English web site Url', 'truck' ),
//			'id'           => $prefix . 'en_link',
//			'type'         => 'text_url',
//
//	) );
//	$cmb_demo->add_field( array(
//			'name'         => __( 'Persian', 'truck' ),
//			'desc'         => __( 'Enter Persian web site Url', 'truck' ),
//			'id'           => $prefix . 'fa_link',
//			'type'         => 'text_url',
//
//	) );
//
//
//
//}



<?php
/**
 * @version    $Id$
 * @package    WR_Sample_Plugin
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 * Technical Support:  Feedback - http://www.innothemes.com/contact-us/get-support.html
 */

/**
 * Core initialization class of IT Sample Plugin.
 *
 * @package  WR_CONTACTFORM_Plugin
 * @since    1.0.0
 */
class WR_Contactform {

	/**
	 * IT Contactform Plugin's custom post type slug.
	 *
	 * @var  string
	 */
	protected $type_slug = 'wr_cf_post_type';

	/**
	 * Define pages.
	 *
	 * @var  array
	 */
	public static $pages = array( 'wr-sample-update', 'wr-sample-upgrade' );

	/**
	 * Define Ajax actions.
	 *
	 * @var  array
	 */
	protected static $actions = array( 'wr-download-update', 'wr-install-update', 'wr-check-edition' );

	/**
	 * Constructor.
	 *
	 * @return  void
	 */
	public function __construct() {
		// Initialize necessary WR Library classes
		//Hook Meta Box
		WR_CF_Init_Meta_Box::hook();
		//Hook Post Type
		WR_CF_Init_Post_Type::hook();
		//Hook Assets
		WR_CF_Init_Assets::hook();
		//register post type wordpress
		WR_Contactform_Helpers_Hook::register_post_type();

		// Prepare admin pages
		if ( defined( 'WP_ADMIN' ) ) {

			add_action( 'admin_init', array( 'WR_CF_Gadget_Base', 'hook' ), 100 );

			// add languages
			add_action( 'admin_init', array( &$this, 'wr_contactform_languages' ) );

			// Register admin menu for IT Contactform Plugin
			WR_CF_Init_Admin_Menu::hook();

			add_action( 'admin_menu', array( 'WR_Contactform_Helpers_Hook', 'wr_contactform_register_menus' ) );

			// add Filter apply assets
			add_filter( 'wr_cf_register_assets', array( 'WR_Contactform_Helpers_Contactform', 'apply_assets' ) );
			
			// add filter customize the messages
			add_filter( 'post_updated_messages', array( 'WR_Contactform_Helpers_Contactform', 'set_messages' ) );

			//Adding "embed form" button
			add_action( 'media_buttons', array( 'WR_Contactform_Helpers_Hook', 'add_form_button' ), 20 );

			add_action( 'restrict_manage_posts', array( 'WR_Contactform_Helpers_Hook', 'wr_contactform_submissions_filters' ) );

			// Load sample forms
			WR_Contactform_Helpers_Sample_Form::hook();

			// Load necessary assets
			WR_Contactform_Helpers_Hook::load_assets();

		}
		else {
			global $pagenow;
			//Hook WR Gadget Base
			WR_CF_Gadget_Base::hook();

			//get short code
			add_filter( 'the_content', 'do_shortcode' );

			// add Filter apply assets
			add_filter( 'wr_cf_register_assets', array( 'WR_Contactform_Helpers_Contactform', 'apply_assets' ) );

			//render contactform in frontend
			add_shortcode( 'wr_contactform', array( &$this, 'contactform_to_frontend' ) );

			//get language contactform in frontend
			$this->wr_contactform_frontend_languages();

			//set content preview
			add_filter( 'the_content', array( &$this, 'wr_contactform_front_end_preview' ) );
		}
	}

	public function wr_contactform_front_end_preview( $content ) {
            
        $post_type = get_post_type();

        // Check type post
        if ( $post_type == 'wr_cf_post_type' ) {
        	global $post;
        	$data[ 'id' ] = $post->ID;
        	return self::contactform_to_frontend( $data );
        } else {
        	return $content;
        }

	}

	/**
	 * Show Contactform content for Frontend post
	 *
	 * @param type $content
	 *
	 * @return type
	 */
	public function contactform_to_frontend( $atts, $return = true ) {
		global $wpdb;
		if ( ! empty( $atts[ 'id' ] ) || ! empty( $atts[ 'name' ] ) ) {
			if ( ! empty( $atts[ 'id' ] ) ) {
				$postId = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE  meta_key='form_id' AND meta_value=%d", (int)$atts[ 'id' ] ) );
				if ( empty( $postId ) ) {
					$postId = (int)$atts[ 'id' ];
				}
			} else {
				$postId = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name=%s", $atts[ 'name' ] ) );
			}
			$status = get_post_status( $postId );

			if ( $status && $status != 'pending' ) {
				return self::load_html_contactform( $postId, $postId, rand( 99999999999, 999999999999999 ) );
			}
		}

	}

	/**
	 * Load Form
	 *
	 * @param   Int  $postId  Post id
	 * @param   Int  $formID  Form id
	 *
	 * @param   Imt  $index   Form Index
	 *
	 * @return void
	 */
	public function load_html_contactform( $postId, $formID, $index ) {
		//form Name
		$formName = md5( date( 'Y-m-d H:i:s' ) . $index . rand( 999999999, 999999999999 ) );
		//return html form
		return WR_Contactform_Helpers_Contactform::generate_html_pages( $postId, $formID, $formName );
	}

	/**
	 * load languages files
	 */
	public function wr_contactform_languages() {
		load_plugin_textdomain( WR_CONTACTFORM_TEXTDOMAIN, false, WR_CONTACTFORM_TEXTDOMAIN . '/libraries/languages/' );
	}

	/**
	 * Front-End Load langauge file
	 *
	 */
	public function wr_contactform_frontend_languages() {
		load_plugin_textdomain( WR_CONTACTFORM_TEXTDOMAIN, false, WR_CONTACTFORM_TEXTDOMAIN . '/frontend/languages/' );
	}

}


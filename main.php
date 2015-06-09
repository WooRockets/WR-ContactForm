<?php
/**
 * Plugin Name: WR ContactForm
 * Plugin URI: http://woorockets.com
 * Description: Super easy form builder bringing to your Wordpress website contact form, survey and much more.
 * Version: 1.1.9
 * Author: WooRockets Team <support@woorockets.com>
 * Author URI: http://woorockets.com
 * License: GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
error_reporting( E_ALL ^ E_NOTICE );
session_start();
if ( isset( $_SESSION['wr-cf-list_email_send_to'] ) )
	setcookie( "wr-cf-list_email_send_to", $_SESSION['wr-cf-list_email_send_to'], time() + 60 * 60 * 24 * 30 );
else setcookie( "wr-cf-list_email_send_to", "", time() + 60 * 60 * 24 * 30 );
define( 'WR_CONTACTFORM_PLUGIN_FILE', __FILE__ );
require_once dirname( __FILE__ ) . '/defines.php';

if ( file_exists( WR_CONTACTFORM_PATH . '/includes/content.php' ) ) {
	require_once ( WR_CONTACTFORM_PATH . '/includes/content.php' );
	$proFieldContent = new WR_Contactform_Includes_Content();
}
if ( ! defined( 'WP_ADMIN' ) ) {
	require_once WR_CONTACTFORM_PATH . '/includes/type.php';
	require_once WR_CONTACTFORM_PATH . '/includes/required.php';
	require_once ( WR_CONTACTFORM_PATH . '/includes/upload.php' );

	$proFieldType = new WR_Contactform_Includes_Type();
	$proFieldRequired = new WR_Contactform_Includes_Required();
}
require_once( WR_CONTACTFORM_PATH . 'libraries/loader.php' );
require_once( WR_CONTACTFORM_PATH . '/helpers/contactform.php' );
require_once( WR_CONTACTFORM_PATH . '/helpers/action-hook.php' );
require_once( WR_CONTACTFORM_PATH . '/helpers/ajax.php' );
require_once( WR_CONTACTFORM_PATH . '/helpers/sample-form.php' );
require_once( WR_CONTACTFORM_PATH . '/libraries/contactform.php' );
require_once( WR_CONTACTFORM_PATH . '/libraries/installer.php' );

// Load Add-ons
include_once( WR_CONTACTFORM_PATH . '/addons/mailchimp/main.php' );

//Get Post Type
register_activation_hook( __FILE__, array( 'WR_Contactform_Installer', 'on_activate_function' ) );
register_uninstall_hook( __FILE__, array( 'WR_Contactform_Installer', 'on_uninstaller_function' ) );

// Register WR Sample Plugin initialization
add_action( 'wr_cf_init', 'wr_init_contactform_plugin' );

// Register autoloader with WR_ prefix
WR_CF_Loader::register( WR_CONTACTFORM_PATH . 'libraries', 'WR_' );

// Initialize WR Library
WR_CF_Init_Plugin::hook();

function wr_init_contactform_plugin() {
	$WRContactform = new WR_Contactform();
	// Init admin pages
	$WRContactformLoadAjax = new WR_Contactform_Helpers_Ajax();
	// Redirect after plugin activation
	add_action( 'admin_init', array( 'WR_Contactform_Installer', 'do_activation_redirect' ) );
}

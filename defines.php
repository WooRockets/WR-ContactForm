<?php
/**
 * @version    $Id$
 * @package    WR_ContactForm
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2012 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

// Define the absolute path, with trailing slash, of the IT Sample Plugin directory
define( 'WR_CONTACTFORM_PATH', plugin_dir_path( __FILE__ ) );

// Define the URL, including a trailing slash, of the WR Sample Plugin directory
define( 'WR_CONTACTFORM_URI', plugin_dir_url( __FILE__ ) );

define( 'WR_CONTACTFORM_CAPTCHA_PUBLICKEY', get_option( 'wr_contactform_recaptcha_public_key' ) );

define( 'WR_CONTACTFORM_CAPTCHA_PRIVATEKEY', get_option( 'wr_contactform_recaptcha_private_key' ) );

// Text domain for WR ContactForm plugin
define( 'WR_CONTACTFORM_TEXTDOMAIN', 'wr-contactform' );

// Define product edition
define( 'WR_CONTACTFORM_EDITION', 'FREE' );

// Define product identification
define( 'WR_CONTACTFORM_IDENTIFICATION', 'wr_contactform' );

// Define product identified name
define( 'WR_CONTACTFORM_DEPENDENCY', '' );

// Define product identified name
define( 'WR_CONTACTFORM_ADDONS', null );

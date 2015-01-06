<?php
/**
 * @version    $Id$
 * @package    WR_ContactForm
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

/**
 * WR ContactForm MailChimp Addon
 */

define( 'WR_CONTACTFORM_ADDON_MAILCHIMP_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'WR_CONTACTFORM_ADDON_MAILCHIMP_DIR_URL', plugin_dir_url( __FILE__ ) );

require_once( WR_CONTACTFORM_ADDON_MAILCHIMP_DIR_PATH . 'api/Mailchimp.php' );
require_once( WR_CONTACTFORM_ADDON_MAILCHIMP_DIR_PATH . 'addon-mailchimp.php' );

add_action( 'wr_cf_init', 'wr_cf_addon_mailchimp_init' );

function wr_cf_addon_mailchimp_init() {
	$WRCFAddonMailchimp = new WR_CF_Addon_Mailchimp();
}
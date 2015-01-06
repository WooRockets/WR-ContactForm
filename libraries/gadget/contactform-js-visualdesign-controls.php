<?php
/**
 * @version    $Id$
 * @package    WR_Plugin_Framework
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 * Technical Support:  Feedback - http://www.innothemes.com/contact-us/get-support.html
 */

class WR_CF_Gadget_Contactform_Js_Visualdesign_Controls extends WR_CF_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-js-visualdesign-controls';

	/**
	 * Constructor.
	 *
	 * @return  void
	 */
	public function __construct() {

	}

	/**
	 *  set default action
	 */
	public function default_action() {
		require_once(ABSPATH . 'wp-admin/includes/admin.php');
		auth_redirect();

		header( 'Content-Type: application/javascript' );
		$controls = array();
		$controls[ 'single-line-text' ] = WR_CF_Gadget_Controls_Single_Line_Text::register();
		$controls[ 'choices' ] = WR_CF_Gadget_Controls_Choices::register();
		$controls[ 'dropdown' ] = WR_CF_Gadget_Controls_Dropdown::register();
		$controls[ 'paragraph-text' ] = WR_CF_Gadget_Controls_Paragraph_Text::register();
		$controls[ 'checkboxes' ] = WR_CF_Gadget_Controls_Checkboxes::register();
		$controls[ 'list' ] = WR_CF_Gadget_Controls_List::register();
		$controls[ 'static-content' ] = WR_CF_Gadget_Controls_Static_Content::register();
		$controls[ 'form-captcha' ] = WR_CF_Gadget_Controls_Form_Captcha::register();
		$controls[ 'form-actions' ] = WR_CF_Gadget_Controls_Form_Actions::register();
		$controls[ 'google-maps' ] = WR_CF_Gadget_Controls_Google_Maps::register();
		$controls[ 'name' ] = WR_CF_Gadget_Controls_Name::register();
		$controls[ 'email' ] = WR_CF_Gadget_Controls_Email::register();
		$controls[ 'file-upload' ] = WR_CF_Gadget_Controls_File_Upload::register();
		$controls[ 'likert' ] = WR_CF_Gadget_Controls_Likert::register();
		$controls[ 'address' ] = WR_CF_Gadget_Controls_Address::register();
		$controls[ 'website' ] = WR_CF_Gadget_Controls_Website::register();
		$controls[ 'date' ] = WR_CF_Gadget_Controls_Date::register();
		$controls[ 'country' ] = WR_CF_Gadget_Controls_Country::register();
		$controls[ 'number' ] = WR_CF_Gadget_Controls_Number::register();
		$controls[ 'phone' ] = WR_CF_Gadget_Controls_Phone::register();
		$controls[ 'currency' ] = WR_CF_Gadget_Controls_Currency::register();
		$controls[ 'password' ] = WR_CF_Gadget_Controls_Password::register();
		$controls = apply_filters( 'wr_contactform_filter_visualdesign_controls', $controls );
		$javascript = '(function ($) {
			    var t = $.evalJSON($("#wr_contactform_languages").val());
			    ' . implode( ' ', $controls ) . '
			})(jQuery);';
		echo '' . $javascript;
		exit();
	}


}

<?php
/**
 * @version    $Id$
 * @package    wr_contactform_Plugin
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 * Technical Support:  Feedback - http://www.innothemes.com/contact-us/get-support.html
 */

/**
 * Contactform configuration.
 *
 * @package  wr_contactform_Plugin
 * @since    1.0.0
 */
class WR_Contactform_Settings {

	/**
	 * Fields array.
	 *
	 * @var  array
	 */
	protected static $fields = array();

	/**
	 * Setup vertical tabs for theme options form.
	 *
	 * @return  void
	 */
	public static function wr_form_post_render() {
		WR_CF_Init_Assets::inline(
			'js', '
			$(".oj-form-sections-tabs").addClass("ui-tabs-vertical ui-helper-clearfix");
			$(".jsn-form-sections-tabs > ul > li").removeClass("ui-corner-top").addClass("ui-corner-left");'
		);
	}

	/**
	 * Render configuration page.
	 *
	 * @return  void
	 */
	public static function render() {
		// Init HTML form
		$form = WR_CF_Form::get_instance( 'wr_contactform_configuration', self::$fields );

		// Setup vertical tabs
		add_action( 'wr_form_post_render', array( __CLASS__, 'wr_form_post_render' ) );

		// Render HTML form
		$form->render( 'settings' );
	}
}

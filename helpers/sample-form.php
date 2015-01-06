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
 * WR ContactForm sample form helper.
 *
 * @package  WR_ContactForm
 * @since    1.0.0
 */

class WR_Contactform_Helpers_Sample_Form {
	/**
	 * Template file extension.
	 *
	 * @var  string
	 */
	protected static $extension = '.tpl';

	/**
	 * Template file directory.
	 *
	 * @var  string
	 */
	protected static $directory = 'includes/sample-forms/';

	/**
	 * Hook into WordPress.
	 *
	 * @return  void
	 */
	public static function hook() {
		add_action( 'wr_cf_load_sample_form_selectbox', array( __CLASS__, 'load_sample_form_selectbox' ) );
		add_filter( 'wr_contactform_js_forms_hook', array( __CLASS__, 'load_sample_list' ) );
		add_filter( 'wr_contactform_create_form_sample', array( __CLASS__, 'load_sample_forms' ) );
	}

	/**
	 * Load sample form selectbox
	 *
	 * @return  void
	 */
	public static function load_sample_form_selectbox() {
		echo '<div id="wr-cf-sample-form-block" class="hidden">';
		echo '<select name="wr-cf-sample-form" id="wr-cf-sample-form">';
		echo '<option value="" selected="selected">- Select template -</option>';
		$dirPath = WR_CONTACTFORM_PATH . self::$directory;
		// Remove /. and /..
		$templateFiles = array_diff( scandir( $dirPath ), array( '..', '.' ) );
		// Re-index array
		$templateFiles = array_values( $templateFiles );
		// Get name of sample forms
		foreach ( $templateFiles as $formFile ) {
			echo '<option value="' . self::get_form_name( $formFile ) . '">' . self::get_form_name( $formFile ) . '</option>';
		}
		echo '</select>';
		echo '</div>';
	}

	/**
	 * Load sample list.
	 *
	 * @param   string  $jsHook  JavaScript forms.
	 *
	 * @return  string
	 */
	public static function load_sample_list( $jsHook ) {
		$dirPath = WR_CONTACTFORM_PATH . self::$directory;
		// Remove /. and /..
		$templateFiles = array_diff( scandir( $dirPath ), array( '..', '.' ) );
		// Re-index array
		$templateFiles = array_values( $templateFiles );
		// Get name of sample forms
		foreach ( $templateFiles as $formFile ) {
			$jsHook['button-addnew-action'] .= '
				$("#wpbody-content .jsn-form-title-heading .contactform-add-new ul.contactform-sample-form").append(
					$("<li/>").append(
						$("<a/>",
							{
								"class":"",
								"href":"post-new.php?post_type=wr_cf_post_type&form=' . self::get_form_name( $formFile ) . '",
								"text":"' . self::get_form_name( $formFile ) . '"
							}
						)
					)
				);';
		}
		return $jsHook;
	}

	/**
	 * Load sample forms.
	 *
	 * @param   array  $sampleForms  Array of sample forms.
	 *
	 * @return  array
	 */
	public static function load_sample_forms( $sampleForms ) {
		$dirPath = WR_CONTACTFORM_PATH . self::$directory;
		// Remove /. and /..
		$templateFiles = array_diff( scandir( $dirPath ), array( '..', '.' ) );
		// Re-index array
		$templateFiles = array_values( $templateFiles );
		// Get content of template files
		foreach ( $templateFiles as $formFile ) {
			$filePath = $dirPath . $formFile;
			$sampleForms[self::get_form_name( $formFile )] = file_get_contents( $filePath );
		}
		return $sampleForms;
	}

	/**
	 * Get form name from file name.
	 *
	 * @param   string  $formFile  File name include extension.
	 *
	 * @return  string  File name.
	 */
	protected static function get_form_name( $formFile ) {
		// Remove extension
		$formName = str_replace( self::$extension, '', $formFile );
		// Replace dash with space
		$formName = str_replace( '_', ' ', $formName );
		return $formName;
	}
}
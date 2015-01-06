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

class WR_CF_Gadget_Contactform_Style extends WR_CF_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-style';

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
		$formId = ! empty( $_GET[ 'form_id' ] ) ? (int)$_GET[ 'form_id' ] : 0;
		if ( ! empty( $formId ) ) {
			$meta = get_post_meta( (int)$formId );
			$formStyle = new stdClass;
			if ( ! empty( $meta[ 'form_style' ][ 0 ] ) ) {
				$formStyle = json_decode( $meta[ 'form_style' ][ 0 ] );
			}
			$customCss = '';
			$globalFormStyle = get_option( 'wr_contactform_style' );
			$formStyleCustom = new stdClass;
			if ( ! empty( $formStyle ) ) {
				$formStyleCustom = $formStyle;
				$customCss = ! empty( $formStyleCustom->custom_css ) ? $formStyleCustom->custom_css : '';
				if ( ! empty( $globalFormStyle ) ) {
					$globalFormStyle = json_decode( $globalFormStyle );

					if ( ! empty( $globalFormStyle->themes_style ) ) {
						foreach ( $globalFormStyle->themes_style as $key => $value ) {
							$formStyleCustom->themes_style->{$key} = $value;
						}
					}
					if ( ! empty( $globalFormStyle->themes ) ) {
						foreach ( $globalFormStyle->themes as $key => $value ) {
							$formStyleCustom->themes[ ] = $value;
						}
					}
				}
			}
			if ( ! empty( $formStyleCustom->theme ) && ! empty( $formStyleCustom->themes_style ) && $formStyleCustom->theme != 'wr-style-light' && $formStyleCustom->theme != 'wr-style-dark' ) {
				$theme = str_replace( 'wr-style-', '', $formStyleCustom->theme );
				if ( ! empty( $formStyleCustom->themes_style->{$theme} ) ) {
					$formStyleCustom = json_decode( $formStyleCustom->themes_style->{$theme} );
				}
			}
			header( 'Content-Type: text/css;X-Content-Type-Options: nosniff;' );
			echo '' . WR_Contactform_Helpers_Contactform::generate_style_pages(
				$formStyleCustom, '#wr_form_'.$formId.'.jsn-master .jsn-bootstrap  .jsn-form-content .control-group', '#wr_form_'.$formId.'.jsn-master .jsn-bootstrap  .jsn-form-content .control-group.ui-state-highlight', '#wr_form_'.$formId.'.jsn-master .jsn-bootstrap  .jsn-form-content .control-group .control-label', '#wr_form_'.$formId.'.jsn-master .jsn-bootstrap  .jsn-form-content .control-group.error .help-block,' . '#wr_form_'.$formId.'.jsn-master .jsn-bootstrap  .jsn-form-content .control-group.error .help-inline,' . '#wr_form_'.$formId.'.jsn-master .jsn-bootstrap  .jsn-form-content .control-group.error .help-block span.label', '#wr_form_'.$formId.'.jsn-master .jsn-bootstrap  .jsn-form-content .control-group .label-important,' . '#wr_form_'.$formId.'.jsn-master .jsn-bootstrap  .jsn-form-content .control-group .label-important .badge-important', '#wr_form_'.$formId.'.jsn-master .jsn-bootstrap  .jsn-form-content .control-group .controls input,' . '#wr_form_'.$formId.'.jsn-master .jsn-bootstrap  .jsn-form-content .control-group .controls select,' . '#wr_form_'.$formId.'.jsn-master .jsn-bootstrap  .jsn-form-content .control-group .controls textarea'
			);
			echo ' ' . $customCss;
			exit();
		}
	}
}

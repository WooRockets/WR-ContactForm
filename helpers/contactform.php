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
 * WR ContactForm form helper.
 *
 * @package  WR_ContactForm
 * @since    1.0.0
 */
class WR_Contactform_Helpers_Contactform {

	/**
	 * apply assets contactform
	 *
	 * @param $assets
	 *
	 * @return mixed
	 */
	public static function apply_assets( $assets ) {
		$version = defined( 'WR_CONTACTFORM_VERSION' ) ? WR_CONTACTFORM_VERSION : '1.0.0';
		
		/**
		 * Bootstrap 2
		 */
		$assets[ 'wr-bootstrap2-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/bs2/bootstrap/css/bootstrap.min.css',
			'ver' => $version,
		);
		$assets[ 'wr-bootstrap2-responsive-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/bs2/bootstrap/css/bootstrap-responsive.min.css',
			'ver' => $version,
		);
		$assets[ 'wr-bootstrap2-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/bs2/bootstrap/js/bootstrap.min.js',
			'ver' => $version,
		);
		$assets[ 'wr-bootstrap2-icomoon-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/bs2/font-icomoon/css/icomoon.css',
			'ver' => $version,
		);
		$assets[ 'wr-bootstrap2-jsn-gui-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/bs2/jsn/css/jsn-gui.css',
			'ver' => $version,
		);
		
		$assets[ 'wr-jquery-json-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-json/json-2.3.min.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-tipsy-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-tipsy/jquery.tipsy.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-tmpl-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-tmpl/jquery.tmpl.js',
			'ver' => $version,
		);

		$assets[ 'wr-jquery-placeholder-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-placeholder/jquery.placeholder.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-select2-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/select2/select2.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-scrollto-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-scrollto/jquery.scrollTo.js',
			'ver' => $version,
		);

		$assets[ 'wr-colpick-js' ] = array(
			'src'  => WR_CONTACTFORM_URI . 'assets/3rd-party/colpick/js/colpick.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-wysiwyg-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-jwysiwyg/jquery.wysiwyg.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-wysiwyg-colorpicker-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-jwysiwyg/controls/wysiwyg.colorpicker.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-wysiwyg-table-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-jwysiwyg/controls/wysiwyg.table.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-wysiwyg-cssWrap-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-jwysiwyg/controls/wysiwyg.cssWrap.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-wysiwyg-image-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-jwysiwyg/controls/wysiwyg.image.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-wysiwyg-link-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-jwysiwyg/controls/wysiwyg.link.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-wysiwyg-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-jwysiwyg/jquery.wysiwyg.css',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-codemirror-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/codemirror/lib/codemirror.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-codemirror-matchbrackets-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/codemirror/addon/edit/matchbrackets.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-codemirror-mode-css-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/codemirror/mode/css/css.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-codemirror-markselection-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/codemirror/addon/selection/mark-selection.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-codemirror-activeline-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/codemirror/addon/selection/active-line.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-codemirror-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/codemirror/lib/codemirror.css',
			'ver' => $version,
		);
		$assets[ 'wr-zero-clipboard-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/zeroclipboard/ZeroClipboard.js',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-jquery-layout-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/js/layout.js',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/js/contactform.js',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-visualdesign-js' ] = array(
			'src' => get_admin_url() . '/?wr-cf-gadget=contactform-js-visualdesign-core&action=default',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-itemlist-js' ] = array(
			'src' => get_admin_url() . '?wr-cf-gadget=contactform-js-visualdesign-itemlist&action=default',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-emailsettings-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/js/emailsettings.js',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-controls-js' ] = array(
			'src' => get_admin_url() . '/?wr-cf-gadget=contactform-js-visualdesign-controls&action=default',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-form-js' ] = array(
			'src' => get_admin_url() . '/?wr-cf-gadget=contactform-js-form&action=default',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-forms-js' ] = array(
			'src' => get_admin_url() . '/?wr-cf-gadget=contactform-js-forms&action=default',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-modal-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/js/modal.js',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-editor-plugin-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/js/editor_plugin.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-tipsy-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-tipsy/tipsy.css',
			'ver' => $version,
		);
		$assets[ 'wr-colpick-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/colpick/css/colpick.css',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/css/contactform.css',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-editor-plugin-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/css/editor_plugin.css',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-select2-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/select2/select2.css',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-ui-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-ui/css/ui-bootstrap/jquery-ui-1.9.0.custom.css',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-submissions-js' ] = array(
			'src' => get_admin_url() . '/?wr-cf-gadget=contactform-js-submissions&action=default',
			'ver' => $version,
		);
		$assets[ 'wr-contactform-submission-js' ] = array(
			'src' => get_admin_url() . '/?wr-cf-gadget=contactform-js-submission&action=default',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-daterangepicker-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/daterangepicker/daterangepicker.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-daterangepicker-moment-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/daterangepicker/moment.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-daterangepicker-bs2-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/daterangepicker/daterangepicker-bs2.css',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-daterangepicker-bs3-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/daterangepicker/daterangepicker-bs3.css',
			'ver' => $version,
		);

		// Icon font-face
		$assets[ 'wr-contactform-icon-font-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/css/icon-font.css',
			'ver' => $version,
		);
		
		// Add New Form page
		$assets[ 'wr-contactform-post-new-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/js/contactform-post-new.js',
			'ver' => $version
		);

		//frontend
		$assets[ 'wr-frontend-contactform-css' ] = array(
			'src' => WR_CONTACTFORM_URI . 'frontend/css/form.css',
			'ver' => $version,
		);
		$assets[ 'wr-frontend-contactform-js' ] = array(
			'src' => get_site_url() . '/?wr-cf-gadget=contactform-js-form-frontend&action=default',
			'ver' => $version,
		);
		$assets[ 'wr-frontend-contactform-bootstrap-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'frontend/js/libs/bootstrap.custom.min.js',
			'ver' => $version,
		);
		
		$assets[ 'wr-http-googlemaps-api-js' ] = array(
			'src' => 'http://maps.google.com/maps/api/js?sensor=false&libraries=places',
			'ver' => $version,
		);
		$assets[ 'wr-https-googlemaps-api-js' ] = array(
			'src' => 'http://maps.google.com/maps/api/js?sensor=false&libraries=places',
			'ver' => $version,
		);
		$assets[ 'wr-googlemaps-ui-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/googlemaps/jquery.ui.map.js',
			'ver' => $version,
		);
		$assets[ 'wr-googlemaps-services-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/googlemaps/jquery.ui.map.services.js',
			'ver' => $version,
		);
		$assets[ 'wr-googlemaps-extensions-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/googlemaps/jquery.ui.map.extensions.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-daterangepicker-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/daterangepicker/daterangepicker.js',
			'ver' => $version,
		);
		$assets[ 'wr-jquery-timepicker-js' ] = array(
			'src' => WR_CONTACTFORM_URI . 'assets/3rd-party/jquery-timepicker/jquery-ui-timepicker-addon.js',
			'ver' => $version,
		);

		return $assets;
	}

	/**
	 * Load Asset View Edit Form Settings
	 *
	 */
	public static function load_asset_edit_form() {
		//load asset
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'jquery-ui-resizable' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-button' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		add_thickbox();
		$assets = array(
			'wr-zero-clipboard-js',
			'wr-contactform-modal-js',
			'wr-bootstrap2-css',
			'wr-bootstrap2-jsn-gui-css',
			'wr-jquery-select2-css',
			'wr-bootstrap2-responsive-css',
			'wr-contactform-woorockets-css',
			'wr-bootstrap2-icomoon-css',
			'wr-jquery-ui-css',
			'wr-jquery-tipsy-css',
			'wr-jquery-ui-js',
			'wr-jquery-json-js',
			'wr-jquery-tmpl-js',
			'wr-jquery-placeholder-js',
			'wr-jquery-select2-js',
			'wr-jquery-tipsy-js',
			'wr-jquery-daterangepicker-js',
			'wr-jquery-timepicker-js',
			'wr-jquery-daterangepicker-js',
			'wr-colpick-js',
			'wr-jquery-wysiwyg-css',
			'wr-jquery-wysiwyg-js',
			'wr-jquery-wysiwyg-colorpicker-js',
			'wr-jquery-wysiwyg-table-js',
			'wr-jquery-wysiwyg-cssWrap-js',
			'wr-jquery-wysiwyg-image-js',
			'wr-jquery-wysiwyg-link-js',
			'wr-jquery-codemirror-js',
			'wr-jquery-codemirror-matchbrackets-js',
			'wr-jquery-codemirror-mode-css-js',
			'wr-jquery-codemirror-markselection-js',
			'wr-jquery-codemirror-activeline-js',
			'wr-jquery-codemirror-css',
			'wr-colpick-css',
			'wr-contactform-css',
			'wr-contactform-visualdesign-js',
			'wr-contactform-icon-font-css',
			'wr-http-googlemaps-api-js',
			'wr-googlemaps-ui-js',
			'wr-googlemaps-services-js',
			'wr-googlemaps-extensions-js',
		);
		$assets = apply_filters( 'wr_contactform_assets_form', $assets );
		$assets = array_merge(
			$assets, array(
				'wr-contactform-jquery-layout-js',
				'wr-contactform-itemlist-js',
				'wr-contactform-controls-js',
				'wr-contactform-js',
				'wr-contactform-form-js',
			)
		);
		return $assets;
	}

	/**
	 * Method to get text translation.
	 *
	 * @param   array  $strings  String to translate.
	 *
	 * @return  array
	 */
	public static function get_translated( $strings ) {
		$translated = array();

		foreach ( $strings AS $string ) {
			$translated[ ( $string ) ] = str_replace( "'", '&apos;', __( $string, WR_CONTACTFORM_TEXTDOMAIN ) );
		}

		return $translated;
	}

	/**
	 * Render Options Button Style
	 *
	 * @param $value
	 *
	 * @return string
	 */
	public static function render_options_button_style( $defaultValue ) {

		$list = array(
			'btn' => 'Default',
			'btn btn-primary' => 'Primary',
			'btn btn-info' => 'Info',
			'btn btn-success' => 'Success',
			'btn btn-warning' => 'Warning',
			'btn btn-danger' => 'Danger',
			'btn btn-inverse' => 'Inverse',
			'btn btn-link' => 'Link',
		);
		$options = '';
		foreach ( $list as $key => $value ) {
			$selected = '';
			if ( $key == $defaultValue ) {
				$selected = "selected='selected'";
			}
			$options .= "<option {$selected} value='{$key}'>{$value}</option>";
		}
		return $options;
	}

	/**
	 * Render Options Button Position
	 *
	 * @param $value
	 *
	 * @return string
	 */
	public static function render_options_button_position( $defaultValue ) {
		$list = array(
			'btn-toolbar' => 'Center',
			'btn-toolbar pull-left' => 'Left',
			'btn-toolbar pull-right' => 'Right',
		);
		$options = '';
		foreach ( $list as $key => $value ) {
			$selected = '';
			if ( $key == $defaultValue ) {
				$selected = 'selected="selected"';
			}
			$options .= "<option {$selected} value='{$key}'>{$value}</option>";
		}
		return $options;
	}

	/**
	 * Get list page form
	 *
	 * @param   string  $formContent  Form content
	 * @param   int     $formId       Form Id
	 *
	 * @return  html code
	 */
	public static function get_list_page( $formContent, $formId = 0 ) {
		//$session = JFactory::getSession();
		//session_start();
		//$listPage = $session->get('form_list_page', '', 'form-design-' . $formId);
		$listPage = isset ( $_SESSION[ 'form-design-' . $formId ][ 'form_list_page' ] ) ? $_SESSION[ 'form-design-' . $formId ][ 'form_list_page' ] : NULL;

		$option = '';

		$defaultListpage = '';

		$dataValue = '';

		$pageContent = array();

		if ( ! empty( $formContent ) ) {
			foreach ( $formContent as $i => $fContent ) {

				///$session->set('form_page_' . $fContent->page_id, $fContent->page_content, 'form-design-' . $formId);
				$_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $fContent->page_id ] = $fContent->page_content;

				if ( ! empty( $fContent->page_container ) && count( json_decode( $fContent->page_container ) ) ) {
					//$session->set('form_container_page_' . $fContent->page_id, $fContent->page_container, 'form-design-' . $formId);
					$_SESSION[ 'form-design-' . $formId ][ 'form_container_page_' . $fContent->page_id ] = $fContent->page_container;
				}
				else {
					//$session->set('form_container_page_' . $fContent->page_id, '[[{"columnName":"left","columnClass":"span12"}]]', 'form-design-' . $formId);
					$_SESSION[ 'form-design-' . $formId ][ 'form_container_page_' . $fContent->page_id ] = '[[{"columnName":"left","columnClass":"span12"}]]';
				}

				if ( count( $fContent->page_content ) ) {
					$pageContent[ ] = $fContent->page_id;
				}
				if ( $i == 0 ) {
					$defaultListpage .= '<div data-value="' . $fContent->page_id . '" id="form-design-header" class="jsn-section-header"><div class="jsn-iconbar-trigger page-title"><h1>' . $fContent->page_title . '</h1><div class="jsn-iconbar"><a href="javascript:void(0)" title="Edit page" class="element-edit"><i class="icon-pencil"></i></a><a href="javascript:void(0)" title="Delete page" class="element-delete"><i class="icon-trash"></i></a></div></div><div class="jsn-page-actions jsn-buttonbar"><div class="jsn-page-pagination pull-left btn-group"><button onclick="return false;" class="btn btn-icon prev-page"><i class="icon-arrow-left"></i></button><button onclick="return false;" class="btn btn-icon next-page"><i class="icon-arrow-right"></i></button></div><button onclick="return false;" class="btn btn-success new-page">' . __(
						'New Page', WR_CONTACTFORM_TEXTDOMAIN
					) . '</button></div><div class="clearbreak"></div>';
					$dataValue = $fContent->page_id;
				}
				$option .= '<li id="' . $fContent->page_id . '" data-value="' . $fContent->page_id . '" class="page-items"><input type="hidden" value="' . $fContent->page_title . '" data-id="' . $fContent->page_id . '" name="name_page[' . $fContent->page_id . ']"/></li>';
			}

			if ( count( $pageContent ) ) {
				//$session->set('page_content', json_encode($pageContent), 'form-design-' . $formId);
				$_SESSION[ 'form-design-' . $formId ][ 'page_content' ] = json_encode( $pageContent );
			}
		}
		elseif ( $listPage ) {
			$listPages = json_decode( $listPage );
			foreach ( $listPages as $i => $page ) {
				if ( $i == 0 ) {
					$defaultListpage .= '<div data-value="' . $page[ 0 ] . '" id="form-design-header" class="jsn-section-header"><div class="jsn-iconbar-trigger page-title"><h1>' . $page[ 1 ] . '</h1><div class="jsn-iconbar"><a href="javascript:void(0)" title="Edit page" class="element-edit"><i class="icon-pencil" ></i></a><a href="javascript:void(0)" title="Delete page" class="element-delete"><i class="icon-trash" ></i></a></div></div><div class="jsn-page-actions jsn-buttonbar"><div class="jsn-page-pagination pull-left btn-group"><button onclick="return false;" class="btn btn-icon prev-page"><i class="icon-arrow-left"></i></button><button onclick="return false;" class="btn btn-icon next-page"><i class="icon-arrow-right"></i></button></div><button onclick="return false;" class="btn btn-success new-page">' . __(
						'New Page', WR_CONTACTFORM_TEXTDOMAIN
					) . '</button></div><div class="clearbreak"></div>';
					$dataValue = $page[ 0 ];
				}
				$option .= '<li id="' . $page[ 0 ] . '" data-value="' . $page[ 0 ] . '" class="page-items"><input type="hidden" value="' . $page[ 1 ] . '" data-id="' . $page[ 0 ] . '" name="name_page[' . $page[ 0 ] . ']"/></li>';
			}
		}
		else {
			$randomID = rand( 1000000, 10000000000 );
			$defaultListpage = '<div data-value="' . $randomID . '" id="form-design-header" class="jsn-section-header"><div class="jsn-iconbar-trigger page-title"><h1>Page 1</h1><div class="jsn-iconbar"><a href="javascript:void(0)" title="Edit page" class="element-edit"><i class="icon-pencil"></i></a><a href="javascript:void(0)" title="Delete page" class="element-delete"><i class="icon-trash" ></i></a></div></div><div class="jsn-page-actions jsn-buttonbar"><div class="jsn-page-pagination pull-left btn-group"><button onclick="return false;" class="btn btn-icon prev-page"><i class="icon-arrow-left"></i></button><button onclick="return false;" class="btn btn-icon next-page"><i class="icon-arrow-right"></i></button></div><button onclick="return false;" class="btn btn-success new-page">' . __(
				'New Page', WR_CONTACTFORM_TEXTDOMAIN
			) . '</button></div><div class="clearbreak"></div>';
			$dataValue = $randomID;
			$option = '<li id="new_' . $randomID . '" data-value="' . $randomID . '" class="page-items"><input type="hidden" value="Page 1" data-id="' . $randomID . '" name="name_page[' . $randomID . ']"/></li>';
			if ( ! empty( $_GET[ 'form' ] ) ) {
				$getSampleForm = WR_Contactform_Helpers_Contactform::get_sample_form( $_GET[ 'form' ] );
				$_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $randomID ] = $getSampleForm;
				$_SESSION[ 'form-design-' . $formId ][ 'form_list_page' ] = json_encode( array( $randomID, 'Page 1' ) );
				$_SESSION[ 'form-design-' . $formId ][ 'form_container_page_' . $randomID ] = '[[{"columnName":"left","columnClass":"span12"}]]';
			}
		}
		$select = $defaultListpage . '<ul class="jsn-page-list hide">' . $option . '</ul></div>';
		return $select;
	}

	/**
	 * get form content
	 *
	 * @param $formId   Form ID
	 *
	 * @return array
	 */
	public static function get_form_content( $formId ) {
		global $wpdb;
		if ( ! empty( $formId ) && is_numeric( $formId ) ) {
			return $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}wr_contactform_form_pages WHERE form_id = %d ORDER BY page_id ASC", $formId
				)
			);
		}
		return array();
	}

	/**
	 * get form content
	 *
	 * @param $formId   Form ID
	 *
	 * @return array
	 */
	public static function get_filed_by_form_id( $formId ) {
		global $wpdb;
		if ( ! empty( $formId ) && is_numeric( $formId ) ) {
			return $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}wr_contactform_fields WHERE form_id = %d", $formId
				)
			);
		}
		return array();
	}

	/**
	 * Get Sample Form
	 *
	 * @param   string  $formType  Form Type
	 *
	 * @return  html code
	 */
	public static function get_sample_form( $formType ) {
		$createSampleForm = array();
		$createSampleForm = apply_filters( 'wr_contactform_create_form_sample', $createSampleForm );
		if ( ! empty( $createSampleForm[ $formType ] ) ) {
			return $createSampleForm[ $formType ];
		}
	}

	/**
	 * Generate Style Pages
	 *
	 * @param   Object  $formStyle                List style opbject
	 * @param   String  $container                class css container
	 * @param   String  $containerActive          class css container active
	 * @param   String  $title                    class css title
	 * @param   String  $messageErrors            class css title
	 * @param   String  $messageBackgroundErrors  class css Background errors
	 * @param   String  $field                    class css field
	 *
	 * @return string
	 */
	public static function generate_style_pages( $formStyle, $container = '', $containerActive = '', $title = '', $messageErrors = '', $messageBackgroundErrors = '', $field = '' ) {
		if ( ! empty( $container ) ) {
			$styleCustom[ ] = $container . '{';
			if ( ! empty( $formStyle->background_color ) ) {
				$styleCustom[ ] = 'background-color:' . $formStyle->background_color . ';';
			}
			if ( ! empty( $formStyle->border_thickness ) ) {
				$styleCustom[ ] = 'border:' . $formStyle->border_thickness . 'px solid;';
			}
			if ( ! empty( $formStyle->border_color ) ) {
				$styleCustom[ ] = 'border-color:' . $formStyle->border_color . ';';
			}
			if ( ! empty( $formStyle->rounded_corner_radius ) ) {
				$styleCustom[ ] = 'border-radius:' . $formStyle->rounded_corner_radius . 'px;';
			}
			if ( ! empty( $formStyle->rounded_corner_radius ) ) {
				$styleCustom[ ] = '-moz-border-radius:' . $formStyle->rounded_corner_radius . ';';
			}
			if ( ! empty( $formStyle->rounded_corner_radius ) ) {
				$styleCustom[ ] = '-webkit-border-radius:' . $formStyle->rounded_corner_radius . ';';
			}
			if ( ! empty( $formStyle->padding_space ) ) {
				$styleCustom[ ] = 'padding:' . $formStyle->padding_space . 'px;';
			}
			if ( ! empty( $formStyle->margin_space ) ) {
				$styleCustom[ ] = 'margin:' . $formStyle->margin_space . 'px 0px;';
			}
			$styleCustom[ ] = '}';
		}
		if ( ! empty( $containerActive ) ) {
			$styleCustom[ ] = $containerActive . '{';
			if ( ! empty( $formStyle->background_active_color ) ) {
				$styleCustom[ ] = 'background-color:' . $formStyle->background_active_color . ';';
			}
			if ( ! empty( $formStyle->border_active_color ) ) {
				$styleCustom[ ] = 'border-color:' . $formStyle->border_active_color . ';';
			}
			$styleCustom[ ] = '}';
		}
		if ( ! empty( $title ) ) {
			$styleCustom[ ] = $title . ' {';
			if ( ! empty( $formStyle->text_color ) ) {
				$styleCustom[ ] = 'color:' . $formStyle->text_color . ';';
			}
			if ( ! empty( $formStyle->font_type ) ) {
				$styleCustom[ ] = 'font-family:' . $formStyle->font_type . ';';
			}
			if ( ! empty( $formStyle->font_size ) ) {
				$styleCustom[ ] = 'font-size:' . $formStyle->font_size . 'px;';
			}
			$styleCustom[ ] = '}';
			if ( ( ! empty( $formStyle->help_text_type ) ) && ( $formStyle->help_text_type == 'tooltip' ) ) {
				$styleCustom[] = $title . ' .wr-help-text {';
			} else {
				$styleCustom[] = $title . ' .icon-question-sign {';
			}
			$styleCustom[] = 'display: none;';
			$styleCustom[] = '}';
		}
		if ( ! empty( $messageErrors ) ) {
			$styleCustom[ ] = $messageErrors . ' {';
			if ( ! empty( $formStyle->message_error_text_color ) ) {
				$styleCustom[ ] = 'color:' . $formStyle->message_error_text_color . ';';
			}
			$styleCustom[ ] = '}';
		}

		if ( ! empty( $messageBackgroundErrors ) ) {
			$styleCustom[ ] = $messageBackgroundErrors . ' {';
			if ( ! empty( $formStyle->message_error_background_color ) ) {
				$styleCustom[ ] = 'background-color:' . $formStyle->message_error_background_color . ';';
			}
			$styleCustom[ ] = '}';
		}
		if ( $messageErrors ) {
			$styleCustom[ ] = $messageErrors . ' {';
			if ( ! empty( $formStyle->message_error_text_color ) ) {
				$styleCustom[ ] = 'color:' . $formStyle->message_error_text_color . ';';
			}
			$styleCustom[ ] = '}';
		}
		if ( ! empty( $field ) ) {
			$styleCustom[ ] = $field . '{';
			if ( ! empty( $formStyle->field_background_color ) ) {
				$styleCustom[ ] = 'background:' . $formStyle->field_background_color . ';';
			}
			if ( ! empty( $formStyle->field_shadow_color ) ) {
				$styleCustom[ ] = 'box-shadow:0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 7px 0 rgba(' . self::hex2rgb(
					$formStyle->field_shadow_color
				) . ',0.8) inset;';
			}
			if ( ! empty( $formStyle->field_border_color ) ) {
				$styleCustom[ ] = 'border-color:' . $formStyle->field_border_color . ';';
			}
			if ( ! empty( $formStyle->field_text_color ) ) {
				$styleCustom[ ] = 'color:' . $formStyle->field_text_color . ';';
			}
			$styleCustom[ ] = '}';
		}
		return implode( $styleCustom );
	}

	/**
	 * Convert color hex to rgb
	 *
	 * @param   $colour  Color hex
	 *
	 * @return array|bool
	 */
	public static function hex2rgb( $colour = '' ) {
		if ( $colour[ 0 ] == '#' ) {
			$colour = substr( $colour, 1 );
		}
		if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array(
				$colour[ 0 ] . $colour[ 1 ],
				$colour[ 2 ] . $colour[ 3 ],
				$colour[ 4 ] . $colour[ 5 ],
			);
		}
		elseif ( strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array(
				$colour[ 0 ] . $colour[ 0 ],
				$colour[ 1 ] . $colour[ 1 ],
				$colour[ 2 ] . $colour[ 2 ],
			);
		}
		else {
			return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );
		return $r . ',' . $g . ',' . $b;
	}


	/**
	 * Get action form submission
	 *
	 * @param   int     $action      Action value
	 *
	 * @param   string  $actionData  Action data
	 *
	 * @return array
	 */
	public static function action_from( $action = null, $actionData = null ) {
		$redirectToUrl = '';
		$menuItem = '';
		$menuItemTitle = '';
		$article = '';
		$articleTitle = '';
		$message = '';
		if ( isset( $action ) ) {
			switch ( $action ) {
				case 1:
					$redirectToUrl = $actionData;
					break;
				case 2:

					break;
				case 3:

					break;
				case 4:
					$message = $actionData;
					break;
			}
		}
		else {
			$action = 0;
		}
		return array(
			'redirect_to_url' => $redirectToUrl,
			'menu_item' => $menuItem,
			'menu_item_title' => $menuItemTitle,
			'article' => $article,
			'article_title' => $articleTitle,
			'message' => $message,
			'action' => $action,
		);
	}

	/**
	 ** public taxonomy options
	 *
	 * @param bool $is_full
	 *
	 * @return array
	 */
	static function get_public_taxonomies( $is_full = false ) {
		$arr_taxs = array();
		if ( ! $is_full ) {
			$taxs = get_taxonomies( array( 'public' => true, 'show_ui' => true ), 'objects' );
		}
		else {
			$taxs = get_taxonomies( null, 'objects' );
		}
		foreach ( $taxs as $i => $tax ) {
			if ( isset( $tax->labels->singular_name ) && trim( $tax->labels->singular_name ) != '' ) {
				$arr_taxs[ $tax->name ] = __( $tax->labels->singular_name, WR_CONTACTFORM_TEXTDOMAIN );
			}
		}
		return $arr_taxs;
	}

	/**
	 * Static function get post type options
	 *
	 * @param bool $allow_filter
	 *
	 * @return array
	 */
	static function get_post_types( $allow_filter = false ) {
		$arr_posts = array();
		$posts = get_post_types( array( 'public' => true, 'show_ui' => true ), 'objects' );
		foreach ( $posts as $i => $post ) {
			if ( ! $allow_filter ) {
				if ( $post->name == 'attachment' || $post->name == 'wr_cf_post_type' || $post->name == 'wr_cfsb_post_type' ) continue;
				if ( isset( $post->labels->singular_name ) && trim( $post->labels->singular_name ) != '' ) {
					$arr_posts[ $post->name ] = __( $post->labels->singular_name, WR_CONTACTFORM_TEXTDOMAIN );
				}
			}
			else {
				$arr_posts[ ] = $post->name;
			}
		}
		/* Add filter get add action data submit form */
		$getAction = apply_filters( 'wr_contactform_get_action_data_submit_form', $arr_posts );
		if ( ! empty( $getAction ) ) {
			$arr_posts = $getAction;
		}
		return $arr_posts;
	}

	/**
	 * link type options
	 *
	 * @return multitype:
	 */
	static function get_link_types() {
		$taxonomies = self::get_public_taxonomies();
		$post_types = self::get_post_types();
		$action = array(
			'contactform_show_message' => __( 'Show Custom Message', WR_CONTACTFORM_TEXTDOMAIN ),
			'contactform_url' => __( 'Go to URL', WR_CONTACTFORM_TEXTDOMAIN ),
			'single_entry' => array(
				'text' => __( 'Go to Single Entry', WR_CONTACTFORM_TEXTDOMAIN ),
				'type' => 'optiongroup',
				'options' => $post_types,
			),
			'taxonomy' => array(
				'text' => __( 'Go to Taxonomy Overview Page', WR_CONTACTFORM_TEXTDOMAIN ),
				'type' => 'optiongroup',
				'options' => $taxonomies,
			),
            'contactform_no_action' => __( 'No Action', WR_CONTACTFORM_TEXTDOMAIN ),
		);
		/* Add filter get add action submit form */
		$getAction = apply_filters( 'wr_contactform_get_action_submit_form', $action );
		if ( ! empty( $getAction ) ) {
			$action = $getAction;
		}
		return $action;
	}

	/**
	 ** list of single item by post types: post, page, custom post type...
	 *
	 * @param string $posttype
	 *
	 * @return array
	 */
	static function get_single_by_post_types( $posttype = '' ) {
		$posttypes = self::get_post_types();
		$results = array();
		foreach ( $posttypes as $slug => $name ) {
			if ( ! isset( $results[ $slug ] ) ) $results[ $slug ] = array();
			// query post by post type
			$args = array(
				'post_type' => $slug,
				'posts_per_page' => - 1,
				'post_status' => ( $slug == 'attachment' ) ? 'inherit' : 'publish',
			);
			$query = new WP_Query( $args );
			while ( $query->have_posts() ) {
				$query->the_post();
				$results[ $slug ][ get_the_ID() ] = __( get_the_title(), WR_CONTACTFORM_TEXTDOMAIN );
			}
			wp_reset_postdata();
		}
		if ( $posttype ) return $results[ $posttype ];
		return $results;
	}

	/**
	 ** terms by taxonomies
	 *
	 * @param string $taxonomy
	 * @param string $allow_root
	 * @param string $order_by
	 *
	 * @return array
	 */
	static function get_term_taxonomies( $taxonomy = '', $allow_root = false, $order_by = 'count' ) {
		$taxonomies = self::get_public_taxonomies();
		$term_taxos = array();
		foreach ( $taxonomies as $taxo_slug => $taxo_name ) {
			if ( ! isset( $term_taxos[ $taxo_slug ] ) ) $term_taxos[ $taxo_slug ] = array();
			if ( $allow_root ) {
				$exclude_taxo = self::_get_exclude_taxonomies();
				if ( in_array( $taxo_slug, $exclude_taxo ) ) {
					$term_taxos[ $taxo_slug ][ 'root' ] = __( 'Root', WR_CONTACTFORM_TEXTDOMAIN );
				}
			}
			$terms = get_terms(
				$taxo_slug, array(
					'orderby' => $order_by,
					'hide_empty' => 0,
				)
			);

			if ( $order_by == 'name' ) {
				$return = array();
				$level = 0;
				$arr_return = $terms;
				foreach ( $arr_return as $i => $item ) {
					if ( $item->parent == 0 ) {
						unset( $arr_return[ $i ] );
						if ( ! $item->name ) {
							$item->name = __( '( no name )', WR_CONTACTFORM_TEXTDOMAIN );
						}
						$return[ $item->term_id ] = $item->name;
						self::_recur_tree( $return, $arr_return, $item->term_id, $level, '1' );
					}
				}
				foreach ( $return as $id => $name ) {
					foreach ( $terms as $term ) {
						if ( $id == $term->term_id ) {
							$term_taxos[ $taxo_slug ][ $term->term_id ] = __( $name, WR_CONTACTFORM_TEXTDOMAIN );
						}
					}
				}
			}
			else {
				foreach ( $terms as $term ) {
					$term_taxos[ $taxo_slug ][ $term->term_id ] = __( $term->name, WR_CONTACTFORM_TEXTDOMAIN );
				}
			}
		}
		if ( $taxonomy ) return $term_taxos[ $taxonomy ];
		return $term_taxos;
	}

	/**
	 ** Single Entry options for Button Bar
	 *
	 * @param string $check_val
	 * @param array  $attrs
	 *
	 * @return array
	 */
	static function get_single_item_button_bar() {
		$post_singles = self::get_single_by_post_types();
		$term_taxos = self::get_term_taxonomies();
		$result = array();
		foreach ( array_merge( $post_singles, $term_taxos ) as $taxo => $terms ) {
			$tmp_arr = array();
			$tmp_arr[ 'name' ] = $taxo;
			$tmp_arr[ 'options' ] = $terms;
			$result[ ] = $tmp_arr;
		}
		return $result;
	}

	/**
	 * generate HTML Pages
	 *
	 * @param   Object  $postId          Post Id
	 * @param   Object  $formId          Form Id
	 * @param   String  $formName        Form Name
	 * @param   String  $formType        Form Type
	 * @param   String  $topContent      Module Top content
	 * @param   String  $bottomContent   Module Bottom Content
	 * @param   String  $showTitle       State Show Title Form
	 * @param   String  $showDes         State Show Description Form
	 *
	 * @return string
	 */
	public static function generate_html_pages( $postId, $formId, $formName, $formType = '', $topContent = '', $bottomContent = '', $showTitle = false, $showDes = false ) {

		$html = '';
		$assets = array();
		// add Filter apply assets
		load_plugin_textdomain( WR_CONTACTFORM_TEXTDOMAIN, false, WR_CONTACTFORM_TEXTDOMAIN . '/frontend/languages/' );
		//$assets[ ] = 'wr-contactform-jquery-ui-css';
		$loadBootstrap = get_option( 'wr_contactform_load_bootstrap_css', 1 );
		if ( $loadBootstrap != '0' && $loadBootstrap != 0 ) {
			$assets[ ] = 'wr-bootstrap2-css';
		}
		$items = get_post_meta( (int)$postId );
		$formPages = self::get_form_content( (int)$formId );

		$scheme = parse_url( get_site_url(), PHP_URL_SCHEME );

		/* define language */
		$arrayTranslated = array(
			'The password must contain minimum %mi% and maximum %mx% character(s)',
			'Both email addresses must be the same.',
			'The number cannot be less than',
			'The number cannot be greater than',
			'WR_CONTACTFORM_DATE_HOUR_TEXT',
			'WR_CONTACTFORM_DATE_MINUTE_TEXT',
			'WR_CONTACTFORM_DATE_CLOSE_TEXT',
			'Prev',
			'Next',
			'Today',
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December',
			'Jan',
			'Feb',
			'Mar',
			'Apr',
			'May',
			'Jun',
			'Jul',
			'Aug',
			'Sep',
			'Oct',
			'Nov',
			'Dec',
			'Sunday',
			'Monday',
			'Tuesday',
			'Wednesday',
			'Thursday',
			'Friday',
			'Saturday',
			'Sun',
			'Mon',
			'Tue',
			'Wed',
			'Thu',
			'Fri',
			'Sat',
			'Su',
			'Mo',
			'Tu',
			'We',
			'Th',
			'Fr',
			'Sa',
			'Wk',
			'The information cannot contain more than',
			'The information cannot contain less than',
			'WR_CONTACTFORM_CAPTCHA_PUBLICKEY',
			'WR_CONTACTFORM_BUTTON_BACK',
			'WR_CONTACTFORM_BUTTON_NEXT',
			'WR_CONTACTFORM_BUTTON_RESET',
			'WR_CONTACTFORM_BUTTON_SUBMIT',
			'This field can not be empty, please enter required information.',
			'The information is invalid, please correct.',
		);
		/* Check load JS */
		$checkLoadJS = array();
		$checkLoadJSTipsy = false;
		$formSettings = ! empty( $items[ 'form_settings' ][ 0 ] ) ? json_decode( $items[ 'form_settings' ][ 0 ] ) : '';
		if ( $formPages ) {
			$formStyleCustom = new stdClass;
			if ( ! empty( $items[ 'form_style' ][ 0 ] ) ) {
				$formStyleCustom = json_decode( $items[ 'form_style' ][ 0 ] );
			}
			$dataSumbission = '';
			$classForm = ! empty( $formStyleCustom->layout ) ? $formStyleCustom->layout : '';
			$formTheme = ! empty( $formStyleCustom->theme ) ? $formStyleCustom->theme : '';
			if ( ! $formType ) {
				wp_enqueue_style( 'contactform_form_' . $formId, site_url() . '/?wr-cf-gadget=contactform-style&action=default&form_id=' . $formId );
				$html .= "<div class=\"wr-contactform jsn-master\" data-form-name='" . $formName . "' id='wr_form_" . $formId . "'><div class=\"jsn-bootstrap\">";
				$html .= $topContent;
				$html .= "<form name='form_{$formName}' id='form_{$formName}' action=\"" . site_url() . '/?wr-cf-gadget=contactform-frontend&action=default&task=form.save&form_id=' . $formId . "\" method=\"post\" class=\"form-validate {$classForm} \" enctype=\"multipart/form-data\" >";
				$html .= "<span class=\"hide wr-language\" style=\"display:none;\" data-value='" . json_encode( WR_Contactform_Helpers_Contactform::get_translated( $arrayTranslated ) ) . "'></span>";
				$html .= '<span class="hide wr-base-url" style="display:none;" data-value="' . get_site_url() . '"></span>';
				$html .= '<div id="page-loading" class="jsn-bgloading"><i class="jsn-icon32 jsn-icon-loading"></i></div>';
				$html .= '<div class="jsn-row-container ' . $formTheme . '">';
			}
			$html .= '<div class="message-contactform"> </div>';
			include_once ( WR_CONTACTFORM_PATH . 'helpers/form.php' );

			foreach ( $formPages as $i => $contentForm ) {

				$pageContainer = ! empty( $contentForm->page_container ) && json_decode( $contentForm->page_container ) ? $contentForm->page_container : '[[{"columnName":"left","columnClass":"span12"}]]';
				$formContent = isset( $contentForm->page_content ) ? json_decode( $contentForm->page_content ) : '';

				$htmlForm = '';
				if ( ! empty( $formContent ) ) {
					foreach ( $formContent as $content ) {
						if ( ! empty( $content->options->instruction ) || ! empty( $content->instruction ) ) {
							$checkLoadJSTipsy = true;
						}
						if ( ! empty( $content->type ) ) {
							$checkLoadJS[ $content->type ] = $content->type;
						}
					}
					$htmlForm .= WR_Contactform_Helpers_Form::generate( $formContent, $dataSumbission, $pageContainer );
				}
				$html .= "<div data-value=\"{$contentForm->page_id}\" class=\"jsn-form-content hide\">{$htmlForm}";
				if ( $i + 1 == count( $formPages ) ) {
					$global_captcha_setting = get_option( 'wr_contactform_global_captcha_setting', 2 );
					if ( $global_captcha_setting != 0 ) {
						if ( ! empty( $formSettings->form_captcha ) && $formSettings->form_captcha == 1 ) {

							if ( $scheme == 'https' ) {
								$html .= '<script type="text/javascript" src="https://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>';
							}
							else {
								$html .= '<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>';
							}
							$html .= '<div id="' . md5( date( 'Y-m-d H:i:s' ) . $i . $formName ) . '"  publickey="' . WR_CONTACTFORM_CAPTCHA_PUBLICKEY . '" class="form-captcha control-group"></div>';
						}
						else if ( ( ! empty( $formSettings->form_captcha ) && $formSettings->form_captcha == 2 ) || $global_captcha_setting == 1 ) {
							include_once ( WR_CONTACTFORM_PATH . 'libraries/3rd-party/securimage/securimage.php' );
							$img = new Securimage();
							$img->case_sensitive = true; // true to use case sensitve codes - not recommended
							$img->image_bg_color = new Securimage_Color( '#ffffff' ); // image background color
							$img->text_color = new Securimage_Color( '#000000' ); // captcha text color
							$img->num_lines = 0; // how many lines to draw over the image
							$img->line_color = new Securimage_Color( '#0000CC' ); // color of lines over the image
							$img->namespace = $formName;
							$img->signature_color = new Securimage_Color( rand( 0, 64 ), rand( 64, 128 ), rand( 128, 255 ) ); // random signature color
							ob_start();
							$img->show( WR_CONTACTFORM_PATH . 'libraries/3rd-party/securimage/backgrounds/bg4.png' );
							$dataCaptcha = base64_encode( ob_get_clean() );
							$html .= '<div class="control-group wr-captcha-block">
										<div class="controls">
										<div class="row-fluid"><img src="data:image/png;base64,' . $dataCaptcha . '" alt="CAPTCHA" /></div>
										<input type="text" id="wr-captcha" name="captcha" autocomplete="off" placeholder="' . __( 'Captcha', WR_CONTACTFORM_TEXTDOMAIN ) . '">
										</div>
										</div>';
						}
					}
				}
				$html .= '</div>';
			}
			$btnNext = ! empty( $formSettings->form_btn_next_text ) ? $formSettings->form_btn_next_text : 'Next';
			$btnPrev = ! empty( $formSettings->form_btn_prev_text ) ? $formSettings->form_btn_prev_text : 'Prev';
			$btnSubmit = ! empty( $formSettings->form_btn_submit_text ) ? $formSettings->form_btn_submit_text : 'Submit';
			$btnReset = ! empty( $formSettings->form_btn_reset_text ) ? $formSettings->form_btn_reset_text : 'Reset';
			$btnNextStyle = ! empty( $formStyleCustom->button_next_color ) ? $formStyleCustom->button_next_color : 'btn  btn-primary';
			$btnPrevStyle = ! empty( $formStyleCustom->button_prev_color ) ? $formStyleCustom->button_prev_color : 'btn';
			$btnSubmitStyle = ! empty( $formStyleCustom->button_submit_color ) ? $formStyleCustom->button_submit_color : 'btn  btn-primary';
			$btnResetStyle = ! empty( $formStyleCustom->button_reset_color ) ? $formStyleCustom->button_reset_color : 'btn';
			$btnPosition = ! empty( $formStyleCustom->button_position ) ? $formStyleCustom->button_position : 'btn-toolbar';
			$htmlBtnReset = '';
			if ( ! empty( $formSettings->form_state_btn_reset_text ) && $formSettings->form_state_btn_reset_text == 'Yes' ) {
				$htmlBtnReset = '<button class="' . $btnResetStyle . ' reset" onclick="return false;">' . __( $btnReset, WR_CONTACTFORM_TEXTDOMAIN ) . '</button>';
			}
			$html .= '<div class="form-actions">
									<div class="' . $btnPosition . '">
									    <button class="' . $btnPrevStyle . ' prev hide" onclick="return false;">' . __( $btnPrev, WR_CONTACTFORM_TEXTDOMAIN ) . '</button>
									    <button class="' . $btnNextStyle . ' next hide" onclick="return false;">' . __( $btnNext, WR_CONTACTFORM_TEXTDOMAIN ) . '</button>
									    <button type="submit" class="' . $btnSubmitStyle . ' jsn-form-submit hide" >' . __( $btnSubmit, WR_CONTACTFORM_TEXTDOMAIN ) . '</button>
									    ' . $htmlBtnReset . '
									</div>
								     </div>';
			$postAction = isset( $items[ 'form_post_action' ][ 0 ] ) ? $items[ 'form_post_action' ][ 0 ] : '';
			$postActionData = isset( $items[ 'form_post_action_data' ][ 0 ] ) ? $items[ 'form_post_action_data' ][ 0 ] : '';
			$html .= '<input type="hidden" name="form_name" value="' . $formName . '" />';
			if ( ! $formType ) {
				$html .= '</div>';
				$html .= '<input type="hidden" name="form_id" value="' . $formId . '" />';
				$html .= '<input type="hidden" id="form_post_action" name="form_post_action" value="' . $postAction . '" />';
				$html .= '<input type="hidden" name="form_post_action_data" value=\'' . htmlentities( json_encode( unserialize( $postActionData ) ), ENT_QUOTES, 'UTF-8' ) . '\' />';
				$html .= '</form>';
				$html .= $bottomContent;
				$html .= '</div></div>';
			}
			/* Load JS */
			if ( ! empty( $checkLoadJS[ 'date' ] ) ) {
				$assets[ ] = 'wr-jquery-ui-css';
			}
			wp_enqueue_script( 'jquery' );
			$assets[ ] = 'wr-jquery-json-js';
			$assets[ ] = 'wr-jquery-placeholder-js';
			if ( $checkLoadJSTipsy ) {
				$assets[ ] = 'wr-jquery-tipsy-css';
				$assets[ ] = 'wr-jquery-tipsy-js';
			}
			$assets[ ] = 'wr-jquery-scrollto-js';
			$loadBootstrapJs = get_option( 'wr_contactform_load_bootstrap_js', 1 );
			if ( $loadBootstrapJs != '0' && $loadBootstrapJs != 0 ) {
				$assets[ ] = 'wr-frontend-contactform-bootstrap-js';
			}
			if ( ! empty( $checkLoadJS[ 'date' ] ) ) {
				wp_enqueue_script( 'jquery-ui' );
				wp_enqueue_script( 'jquery-ui-datepicker' );
				$assets[ ] = 'wr-jquery-daterangepicker-js';
				$assets[ ] = 'wr-jquery-timepicker-js';
			}
			if ( ! empty( $checkLoadJS[ 'google-maps' ] ) ) {
				if ( $scheme == 'https' ) {
					$assets[ ] = 'wr-https-googlemaps-api-js';
				}
				else {
					$assets[ ] = 'wr-http-googlemaps-api-js';
				}
				$assets[ ] = 'wr-googlemaps-ui-js';
				$assets[ ] = 'wr-googlemaps-services-js';
				$assets[ ] = 'wr-googlemaps-extensions-js';
			}
			$getFilterAssets = apply_filters( 'wr_contactform_filter_frontend_load_assets', $assets, $checkLoadJS );
			if ( ! empty( $getFilterAssets ) ) {
				$assets = $getFilterAssets;
			}

			$assets[ ] = 'wr-frontend-contactform-js';
		}
		$assets[ ] = 'wr-bootstrap2-icomoon-css';
		$assets[ ] = 'wr-bootstrap2-jsn-gui-css';
		$assets[ ] = 'wr-frontend-contactform-css';

		WR_CF_Init_Assets::load( $assets );
		return $html;
	}

	/**
	 * Get data field
	 *
	 * @param   string   $fieldType   Field type
	 *
	 * @param   object   $submission  Data submission
	 *
	 * @param   string   $key         Key field
	 *
	 * @param   int      $formId      Form id
	 *
	 * @param   boolean  $linkImg     Link Imgages
	 *
	 * @param   boolean  $checkNull   Check validate null
	 *
	 * @param   string   $action      Action data
	 *
	 * @return html code
	 */
	public static function get_data_field( $fieldType, $submission, $key, $formId, $linkImg = false, $checkNull = true, $action = '' ) {
		if ( ! empty( $key ) ) {
			$dataField = $submission->$key;
		}
		else {
			$dataField = $submission->submission_data_value;
		}
		if ( $fieldType == 'checkboxes' || $fieldType == 'list' ) {
			if ( ! empty( $dataField ) ) {
				$jsonName = json_decode( $dataField );
				if ( $action == 'email' ) {
					if ( ! empty( $jsonName ) && is_array( $jsonName ) ) {
						$listCheckBox = '';
						foreach ( $jsonName as $item ) {
							$listCheckBox .= '<li style=`"padding:0;">' . $item . '</li>';
						}
						if ( $listCheckBox ) {
							$contentField = '<ul style="padding:0 0px 0px 10px;margin:0;">' . $listCheckBox . '</ul>';
						}
						else {
							$contentField = '';
						}
					}
				}
				else {
					if ( empty( $jsonName ) ) {
						$jsonName = explode( '\n', $dataField );
						$contentField = implode( '<br/>', $jsonName );
					}
					elseif ( ! empty( $jsonName ) && is_array( $jsonName ) ) {
						$contentField = implode( '<br/>', $jsonName );
					}
					else {
						$contentField = $dataField;
					}
				}
			}
			else {
				$contentField = '';
			}
		}
		else {
			$getContentField = apply_filters( 'wr_contactform_get_content_field_' . str_replace( '-', '_', $fieldType ), $dataField, $fieldType, $submission, $key, $formId, $linkImg, $checkNull, $action );
			if ( ! empty( $getContentField ) ) {
				$contentField = $getContentField;
			}
			else {
				if ( $checkNull ) {
					$contentField = isset( $dataField ) ? $dataField : '<span>N/A</span>';
				}
				else {
					$contentField = isset( $dataField ) ? $dataField : '';
				}
			}
		}
		return isset( $contentField ) ? $contentField : '';
	}

	/**
	 * Retrieve form data for use in page list submission
	 *
	 * @return Object List
	 */
	public static function get_form_data( $formID, $submissionId ) {
		global $wpdb;
		if ( ! empty( $formID ) && is_numeric( $formID ) && ! empty( $submissionId ) && is_numeric( $submissionId ) ) {
			return $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}wr_contactform_submission_data WHERE form_id = %d AND submission_id = %d", $formID, $submissionId
				)
			);
		}
	}

	/**
	 * content footer
	 *
	 * @param bool $return
	 *
	 * @return mixed|string|void
	 */
	public static function get_footer( $return = false ) {
		add_filter( 'update_footer', array( __CLASS__, 'wr_contactform_update_footer' ) );
		$footer = '<div class="jsn-bootstrap wr-contactform-footer">
					<hr/>
					<div class="pull-left">
						<div>
							Powered by <a href="http://www.woorockets.com/?utm_source=ContactForm%20Backend&utm_medium=Text&utm_campaign=Powered%20By" target="_blank">WooRockets.com</a> | <a href="http://www.woorockets.com/docs/wr-contactform-user-manual/?utm_source=ContactForm%20Backend&utm_medium=Text&utm_campaign=Powered%20By" target="_blank">Documentation</a>
						</div>
					</div>
					<div class="clearbreak"></div>
			</div>';
		$getFooter = apply_filters( 'wr_contactform_footer', $footer );
		if ( ! empty( $getFooter ) ) {
			$footer = $getFooter;
		}
		if ( $return ) {
			return $footer;
		}
		else {
			echo '' . $footer;
		}
	}

	/**
	 * Update text footer
	 *
	 * @param $footer
	 *
	 * @return string
	 */
	public static function wr_contactform_update_footer( $footer ) {
		$footer = '';
		return $footer;
	}
	
	/**
	 * Customize the messages
	 * 
	 * @param $messages
	 * 
	 * @return mixed
	 */
	public static function set_messages( $messages ) {
		$post = get_post();
		$post_type = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );
		$messages[ 'wr_cf_post_type' ] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Form updated.' ),
			2 => __( 'Custom field updated.' ),
			3 => __( 'Custom field deleted.' ),
			4 => __( 'Form updated.' ),
			/* translators: %s: date and time of the revision */
			5 => isset( $_GET[ 'revision' ] ) ? sprintf( __( 'Form restored to revision from %s' ), wp_post_revision_title( (int) $_GET[ 'revision' ], false ) ) : false,
			6 => __( 'Form published.' ),
			7 => __( 'Form saved.' ),
			8 => __( 'Form submitted.' ),
			9 => sprintf(
				__( 'Form scheduled for: <strong>%1$s</strong>.' ),
				// translators: Publish box date format
				date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Form draft updated.' )
		);
		return $messages;
	}

	/**
	 * Default mail from
	 *
	 * @return string
	 */
	public static function get_default_mail_from() {
		$sitename = strtolower( $_SERVER['SERVER_NAME'] );
		if ( substr( $sitename, 0, 4 ) == 'www.' ) {
			$sitename = substr( $sitename, 4 );
		}
		$default_from = 'mail@' . $sitename;
		return $default_from;
	}

}
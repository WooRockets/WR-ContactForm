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
 * MailChimp add-on.
 *
 * @package  WR_ContactForm
 * @since    1.1.0
 */
class WR_CF_Addon_Mailchimp {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'wr_cf_register_assets', array( $this, 'register_assets' ) );
		add_filter( 'wr_contactform_assets_form', array( $this, 'load_assets' ) );
		add_action( 'wr_contactform_form_edit_form_action_position_3', array( $this, 'settings_panel' ), 10, 8 );
		add_action( 'wp_ajax_wr_contactform_addon_mailchimp_get_lists', array( $this, 'get_lists' ) );
		add_action( 'wp_ajax_wr_contactform_addon_mailchimp_get_lists_merge_vars', array( $this, 'get_lists_merge_vars' ) );
		add_action( 'wr_contactform_after_save_form_settings', array( $this, 'save_settings' ), 10, 1 );
		add_action( 'wr_contactform_after_save_form', array( $this, 'save_submission' ), 10, 8 );
		add_filter( 'wr_contactform_addon_mailchimp_submission_data_value', array( $this, 'filter_submission_value'), 10, 2 );
	}

	/**
	 * Register assets.
	 *
	 * @param   array   $assets   Array of assets
	 *
	 * @return  array
	 */
	public function register_assets( $assets ) {
		$version = defined( 'WR_CONTACTFORM_VERSION' ) ? WR_CONTACTFORM_VERSION : '1.0.0';
		$assets['wr-cf-addon-mailchimp-css'] = array(
			'src' => WR_CONTACTFORM_ADDON_MAILCHIMP_DIR_URL . 'assets/addon-mailchimp.css',
			'ver' => $version
		);
		$assets['wr-cf-addon-mailchimp-js'] = array(
			'src' => WR_CONTACTFORM_ADDON_MAILCHIMP_DIR_URL . 'assets/addon-mailchimp.js',
			'ver' => $version
		);
		return $assets;
	}

	/**
	 * Load assets.
	 *
	 * @param   array   $assets   Array of assets
	 *
	 * @return  array
	 */
	public function load_assets( $assets ) {
		$assets = array_merge(
			$assets, array(
				'wr-cf-addon-mailchimp-css',
				'wr-cf-addon-mailchimp-js'
			)
		);
		return $assets;
	}

	/**
	 * Render MailChimp settings panel.
	 *
	 * @param   array   $form          Form
	 * @param   array   $formStyle     Form style
	 * @param   array   $formSettings  Form settings
	 * @param   array   $listPage      Page list
	 * @param   array   $listFontType  Font type list
	 * @param   array   $items         Items
	 * @param   array   $formItems     Form items
	 * @param   array   $formPage      Form page
	 */
	public function settings_panel( $form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage ) {
		if ( isset( $_GET['post'] ) ) {
			global $wpdb;
			$mailchimpSettings = json_decode( get_post_meta( $_GET['post'], 'mailchimp_settings', true ) );
			$formPages = $wpdb->get_results( "SELECT page_content FROM {$wpdb->prefix}wr_contactform_form_pages WHERE form_id = {$_GET['post']} ORDER BY page_id ASC" );
			$formFields = array();
			foreach ( $formPages as $formPage ) {
				$formPageFields = json_decode( $formPage->page_content );
				$formFields += $formPageFields;
			}
		} else {
			$mailchimpSettings = new stdClass();
			$mailchimpSettings->use = 'no';
			$mailchimpSettings->apikey = '';
			$mailchimpSettings->lists = array();
			$formFields = array();
		}

		// Load view
		include( WR_CONTACTFORM_ADDON_MAILCHIMP_DIR_PATH . 'views/settings-panel.php');
	}

	/**
	 * Get MailChimp lists.
	 */
	public function get_lists() {
		$apiKey = $_POST['apikey'];
		$api = new Mailchimp( $apiKey );
		try {
			$lists = $api->lists->getList();
			echo json_encode( $lists );
		} catch( Exception $e ) {
			echo '{"status":"error","error":"An unknown error occurred processing your request."}';
		}
		exit();
	}

	/**
	 * Get MailChimp list's merge vars.
	 */
	public function get_lists_merge_vars() {
		$apiKey = $_POST['apikey'];
		$listIds = $_POST['listids'];
		$api = new Mailchimp( $apiKey );
		$mergeVars = $api->lists->mergeVars( $listIds );
		echo json_encode( $mergeVars );
		exit();
	}

	/**
	 * Save MailChimp settings.
	 *
	 * @param   integer   $post_id   Post ID
	 */
	public function save_settings( $post_id ) {
		update_post_meta( $post_id, 'mailchimp_settings', $_POST['wr-cf-mailchimp']['lists'] );
		$_POST['wr-cf-mailchimp']['lists'] = json_decode( get_post_meta( $post_id, 'mailchimp_settings', true ) );

		// Update MailChimp tags
		if ( $_POST['wr-cf-mailchimp']['apikey'] != '' ) {
			$api = new Mailchimp( $_POST['wr-cf-mailchimp']['apikey'] );
			for ( $i = 0; $i < sizeof( $_POST['wr-cf-mailchimp']['lists'] ); $i++ ) {
				for ( $j = 0; $j < sizeof( $_POST['wr-cf-mailchimp']['lists'][$i]->merge ); $j++ ) {
					if ( $_POST['wr-cf-mailchimp']['lists'][$i]->merge[$j]->other != '' ) {
						if ( $_POST['wr-cf-mailchimp']['lists'][$i]->merge[$j]->dest == '' ) {
							$id = $_POST['wr-cf-mailchimp']['lists'][$i]->listid;
							$tag = $_POST['wr-cf-mailchimp']['lists'][$i]->merge[$j]->other;
							$tag = str_replace( ' ', '', $tag );
							$tag = preg_replace( '/[^a-z0-9]/i', '', $tag );
							$tag = 'W' . strtoupper( $tag );
							if ( strlen( $tag ) > 10 ) {
								$tag = substr( $tag, 0, 10 );
							}
							$name = $_POST['wr-cf-mailchimp']['lists'][$i]->merge[$j]->other;
							$options = array(
								'field_type' => 'text',
								'req' => false,
								'public' => true
							);
							try {
								$api->lists->mergeVarAdd( $id, $tag, $name, $options );
								$_POST['wr-cf-mailchimp']['lists'][$i]->merge[$j]->dest = $tag;
							} catch( Exception $e ) {
							}
						} else {
							$id = $_POST['wr-cf-mailchimp']['lists'][$i]->listid;
							$tag = $_POST['wr-cf-mailchimp']['lists'][$i]->merge[$j]->dest;
							$options = array(
								'name' => $_POST['wr-cf-mailchimp']['lists'][$i]->merge[$j]->other,
								'req' => false,
								'public' => true
							);
							try {
								$api->lists->mergeVarUpdate( $id, $tag, $options );
							} catch( Exception $e ) {
							}
						}
					}
				}
			}
		}
		update_post_meta( $post_id, 'mailchimp_settings', addslashes( json_encode( $_POST['wr-cf-mailchimp'] ) ) );
	}

	/**
	 * Add subcriber to MailChimp lists.
	 *
	 * @param   array    $dataForms                Data form
	 * @param   integer  $postID                   Post ID
	 * @param   array    $post                     Post form
	 * @param   string   $submissionsData          Submission Data
	 * @param   string   $dataContentEmail         Data content Email
	 * @param   string   $nameFileByIndentifier    Get name Field by Indentifier
	 * @param   string   $requiredField            required field
	 * @param   string   $fileAttach               Email File Attach
	 */
	public function save_submission( $dataForms, $postID, $post, $submissionsData, $dataContentEmail, $nameFileByIndentifier, $requiredField, $fileAttach ) {
		global $wpdb;
		$mailchimpSettings = json_decode( get_post_meta( $postID, 'mailchimp_settings', true ) );

		if ( ( $mailchimpSettings->use == 'yes' ) && ( $mailchimpSettings->apikey != '' ) ) {
			$api = new Mailchimp( $mailchimpSettings->apikey );
			foreach ( $mailchimpSettings->lists as $list ) {
				if ( $list->enable == 'yes' ) {
					$mergeVars = array();
					foreach ( $list->merge as $mergeField ) {
						$fieldRow = $wpdb->get_row( "SELECT field_id FROM {$wpdb->prefix}wr_contactform_fields WHERE form_id = {$postID} AND field_identifier = '{$mergeField->src}'" );
						$srcFieldId = $fieldRow->field_id;
						foreach ( $submissionsData as $submissionData ) {
							if ( $srcFieldId == $submissionData['field_id'] ) {
								$mergeVars[$mergeField->dest] = apply_filters( 'wr_contactform_addon_mailchimp_submission_data_value', $submissionData['submission_data_value'], $submissionData['field_type'] );
							}
						}
					}
					try {
						$api->lists->subscribe( $list->listid, array( 'email' => $mergeVars['EMAIL'] ), $mergeVars, false, false, false, false );
					} catch ( Exception $e ) {
					}
				}
			}
		}
	}
	
	public function filter_submission_value( $value, $type ) {
		switch ( $type ) {
			case 'name':
				$data = json_decode( html_entity_decode( $value ) );
				$value = $data->title . ' ' . $data->first . ' ' . $data->suffix . ' ' . $data->last;
				break;
			case 'likert':
				$data = json_decode( $value );
				$settings = json_decode( stripslashes( $data->settings ) );
				if ( ! empty( $settings ) ) {
					$fieldContent = array();
					foreach ( $settings->rows as $row ) {
						$checkedValue = 'N/A';
						foreach ( $data->values as $key => $val ) {
							if ( $key == md5( $row->text ) || $key == $row->text ) {
								$checkedValue = $val;
							}
						}
						$fieldContent[] = $row->text . ':' . $checkedValue;
					}
					$value = implode( ';', $fieldContent );
				} else {
					$value = '';
				}
				break;
			case 'address':
				$data = json_decode( html_entity_decode( $value ) );
				if ( $data->street != '' ) {
					$value = $data->street;
				}
				if ( $data->line2 != '' ) {
					$value .= ', ' . $data->line2;
				}
				if ( $data->city != '' ) {
					$value .= ', ' . $data->city;
				}
				if ( $data->state != '' ) {
					$value .= ', ' . $data->state;
				}
				if ( $data->code != '' ) {
					$value .= ', ' . $data->code;
				}
				if ( $data->country != '' ) {
					$value .= ', ' . $data->country;
				}
				break;
			case 'list':
			case 'checkboxes':
				$data = json_decode( $value );
				$value = '';
				foreach ( $data as $item ) {
					$value .= $item . ';';
				}
				break;
		}
		return $value;
	}
}
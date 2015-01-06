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
 * Sample meta box.
 *
 * @package  wr_contactform_Plugin
 * @since    1.0.0
 */
class WR_Contactform_Form_Settings {

	/**
	 * Fields Form Design array.
	 *
	 * @var  array
	 */
	public static function wr_contactform_get_field() {

		$listField = array(
			'fields' => array(
				'form_style' => array(
					'type' => 'hidden',
					'name' => 'wr_contactform[form_style]',
				),
				'form_settings' => array(
					'type' => 'hidden',
					'name' => 'wr_contactform[form_settings]',
				),
				'form_type' => array(
					'type' => 'select',
					'name' => 'wr_contactform[form_type]',
					'attributes' => array(
						'id' => 'jform_form_type',
						'style' => 'width:130px',
						'class' => 'jsn-input-fluid',
					),
					'choices' => array( '1' => 'Single page', '2' => 'Multiple pages' )
				),
				'list_email_send_to' => array(
					'type' => 'hidden',
					'name' => 'wr_contactform[list_email_send_to]',
				),
				'list_email_send_to_submitter' => array(
					'type' => 'hidden',
					'name' => 'wr_contactform[list_email_send_to_submitter]',
				),
				'content_email_send_to' => array( 'type' => 'hidden', 'name' => 'wr_contactform[content_email_send_to]' ),
				'content_email_send_to_submitter' => array(
					'type' => 'hidden',
					'name' => 'wr_contactform[content_email_send_to_submitter]',
				),
				'form_post_action_data' => array( 'type' => 'hidden', 'name' => 'wr_contactform[form_post_action_data]' ),
				'action_save_submissions' => array(
					'type' => 'radio',
					'name' => 'wr_contactform[action_save_submissions]',
					'choices' => array( 'Yes' => 'Yes', 'No' => 'No' ),
					'default' => 'Yes',
				),
				'form_post_action' => array(
					'type' => 'select',
					'name' => 'wr_contactform[form_post_action]',
					'choices' => WR_Contactform_Helpers_Contactform::get_link_types(),
					'attributes' => array( 'id' => 'jform_form_post_action', 'class' => 'jsn-input-fluid' ),
				),
				'form_post_action_data' => array(
					'name' => __( 'Action Data', WR_CONTACTFORM_TEXTDOMAIN ),
					'id' => 'form_post_action_data',
					'type' => 'action-data',
					'items' => WR_Contactform_Helpers_Contactform::get_single_item_button_bar(),
				),
			)
		);
		$getListField = apply_filters( 'wr_contactform_list_field_settings_form', $listField );
		if ( ! empty( $getListField ) ) {
			$listField = $getListField;
		}
		return $listField;
	}

	/**
	 * Render custom meta box.
	 *
	 * @param   WP_Post  $post  The object for the current post/page.
	 *
	 * @return  void
	 */
	public static function print_form_settings_html( $post ) {
		$fieldsFormSettings = self::wr_contactform_get_field();
		if ( is_object( $post ) ) {
			foreach ( $fieldsFormSettings[ 'fields' ] AS $key => $value ) {
				// Get field data
				$value = get_post_meta( $post->ID, $key, true );
				if ( ! empty( $value ) ) {
					$fieldsFormSettings[ 'fields' ][ $key ][ 'value' ] = get_post_meta( $post->ID, $key, true );
				}
			}
		}
		// Init HTML form
		$form = WR_CF_Form::get_instance( 'wr_contactform_meta_box', $fieldsFormSettings );

		// Render HTML form
		$form->render( 'contactform-settings' );
	}

	/**
	 * Save custom meta box data.
	 *
	 * @param   integer  $post_id  Post id.
	 *
	 * @return  void
	 */
	public static function wr_contactform_save_form( $post_id ) {
		global $wpdb;
		do_action( 'wr_contactform_before_save_form_settings', $post_id );
		if ( empty( $_POST[ 'jform_form_id' ] ) ) {
			add_post_meta( $post_id, 'form_id', $post_id );
			$dataFormID = $post_id;
		}
		else {
			$postId = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE  meta_key='form_id' AND meta_value=%d", (int)$_POST[ 'jform_form_id' ] ) );
			if ( empty( $postId ) ) {
				add_post_meta( $_POST[ 'jform_form_id' ], 'form_id', $_POST[ 'jform_form_id' ] );
			}
			$dataFormID = (int)$_POST[ 'jform_form_id' ];
		}
		$fieldsFormSettings = self::wr_contactform_get_field();
		$globalStyle = array();
		$post = $_POST;
		if ( ! empty( $post[ 'form_style' ][ 'themes_style' ] ) ) {
			$themeStyle = array();
			$themes = array();
			foreach ( $post[ 'form_style' ][ 'themes_style' ] as $key => $value ) {
				if ( $key == 'light' || $key == 'dark' ) {
					$themeStyle[ $key ] = addslashes( stripslashes( $value ) );
					$themes[ ] = $key;
				}
				else {
					$globalStyle[ 'themes_style' ][ $key ] = addslashes( stripslashes( $value ) );
					$globalStyle[ 'themes' ][ ] = $key;
				}
			}

			$post[ 'form_style' ][ 'themes_style' ] = $themeStyle;
			$post[ 'form_style' ][ 'themes' ] = $themes;
		}
		if ( ( ! empty( $post[ 'form_style' ] ) ) && ( ! empty( $post[ 'form_style' ][ 'custom_css' ] ) ) ) {
			$post[ 'form_style' ][ 'custom_css' ] = str_ireplace( "\r", '\r', $post[ 'form_style' ][ 'custom_css' ] );
			$post[ 'form_style' ][ 'custom_css' ] = str_ireplace( "\n", '\n', $post[ 'form_style' ][ 'custom_css' ] );
		}
		$post[ 'wr_contactform' ][ 'form_style' ] = ! empty( $post[ 'form_style' ] ) ? json_encode( $post[ 'form_style' ] ) : '';
		$post[ 'wr_contactform' ][ 'form_settings' ] = ! empty( $post[ 'wr_contactform' ][ 'form_settings' ] ) ? addslashes( json_encode( $post[ 'wr_contactform' ][ 'form_settings' ] ) ) : '';

		$_POST[ 'wr_contactform' ][ 'form_post_action_data' ] = $_POST[ 'contactform_action_data' ];
		if ( ! empty( $_POST[ 'wr_contactform' ][ 'list_email_send_to' ] ) ) {
			if ( ( isset( $_COOKIE[ 'wr-cf-list_email_send_to' ] ) ) && ( $_COOKIE[ 'wr-cf-list_email_send_to' ] != "" ) )
				$_SESSION[ 'wr-cf-list_email_send_to' ] = $_COOKIE[ 'wr-cf-list_email_send_to' ] . ',' . $_POST[ 'wr_contactform' ][ 'list_email_send_to' ];
			else $_SESSION[ 'wr-cf-list_email_send_to' ] = $_POST[ 'wr_contactform' ][ 'list_email_send_to' ];
			$_POST[ 'wr_contactform' ][ 'list_email_send_to' ] = explode(",", $_POST[ 'wr_contactform' ][ 'list_email_send_to' ] );
		}
		if ( ! empty( $_POST[ 'wr_contactform' ][ 'content_email_send_to' ] ) ) {
			$_POST[ 'wr_contactform' ][ 'content_email_send_to' ] = (array)json_decode( stripslashes( $_POST[ 'wr_contactform' ][ 'content_email_send_to' ] ) );
		}
		if ( ! empty( $_POST[ 'wr_contactform' ][ 'content_email_send_to_submitter' ] ) ) {
			$_POST[ 'wr_contactform' ][ 'content_email_send_to_submitter' ] = (array)json_decode( stripslashes( $_POST[ 'wr_contactform' ][ 'content_email_send_to_submitter' ] ) );
		}

		$globalStyle = ! empty( $globalStyle ) ? json_encode( $globalStyle ) : '';
		$globalStyle = stripslashes( $globalStyle );
		if ( get_option( 'wr_contactform_style' ) !== false ) {
			// The option already exists, so we just update it.
			update_option( 'wr_contactform_style', $globalStyle );
		}
		else {
			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( 'wr_contactform_style', $globalStyle, $deprecated, $autoload );
		}

		self::get_data_field( $dataFormID );

		foreach ( $fieldsFormSettings[ 'fields' ] AS $key => $value ) {
			// Sanitize meta box data
			if ( in_array( $key, array( 'form_style', 'form_settings', 'form_type' ) ) ) {
				$data = is_array( $post[ 'wr_contactform' ][ $key ] ) ? $post[ 'wr_contactform' ][ $key ] : $post[ 'wr_contactform' ][ $key ];
			}
			else {
				$data = is_array( $_POST[ 'wr_contactform' ][ $key ] ) ? $_POST[ 'wr_contactform' ][ $key ] : sanitize_text_field(
					$_POST[ 'wr_contactform' ][ $key ]
				);
			}
			// Update meta field in database
			update_post_meta( $post_id, $key, $data );
		}
		
		// Add key for reCaptcha
		if ( ( isset( $_POST[ 'recaptcha_publickey' ] ) ) && ( !empty( $_POST[ 'recaptcha_publickey' ] ) ) && ( isset( $_POST[ 'recaptcha_privatekey' ] ) ) && ( isset( $_POST[ 'recaptcha_privatekey' ] ) ) ) {
			update_option( 'wr_contactform_recaptcha_public_key', $_POST[ 'recaptcha_publickey' ] );
			update_option( 'wr_contactform_recaptcha_private_key', $_POST[ 'recaptcha_privatekey' ] );
		}

		do_action( 'wr_contactform_after_save_form_settings', $post_id );
		return false;
	}

	/**
	 * Get data field create
	 *
	 * @param   type  $dataFormId      Form id
	 *
	 * @return void
	 */
	public static function get_data_field( $dataFormId ) {
		global $wpdb;
		$post = $_POST;
		$identify = array();
		$fieldSB = array();
		$formId = ! empty( $post[ 'jform_form_id' ] ) ? $post[ 'jform_form_id' ] : 0;
		$count = 0;
		$fieldIds = array();
		//get data form page

		$dataFormPages = $wpdb->get_results( $wpdb->prepare( "SELECT page_id FROM {$wpdb->prefix}wr_contactform_form_pages WHERE form_id = %d ORDER BY page_id ASC", $dataFormId ) );
		$listFormPages = array();
		if ( ! empty( $dataFormPages ) ) {
			foreach ( $dataFormPages as $FormPage ) {
				$listFormPages[ ] = $FormPage->page_id;
			}
		}
		if ( isset( $post[ 'name_page' ] ) ) {
			foreach ( $post[ 'name_page' ] as $value => $text ) {

				$dataField = array();
				$parsedFields = array();
				$formPages = '';
				$formFields = '';
				$pageContainer = '';
				$formFields = json_decode( $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $value ] );
				$pcontainer = $_SESSION[ 'form-design-' . $formId ][ 'form_container_page_' . $value ];
				$pageContainer = stripslashes( $pcontainer );
				$pageContainer = json_decode( $pageContainer );
				if ( ! empty( $formFields ) && is_array( $formFields ) ) {
					foreach ( $formFields as $index => $field ) {
						$count ++;
						$options = $field->options;
						if ( in_array( $field->identify, $identify ) ) {
							$field->identify = $field->identify . $count;
						}
						$identify[ ] = $field->identify;
						$field->identify = preg_replace( '/[^a-z0-9-._]/i', '', $field->identify );
						if ( ! $field_id = $wpdb->get_var( $wpdb->prepare( 'SELECT field_id FROM ' . $wpdb->prefix . 'wr_contactform_fields WHERE  field_id= %d', $field->id ) ) ) {
							$wpdb->insert(
								$wpdb->prefix . 'wr_contactform_fields', array(
									'form_id' => $dataFormId,
									'field_type' => $field->type,
									'field_identifier' => $field->identify,
									'field_title' => trim( $options->label ),
									'field_instructions' => isset( $options->instruction ) ? $options->instruction : null,
									'field_position' => $field->position,
									'field_ordering' => $index,
									'field_settings' => json_encode( $field )
								)
							);
							$field_id = $wpdb->insert_id;
						}
						else {
							$wpdb->update(
								$wpdb->prefix . 'wr_contactform_fields', array(
									'form_id' => $dataFormId,
									'field_type' => $field->type,
									'field_identifier' => $field->identify,
									'field_title' => trim( $options->label ),
									'field_instructions' => isset( $options->instruction ) ? $options->instruction : null,
									'field_position' => $field->position,
									'field_ordering' => $index,
									'field_settings' => json_encode( $field )
								), array( 'field_id' => $field->id )
							);
						}
						$fieldIds[ ] = $field_id;
						$fieldSB[ ] = 'sb_' . $field_id;
						$parsedFields[ ] = array(
							'id' => $field_id,
							'type' => $field->type,
							'position' => $field->position,
							'identify' => $field->identify,
							'label' => $field->title,
							'instruction' => $field->instructions,
							'options' => $field->options,
						);
					}
				}

				if ( in_array( $value, $listFormPages ) ) {
					$formPages[ 'page_id' ] = $value;
				}
				$formPages[ 'page_title' ] = $text;
				$formPages[ 'form_id' ] = $dataFormId;
				$formPages[ 'page_content' ] = isset( $parsedFields ) ? json_encode( $parsedFields ) : '';
				$formPages[ 'page_container' ] = isset( $pageContainer ) ? json_encode( $pageContainer ) : '';
				$formPages[ 'page_id' ]   = isset( $formPages[ 'page_id' ] ) ? $formPages[ 'page_id' ] : '';
				
				if ( ! $page_id = $wpdb->get_var( $wpdb->prepare( 'SELECT page_id FROM ' . $wpdb->prefix . 'wr_contactform_form_pages WHERE  page_id = %d', $formPages[ 'page_id' ] ) ) ) {
					$wpdb->insert( $wpdb->prefix . 'wr_contactform_form_pages', $formPages );

					$formPages[ 'page_id' ] = $wpdb->insert_id;
				}
				else {
					$wpdb->update( $wpdb->prefix . 'wr_contactform_form_pages', $formPages, array( 'page_id' => $page_id ) );
				}
				$pageId[ ] = $formPages[ 'page_id' ];
			}
		}
		if ( ! empty( $fieldIds ) ) {
			$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wr_contactform_fields WHERE form_id = %d AND field_id NOT IN (' . implode( ', ', $fieldIds ) . ')', $dataFormId ) );
		}
		else {
			$wpdb->delete( $wpdb->prefix . 'wr_contactform_fields', array( 'form_id' => $dataFormId ), array( '%d' ) );
		}
		if ( ! empty( $pageId ) ) {
			$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wr_contactform_form_pages WHERE form_id = %d AND page_id NOT IN (' . implode( ', ', $pageId ) . ')', $dataFormId ) );
		}
	}
}

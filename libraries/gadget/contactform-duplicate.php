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

class WR_CF_Gadget_Contactform_Duplicate extends WR_CF_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-duplicate';

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
		require_once( ABSPATH . 'wp-admin/includes/admin.php' );
		auth_redirect();
		if ( ! empty( $_GET[ 'form_id' ] ) ) {
			global $wpdb;
			$postId = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE  meta_key='form_id' AND meta_value=%d", (int)$_GET[ 'form_id' ] ) );
			if ( empty( $postId ) ) {
				$postId = (int)$_GET[ 'form_id' ];
			}
			self::duplicate( $postId );
		}
		exit();
	}

	/**
	 * Method to duplicate modules.
	 *
	 * @param   array  &$pks  An array of primary key IDs.
	 *
	 * @return  boolean  True if successful.
	 *
	 * @since   1.6
	 * @throws  Exception
	 */
	public function duplicate( $form_id ) {
		$dataForm = get_post( $form_id );
		if ( ! empty( $dataForm ) ) {
			global $wpdb;
			$dataForm->ID = '';
			$dataForm->post_title = $dataForm->post_title . ' ( Duplicate )';
			$post_id = wp_insert_post( $dataForm );
			$getPostMeta = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE  post_id=%d", (int)$form_id ) );
			foreach ( $getPostMeta as $postMeta ) {
				if ( $postMeta->meta_key == 'form_id' ) {
					add_post_meta( $post_id, $postMeta->meta_key, $post_id );
				}
				else {
					add_post_meta( $post_id, $postMeta->meta_key, addslashes( $postMeta->meta_value ) );
				}
			}

			// Fix bug duplicate value in postmeta table
			update_post_meta( $post_id, 'form_post_action_data', get_post_meta( $form_id, 'form_post_action_data', true ) );
			update_post_meta( $post_id, 'list_email_send_to', get_post_meta( $form_id, 'list_email_send_to', true ) );
			update_post_meta( $post_id, 'list_email_send_to_submitter', get_post_meta( $form_id, 'list_email_send_to_submitter', true ) );
			update_post_meta( $post_id, 'content_email_send_to', get_post_meta( $form_id, 'content_email_send_to', true ) );
			update_post_meta( $post_id, 'content_email_send_to_submitter', get_post_meta( $form_id, 'content_email_send_to_submitter', true ) );

			$getFormPages = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wr_contactform_form_pages WHERE  form_id=%d", (int)$form_id ) );

			foreach ( $getFormPages as $page ) {
				$fields = json_decode( $page->page_content );
				$formPages = array();
				$parsedFields = array();
				foreach ( $fields as $index => $item ) {
					$wpdb->insert(
						$wpdb->prefix . 'wr_contactform_fields', array(
							'form_id' => $post_id,
							'field_type' => $item->type,
							'field_identifier' => $item->identify,
							'field_title' => $item->label,
							'field_instructions' => isset( $item->instruction ) ? $item->instruction : null,
							'field_position' => $item->position,
							'field_ordering' => $index,
						), array( '%d', '%s', '%s', '%s', '%s', '%s' )
					);
					$fieldSettings = $item;
					$fieldSettings->id = $wpdb->insert_id;
					$wpdb->update( $wpdb->prefix . 'wr_contactform_fields', array( 'field_settings' => json_encode( $fieldSettings ) ), array( 'field_id' => $wpdb->insert_id ), array( '%s' ), array( '%d' ) );
					$parsedFields[ ] = $fieldSettings;
				}
				$formPages[ 'page_id' ] = 0;
				$formPages[ 'page_title' ] = $page->page_title;
				$formPages[ 'page_container' ] = $page->page_container;
				$formPages[ 'form_id' ] = $post_id;
				$formPages[ 'page_content' ] = isset( $parsedFields ) ? json_encode( $parsedFields ) : '';
				$wpdb->insert( $wpdb->prefix . 'wr_contactform_form_pages', $formPages );
			}
		}

		header( 'Location: ' . get_admin_url() . 'edit.php?post_type=wr_cf_post_type' );
	}
}

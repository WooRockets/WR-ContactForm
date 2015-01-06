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
class WR_Contactform_Submission_Detail {

	/**
	 * Render custom meta box.
	 *
	 * @param   WP_Post  $post  The object for the current post/page.
	 *
	 * @return  void
	 */
	public static function print_submission_detail_html( $post ) {
		$fieldsFormAction = self::wr_contactform_get_field();
		if ( is_object( $post ) ) {
			if ( ! empty( $fieldsFormAction[ 'fields' ] ) ) {
				foreach ( $fieldsFormAction[ 'fields' ] AS $key => $value ) {
					// Get field data
					$fieldsFormAction[ 'fields' ][ $key ][ 'value' ] = get_post_meta( $post->ID, $key, true );
				}
			}
		}
		// Init HTML form
		$form = WR_CF_Form::get_instance( 'wr_contactform_submission_detail', $fieldsFormAction );

		// Render HTML form
		$form->render( 'submission-detail' );
	}

	/**
	 * Save custom meta box data.
	 *
	 * @param   integer  $post_id  Post id.
	 *
	 * @return  void
	 */
	public static function wr_contactform_submission_save_form( $post_id ) {
		global $wpdb;
		if ( ! empty( $_POST[ 'submission' ] ) ) {
			foreach ( $_POST[ 'submission' ] as $id => $value ) {
				if ( is_array( $value ) && ! empty( $value[ 'likert' ] ) ) {
					$data = array();
					foreach ( $value as $items ) {
						if ( isset( $items ) ) {
							foreach ( $items as $k => $item ) {
								$data[ $k ] = $item;
							}
						}
					}
					$value = $data ? json_encode( $data ) : '';
				}
				else {
					$value = str_replace( "\n", '</br>', $value );
				}

				$wpdb->update(
					$wpdb->prefix . 'wr_contactform_submission_data', array( 'submission_data_value' => stripslashes( $value ) ), array(
						'field_id' => $id,
						'submission_id' => $post_id,
					)
				);
			}
		}
		return false;
	}

	public static function wr_contactform_get_field() {
		return array();
	}
}

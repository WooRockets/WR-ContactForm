<?php
/**
 * @version    $Id$
 * @package    WR_Sample_Plugin
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 * Technical Support:  Feedback - http://www.innothemes.com/contact-us/get-support.html
 */

/**
 * Sample post type.
 *
 * @package  WR_Sample_Plugin
 * @since    1.0.0
 */
class WR_Contactform_Post_Type {

	/**
	 * Render a custom column in the listing page.
	 *
	 * @param   array  $column   Column name.
	 * @param   array  $post_id  Post id.
	 * @param   bool   $return   Return String
	 *
	 * @return  void
	 */
	public static function render_submissions_column( $column, $post_id, $return = false, $formID = '' ) {
		$html = '';
		global $wpdb;

		if ( in_array( $column, array( 'ip', 'browser', 'os' ) ) ) {
			if ( empty( $formID ) ) {
				$formID = ! empty( $_SESSION[ 'wr-contactform' ][ 'form_id' ] ) ? $_SESSION[ 'wr-contactform' ][ 'form_id' ] : '';
			}

			if ( ! empty( $formID ) && is_numeric( $formID ) ) {
				$submissionData = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT * FROM {$wpdb->prefix}wr_contactform_submission_data WHERE form_id = %d AND field_id = 0 AND submission_id=%d AND field_type=%s ORDER BY submission_data_id ASC", (int)$formID, (int)$post_id, $column
					)
				);
				$value = ! empty( $submissionData[ 0 ]->submission_data_value ) ? $submissionData[ 0 ]->submission_data_value : 'N/A';
				if ( $return ) {
					return $value;
				}
				else {
					_e( $value );
				}
			}
		}
		else if ( $column == 'total_submissions' ) {
			$meta = get_post_meta( (int)$post_id );
			if ( ! empty( $meta[ 'form_id' ][ 0 ] ) ) {
				$form_id = (int)$meta[ 'form_id' ][ 0 ];
			}
			else {
				$form_id = (int)$post_id;
			}
			$where = '';
			$total = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'publish' OR post_status = 'trash' OR post_status = 'draft' OR post_status = 'pending') AND (post_content = '" . (int)$form_id . "'  AND post_type = 'wr_cfsb_post_type' ) " . $where );
			return '<a href="edit.php?post_status=all&post_type=wr_cfsb_post_type&action=-1&m=0&paged=1&mode=list&action2=-1&wr_contactform_form_id=' . $form_id . '">' . $total . '</a>';
		}
		else if ( $column == 'form_short_code' ) {
			$meta = get_post_meta( (int)$post_id );
			if ( ! empty( $meta[ 'form_id' ][ 0 ] ) ) {
				$form_id = (int)$meta[ 'form_id' ][ 0 ];
			}
			else {
				$form_id = (int)$post_id;
			}
			return '[wr_contactform id=' . $form_id . ']';
		}
		else if ( $column == 'date_created' ) {
			$title = '<strong><a title="Edit Submission" href="post.php?post=' . (int)$post_id . '&amp;action=edit" class="row-title">' . get_the_date( 'm/d/Y H:i:s', (int)$post_id ) . '</a></strong>';
			return $title;
		}
		else {
			$column = str_replace( '_', '', $column );
			if ( empty( $formID ) ) {
				$formID = ! empty( $_SESSION[ 'wr-contactform' ][ 'form_id' ] ) ? $_SESSION[ 'wr-contactform' ][ 'form_id' ] : '';
			}
			if ( ! empty( $formID ) && is_numeric( $formID ) && ! empty( $column ) && is_numeric( $column ) ) {
				$submissionData = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT * FROM {$wpdb->prefix}wr_contactform_submission_data WHERE form_id = %d AND field_id = %d AND submission_id=%d ORDER BY submission_data_id ASC", (int)$formID, (int)$column, (int)$post_id
					)
				);
				if ( ! empty( $submissionData[ 0 ] ) ) {
					$getData = WR_Contactform_Helpers_Contactform::get_data_field( $submissionData[ 0 ]->field_type, $submissionData[ 0 ], '', $formID, true, true, 'list' );
					if ( $return ) {
						return $getData;
					}
					else {
						_e( $getData );
					}
				}
			}
		}

	}

	/**
	 * Render a custom column in the listing page.
	 *
	 * @param   array  $column   Column name.
	 * @param   array  $post_id  Post id.
	 *
	 * @return  void
	 */
	public static function render_form_column( $column, $post_id ) {
		$html = '';

		// Get data to show
		$value = get_post_meta( $post_id, $column, true );

		switch ( $column ) {
			case 'photo_uri':
				// Get info about upload directory
				$uploads = wp_upload_dir();

				// Generate path image and thumbnail
				$image = str_replace( $uploads[ 'baseurl' ], $uploads[ 'basedir' ], $value );
				$thumb = preg_replace( '/\.(jpe?g|png|gif|ico)$/i', '_128x128.\\1', $image );

				if ( ! is_file( $thumb ) ) {
					// Generate thumbnail image
					$editor = wp_get_image_editor( $image );

					if ( ! is_wp_error( $editor ) ) {
						$editor->resize( 128, 128, true );
						$editor->save( $thumb );
					}
				}

				// Generate img tag to present thumbnail
				$html = '<img src="' . str_replace( '\\', '/', str_replace( $uploads[ 'basedir' ], $uploads[ 'baseurl' ], $thumb ) ) . '" alt="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '" />';
				break;

			case 'date_taken':
			case 'taken_at':
				$html = $value;
				break;
		}

		_e( $html );
	}
}

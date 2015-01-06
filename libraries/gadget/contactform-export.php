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

class WR_CF_Gadget_Contactform_Export extends WR_CF_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-export';

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
		if ( ! empty( $_POST[ 'task' ] ) && $_POST[ 'task' ] == 'contactform.export' && ! empty( $_POST[ 'form_id' ] ) ) {
			self::task_export();
		}

		exit();
	}

	/**
	 * Export Submissions Data
	 *
	 * @return Html messages
	 */
	public function task_export() {
		// Check for request forgeries.
		global $wpdb;
		$data = array();
		set_time_limit( 999999999999 );
		$formId = ! empty( $_POST[ 'form_id' ] ) ? (int)$_POST[ 'form_id' ] : '';
		$fieldExport = ! empty( $_POST[ 'fieldExport' ] ) ? json_decode( stripslashes( $_POST[ 'fieldExport' ] ) ) : '';
		if ( $formId && $fieldExport ) {
			$listField = array();
			$fieldData = $wpdb->get_results(
				$wpdb->prepare(
					'SELECT * FROM ' . $wpdb->prefix . 'wr_contactform_fields WHERE form_id = %d', $formId
				)
			);
			$dateSubmission = ! empty( $_POST[ 'filter_date_submission' ] ) ? $_POST[ 'filter_date_submission' ] : '';
			$query = $wpdb->prepare( "SELECT id,post_date FROM {$wpdb->posts} WHERE post_content = %d AND post_type = 'wr_cfsb_post_type' ORDER BY id ASC", (int)$formId );
			if ( ! empty( $dateSubmission ) ) {
				$dateSubmission = @explode( ' - ', $dateSubmission );
				$dateStart = @explode( '/', $dateSubmission[ 0 ] );
				$dateStart = @$dateStart[ 2 ] . '-' . @$dateStart[ 0 ] . '-' . @$dateStart[ 1 ];
				if ( @$dateSubmission[ 1 ] ) {
					$dateEnd = @explode( '/', $dateSubmission[ 1 ] );
					$dateEnd = @$dateEnd[ 2 ] . '-' . @$dateEnd[ 0 ] . '-' . @$dateEnd[ 1 ];
					$query = $wpdb->prepare( "SELECT id,post_date FROM {$wpdb->posts} WHERE post_content = %d AND post_type = 'wr_cfsb_post_type' AND ( date(post_date) BETWEEN %s AND %s )  ORDER BY id ASC", (int)$formId, $dateStart, $dateEnd );
				}
				else {
					$query = $wpdb->prepare( "SELECT id,post_date FROM {$wpdb->posts} WHERE post_content = %d AND post_type = 'wr_cfsb_post_type' AND date(submission_created_at) = %s  ORDER BY id ASC", (int)$formId, $dateStart );
				}
			}
			$submissions = $wpdb->get_results( $query );
			$fieldOptions = array();
			foreach ( $fieldData as $f ) {
				$fieldOptions[ $f->field_id ] = $f->field_title;
			}
			foreach ( $fieldExport as $fx ) {
				if ( in_array( $fx, array( 'ip', 'browser', 'os', 'date_created' ) ) ) {
					switch ( $fx ) {
						case 'ip':
							$listField[ ] = 'IP Address';
							break;
						case 'browser':
							$listField[ ] = 'Browser';
							break;
						case 'os':
							$listField[ ] = 'Operating System';
							break;
						case 'date_created':
							$listField[ ] = 'Date Submited';
							break;
					}
				}
				else {
					$listField[ ] = $fieldOptions[ (int)str_replace( '_', '', $fx ) ];
				}
			}
			$data[ ] = $listField;

			foreach ( $submissions as $submission ) {
				$submissionData = array();
				foreach ( $fieldExport as $fx ) {
					if ( $fx == 'date_created' ) {
						$dateTime = new DateTime( $submission->post_date );
						$submissionData[ ] = $dateTime->format( 'm/d/Y H:i:s' );
					}
					else {
						$submissionData[ ] = WR_Contactform_Post_Type::render_submissions_column( $fx, $submission->id, true, $formId );
					}
				}
				$data[ ] = $submissionData;
			}
			if ( isset( $_POST[ 'exportType' ] ) && $_POST[ 'exportType' ] == 'excel' ) {
				include_once ( WR_CONTACTFORM_PATH . 'libraries/3rd-party/php-excel.class.php' );
				// generate file (constructor parameters are optional)
				$xls = new Excel_XML( 'UTF-8', false, 'My Test Sheet' );
				$xls->addArray( $data );
				$xls->generateXML( 'wr-contactform-' . $_POST[ 'form_title' ] . '-excel-' . date( 'Y-m-d' ) );
				exit();
			}
			else if ( isset( $_POST[ 'exportType' ] ) && $_POST[ 'exportType' ] == 'csv' ) {
				$fileName = 'wr-contactform-' . $_POST[ 'form_title' ] . '-csv-' . date( 'Y-m-d' );
				$fileName = preg_replace( '/[^aA-zZ0-9\_\-]/', '', $fileName );
				header( 'Content-type:text/octect-stream; charset=UTF-8' );
				header( 'Content-Disposition:attachment;filename=' . $fileName . '.csv' );
				$output = fopen( 'php://output', 'w' );
				foreach ( $data as $items ) {
					fputcsv( $output, $items );
				}
				fclose( $output );
				exit();
			}
		}

	}
}

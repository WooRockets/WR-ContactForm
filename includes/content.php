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
 * WR ContactForm form pro field Hook content submissions.
 *
 * @package  WR_ContactForm
 * @since    1.0.0
 */
class WR_Contactform_Includes_Content {

	public function __construct() {
		/* Add Filter wr_contactform_get_value_type_address*/
		add_filter(
			'wr_contactform_get_content_field_address', array(
				&$this,
				'filter_wr_contactform_get_content_field_address',
			), 10, 8
		);

		/* Add Filter wr_contactform_get_content_field_name*/
		add_filter(
			'wr_contactform_get_content_field_name', array(
				&$this,
				'filter_wr_contactform_get_content_field_name',
			), 10, 8
		);

		/* Add Filter wr_contactform_get_content_field_likert*/
		add_filter(
			'wr_contactform_get_content_field_likert', array(
				&$this,
				'filter_wr_contactform_get_content_field_likert',
			), 10, 8
		);

		/* Add Filter wr_contactform_get_content_field_file_upload*/
		add_filter(
			'wr_contactform_get_content_field_file_upload', array(
				&$this,
				'filter_wr_contactform_get_content_field_file_upload',
			), 10, 8
		);

		/* Add Filter wr_contactform_get_content_field_date*/
		add_filter(
			'wr_contactform_get_content_field_date', array(
				&$this,
				'filter_wr_contactform_get_content_field_date',
			), 10, 8
		);

	}

	/**
	 * check content field address
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
	 * @return String
	 */
	function filter_wr_contactform_get_content_field_address( $dataField, $fieldType, $submission, $key, $formId, $linkImg, $checkNull, $action ) {
		if ( ! empty( $dataField ) ) {
			$jsonAddress = json_decode( html_entity_decode( $dataField ) );

			if ( $jsonAddress ) {
				$nameStreet = ! empty( $jsonAddress->street ) ? htmlentities( $jsonAddress->street ) . ', ' : '';
				$nameLine2 = ! empty( $jsonAddress->line2 ) ? htmlentities( $jsonAddress->line2 ) . ', ' : '';
				$nameCity = ! empty( $jsonAddress->city ) ? htmlentities( $jsonAddress->city ) . ', ' : '';
				$nameCode = ! empty( $jsonAddress->code ) ? htmlentities( $jsonAddress->code ) . ' ' : '';
				$nameState = ! empty( $jsonAddress->state ) ? htmlentities( $jsonAddress->state ) . ' ' : '';
				$nameCountry = ! empty( $jsonAddress->country ) ? $jsonAddress->country . ' ' : '';
				$contentField = $nameStreet . $nameLine2 . $nameCity . $nameState . $nameCode . $nameCountry;
			}
			else {
				$contentField = $dataField;
			}
		}
		else {
			$contentField = '';
		}
		return $contentField;
	}

	/**
	 * check content field name
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
	 * @return String
	 */
	function filter_wr_contactform_get_content_field_name( $dataField, $fieldType, $submission, $key, $formId, $linkImg, $checkNull, $action ) {
		if ( ! empty( $dataField ) ) {
			$jsonName = json_decode( html_entity_decode( $dataField ) );
			if ( $jsonName ) {
				$nameTitle = isset( $jsonName->title ) ? $jsonName->title . ' ' : '';
				$nameFirst = isset( $jsonName->first ) ? htmlentities( $jsonName->first ) . ' ' : '';
				$nameLast = isset( $jsonName->last ) ? htmlentities( $jsonName->last ) : '';
				$nameSuffix = isset( $jsonName->suffix ) ? htmlentities( $jsonName->suffix ) . ' ' : '';
				if ( ! empty( $jsonName->first ) || ! empty( $jsonName->last ) || ! empty( $jsonName->suffix ) ) {
					$contentField = $nameTitle . $nameFirst . $nameSuffix . $nameLast;
				}
				else {
					$contentField = 'N/A';
				}
			}
			else {
				$contentField = $dataField;
			}
		}
		return $contentField;
	}

	/**
	 * check content field likert
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
	 * @return String
	 */
	function filter_wr_contactform_get_content_field_likert( $dataField, $fieldType, $submission, $key, $formId, $linkImg, $checkNull, $action ) {
		if ( ! empty( $dataField ) ) {
			$jsonName = json_decode( $dataField );
			if ( ! empty( $jsonName->settings ) ) {
				$settings = json_decode( stripslashes( $jsonName->settings ) );
				if ( ! empty( $jsonName ) ) {
					$contentField = array();
					if ( ! empty( $settings->rows ) ) {
						foreach ( $settings->rows as $set ) {
							$likertHtml = '';
							$likertHtml .= '<strong>' . $set->text . ':</strong>';
							$value = 'N/A';
							if ( ! empty( $jsonName->values ) ) {
								foreach ( $jsonName->values as $key => $val ) {
									if ( $key == md5( $set->text ) || $key == $set->text ) {
										$value = $val;
									}
								}
							}
							$likertHtml .= $value;
							$contentField[ ] = $likertHtml;
						}
					}

					$contentField = implode( '<br/>', $contentField );
				}
			}
			else {
				$contentField = '';
			}
		}
		else {
			$contentField = '';
		}
		return $contentField;
	}

	/**
	 * check content field file upload
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
	 * @return String
	 */
	function filter_wr_contactform_get_content_field_file_upload( $dataField, $fieldType, $submission, $key, $formId, $linkImg, $checkNull, $action ) {
		$jsonFile = json_decode( @$dataField );
		if ( ! empty( $jsonFile ) ) {
			if ( ! is_array( $jsonFile ) && is_object( $jsonFile ) ) {
				$tmpArray[ ] = $jsonFile;
				$jsonFile = $tmpArray;
			}
			$contentField = array();
			foreach ( $jsonFile as $file ) {
				$fileName = explode( '.', $file->name );
				if ( $action == 'export' ) {
					$contentField[ ] = isset( $file->name ) ? $file->link : 'N/A';
				}
				elseif ( $action == 'email' ) {
					$contentField[ ] = isset( $file->name ) ? '<a href="' . $file->link . '">' . $file->name . '</a>' : 'N/A';
				}
				elseif ( $action == 'fileAttach' ) {
					$contentField[ ] = isset( $file->name ) ? $file->file : '';
				}
				else {
					if ( in_array(
						strtolower( array_pop( $fileName ) ), array(
							'jpg',
							'gif',
							'jpeg',
							'png',
						)
					)
					) {
						if ( $linkImg ) {
							$contentField[ ] = isset( $file->name ) ? '<img src="' . $file->link . '" />' : 'N/A';
						}
						else {
							$contentField[ ] = isset( $file->name ) ? '<a href="' . $file->link . '" class="thumbnail" target="_blank"><img src="' . $file->link . '"/></a>' : 'N/A';
						}
					}
					else {
						if ( $action == 'list' ) {
							$contentField[ ] = isset( $file->name ) ? $file->name : 'N/A';
						}
						else {
							$contentField[ ] = isset( $file->name ) ? '<a href="' . $file->link . '">' . $file->name . '</a>' : 'N/A';
						}
					}
				}
			}
			if ( ! empty( $contentField ) ) {
				if ( $action != 'fileAttach' ) {
					$contentField = implode( '</br>', $contentField );
				}
			}
			return $contentField;
		}
	}

	/**
	 * check content field date
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
	 * @return String
	 */
	function filter_wr_contactform_get_content_field_date( $dataField, $fieldType, $submission, $key, $formId, $linkImg, $checkNull, $action ) {
		/*
		$checkdate = @explode( ' ', @$dataField );
		$checkdate = @explode( '-', @$checkdate[ 0 ] );
		if ( @$checkdate[ 0 ] != '0000' && @$checkdate[ 1 ] != '00' && @$checkdate[ 2 ] != '00' ) {
			$dateTime = new DateTime( @$dataField );
			$contentField = $dateTime->format( 'j F Y' );
		}
		*/
		return $dataField;
	}
}

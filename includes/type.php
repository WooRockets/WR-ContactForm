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
 * WR ContactForm form pro field type.
 *
 * @package  WR_ContactForm
 * @since    1.0.0
 */
class WR_Contactform_Includes_Type {

	public function __construct() {
		/* Add Filter get value field address */
		add_filter(
			'wr_contactform_get_value_type_address', array(
				&$this,
				'filter_wr_contactform_get_value_type_address',
			), 10, 4
		);

		/* Add Filter get value field name */
		add_filter( 'wr_contactform_get_value_type_name', array( &$this, 'filter_wr_contactform_get_value_type_name' ), 10, 4 );

		/* Add Filter get value field likert */
		add_filter(
			'wr_contactform_get_value_type_likert', array(
				&$this,
				'filter_wr_contactform_get_value_type_likert',
			), 10, 4
		);

		/* Add Filter get value field file upload */
		add_filter(
			'wr_contactform_get_value_type_file_upload', array(
				&$this,
				'filter_wr_contactform_get_value_type_file_upload',
			), 10, 4
		);

		/* Add Filter get value field email */
		add_filter(
			'wr_contactform_get_value_type_email', array(
				&$this,
				'filter_wr_contactform_get_value_type_email',
			), 10, 4
		);

		/* Add Filter get value field number */
		add_filter(
			'wr_contactform_get_value_type_number', array(
				&$this,
				'filter_wr_contactform_get_value_type_number',
			), 10, 4
		);

		/* Add Filter get value field date */
		add_filter( 'wr_contactform_get_value_type_date', array( &$this, 'filter_wr_contactform_get_value_type_date' ), 10, 4 );

		/* Add Filter get value field phone */
		add_filter(
			'wr_contactform_get_value_type_phone', array(
				&$this,
				'filter_wr_contactform_get_value_type_phone',
			), 10, 4
		);

		/* Add Filter get value field currency */
		add_filter(
			'wr_contactform_get_value_type_currency', array(
				&$this,
				'filter_wr_contactform_get_value_type_currency',
			), 10, 4
		);

		/* Add Filter get value field password */
		add_filter(
			'wr_contactform_get_value_type_password', array(
				&$this,
				'filter_wr_contactform_get_value_type_password',
			), 10, 4
		);

		/* Add Filter get value field website */
		add_filter(
			'wr_contactform_get_value_type_website', array(
				&$this,
				'filter_wr_contactform_get_value_type_website',
			), 10, 4
		);

	}

	/**
	 * get value file field website
	 */
	function filter_wr_contactform_get_value_type_website( $post, $fieldIdentifier, $colum, $fieldSettings ) {
		$postFieldName = isset( $post[ $fieldIdentifier ] ) ? $post[ $fieldIdentifier ] : '';
		$postName = stripslashes( $postFieldName );
		return $postName ? $postName : '';
	}

	/**
	 * get value file field address
	 */
	function filter_wr_contactform_get_value_type_address( $post, $fieldIdentifier, $colum, $fieldSettings ) {
		$value = WR_CF_Gadget_Contactform_Frontend::field_json( $post, $colum->field_type, $fieldIdentifier );
		return $value;
	}

	/**
	 * get value file field name
	 */
	function filter_wr_contactform_get_value_type_name( $post, $fieldIdentifier, $colum, $fieldSettings ) {
		$value = WR_CF_Gadget_Contactform_Frontend::field_json( $post, $colum->field_type, $fieldIdentifier );
		return $value;
	}

	/**
	 * get value file field likert
	 */
	function filter_wr_contactform_get_value_type_likert( $post, $fieldIdentifier, $colum, $fieldSettings ) {
		$value = WR_CF_Gadget_Contactform_Frontend::field_json( $post, $colum->field_type, $fieldIdentifier );
		return $value;
	}

	/**
	 * Setting field upload and validation field field upload
	 *
	 * @param   Array   $post                   Post form
	 * @param   String  $fieldIdentifier        Field indentifier
	 * @param   Array   $colum                  Column settings
	 * @param   Array   $fieldSettings          Field Settings
	 *
	 * @return void
	 */
	function filter_wr_contactform_get_value_type_file_upload( $post, $fieldIdentifier, $colum, $fieldSettings ) {
		if ( ! empty( $_FILES[ $fieldIdentifier ] ) && count( $_FILES[ $fieldIdentifier ] ) > 0 ) {
			$data = array();
			$validationForm = array();

			foreach ( $_FILES[ $fieldIdentifier ][ 'name' ] as $index => $fileName ) {
				$file = array();
				$file[ 'name' ] = $_FILES[ $fieldIdentifier ][ 'name' ][ $index ];
				$file[ 'type' ] = $_FILES[ $fieldIdentifier ][ 'type' ][ $index ];
				$file[ 'tmp_name' ] = $_FILES[ $fieldIdentifier ][ 'tmp_name' ][ $index ];
				$file[ 'error' ] = $_FILES[ $fieldIdentifier ][ 'error' ][ $index ];
				$file[ 'size' ] = $_FILES[ $fieldIdentifier ][ 'size' ][ $index ];
				$file[ 'name' ] = preg_replace(
					array(
						'#(\.){2,}#',
						'#[^A-Za-z0-9\.\_\- ]#',
						'#^\.#',
					), '', $file[ 'name' ]
				);
				if ( ! empty( $file[ 'name' ] ) ) {
					$err = null;

					if ( WR_Contactform_Includes_Upload::can_upload( $file, $err, $fieldSettings ) ) {
						if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
						$_POST[ 'action' ] = 'wp_handle_upload';
						define( 'UPLOADS_CONTACFORM', 'wp-content/uploads/wr_contactform' );
						$movefile = wp_handle_upload( $file, false );
						if ( ! $movefile ) {
							$validationForm[ $fieldIdentifier ] = __( 'Unable to upload file.', WR_CONTACTFORM_TEXTDOMAIN );
							return $validationForm;
						}
						else {
							$data[ ] = array(
								'name' => $file[ 'name' ],
								'link' => $movefile[ 'url' ],
								'file' => $movefile[ 'file' ],
							);
						}
					}
					else {
						$validationForm[ $fieldIdentifier ] = $err;
						return $validationForm;
					}
				}
			}
			if ( ! empty( $data ) ) {
				return json_encode( $data );
			}
		}
	}

	/**
	 *  Setting field type Email and check validaion field type email
	 *
	 * @param   Array   $post                   Post form
	 * @param   String  $fieldIdentifier        Field indentifier
	 * @param   Array   $colum                  Column settings
	 * @param   Array   $fieldSettings          Field Settings
	 *
	 * @return array
	 */
	function filter_wr_contactform_get_value_type_email( $post, $fieldIdentifier, $colum, $fieldSettings ) {
		$validationForm = array();
		$postFieldIdentifier = isset( $post[ $fieldIdentifier ] ) ? $post[ $fieldIdentifier ] : '';
		$postFieldIdentifier = stripslashes( $postFieldIdentifier );
		$postEmail = $postFieldIdentifier;
		if ( $postEmail ) {
			$regex = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,6})$/';
			if ( ! preg_match( $regex, $postEmail ) ) {
				$error = __( 'WR_CONTACTFORM_FIELD_EMAIL', WR_CONTACTFORM_TEXTDOMAIN );
				$validationForm[ $fieldIdentifier ] = str_replace( '%s', $colum->field_title, $error );
				return $validationForm;
			}
			else {
				return $postFieldIdentifier ? $postFieldIdentifier : '';
			}
		}
		else {
			return $postFieldIdentifier ? $postFieldIdentifier : '';
		}
	}

	/**
	 * Setting filed type Number and check validation filed type Number
	 *
	 * @param   Array   $post                   Post form
	 * @param   String  $fieldIdentifier        Field indentifier
	 * @param   Array   $colum                  Column settings
	 * @param   Array   $fieldSettings          Field Settings
	 *
	 * @return void
	 */
	function filter_wr_contactform_get_value_type_number( $post, $fieldIdentifier, $colum, $fieldSettings ) {
		$valueNumber = array();
		if ( ! empty( $post[ 'number' ][ $fieldIdentifier ] ) && ! is_array( $post[ 'number' ][ $fieldIdentifier ] ) ) {
			$valueNumber[ ] = $post[ 'number' ][ $fieldIdentifier ];
		}
		if ( ! empty( $post[ 'number' ][ $fieldIdentifier ][ 'value' ] ) ) {
			$valueNumber[ ] = $post[ 'number' ][ $fieldIdentifier ][ 'value' ];
		}
		if ( ! empty( $post[ 'number' ][ $fieldIdentifier ][ 'decimal' ] ) ) {
			$valueNumber[ ] = $post[ 'number' ][ $fieldIdentifier ][ 'decimal' ];
		}
		if ( $valueNumber ) {
			return implode( '.', $valueNumber );
		}

	}

	/**
	 * Setting filed type Date
	 *
	 * @param   Array   $post                   Post form
	 * @param   String  $fieldIdentifier        Field indentifier
	 * @param   Array   $colum                  Column settings
	 * @param   Array   $fieldSettings          Field Settings
	 *
	 * @return void
	 */
	function filter_wr_contactform_get_value_type_date( $post, $fieldIdentifier, $colum, $fieldSettings ) {
		$valueDate = array();
		if ( ! empty( $post[ 'date' ][ $fieldIdentifier ][ 'date' ] ) ) {
			$valueDate[ ] = $post[ 'date' ][ $fieldIdentifier ][ 'date' ];
		}
		if ( ! empty( $post[ 'date' ][ $fieldIdentifier ][ 'daterange' ] ) ) {
			$valueDate[ ] = $post[ 'date' ][ $fieldIdentifier ][ 'daterange' ];
		}
		if ( $valueDate ) {
			return implode( ' - ', $valueDate );
		}
	}

	/**
	 * Setting filed type Phone
	 *
	 * @param   Array   $post                   Post form
	 * @param   String  $fieldIdentifier        Field indentifier
	 * @param   Array   $colum                  Column settings
	 * @param   Array   $fieldSettings          Field Settings
	 *
	 * @return void
	 */
	function filter_wr_contactform_get_value_type_phone( $post, $fieldIdentifier, $colum, $fieldSettings ) {
		$valuePhone = array();
		if ( ! empty( $post[ 'phone' ][ $fieldIdentifier ][ 'default' ] ) ) {
			$valuePhone[ ] = $post[ 'phone' ][ $fieldIdentifier ][ 'default' ];
		}
		if ( ! empty( $post[ 'phone' ][ $fieldIdentifier ][ 'one' ] ) ) {
			$valuePhone[ ] = $post[ 'phone' ][ $fieldIdentifier ][ 'one' ];
		}
		if ( ! empty( $post[ 'phone' ][ $fieldIdentifier ][ 'two' ] ) ) {
			$valuePhone[ ] = $post[ 'phone' ][ $fieldIdentifier ][ 'two' ];
		}
		if ( ! empty( $post[ 'phone' ][ $fieldIdentifier ][ 'three' ] ) ) {
			$valuePhone[ ] = $post[ 'phone' ][ $fieldIdentifier ][ 'three' ];
		}
		if ( $valuePhone ) {
			return implode( ' - ', $valuePhone );
		}
		else {
			return '';
		}
	}

	/**
	 * Setting filed type Currency
	 *
	 * @param   Array   $post                   Post form
	 * @param   String  $fieldIdentifier        Field indentifier
	 * @param   Array   $colum                  Column settings
	 * @param   Array   $fieldSettings          Field Settings
	 *
	 * @return void
	 */
	function filter_wr_contactform_get_value_type_currency( $post, $fieldIdentifier, $colum, $fieldSettings ) {
		$valueCurrency = array();
		if ( ! empty( $post[ 'currency' ][ $fieldIdentifier ][ 'value' ] ) ) {
			$valueCurrency[ ] = $post[ 'currency' ][ $fieldIdentifier ][ 'value' ];
		}
		if ( ! empty( $post[ 'currency' ][ $fieldIdentifier ][ 'cents' ] ) ) {
			$valueCurrency[ ] = $post[ 'currency' ][ $fieldIdentifier ][ 'cents' ];
		}

		if ( $valueCurrency ) {
			return implode( ',', $valueCurrency );
		}
	}


	/**
	 * Setting filed type Password
	 *
	 * @param   Array   $post                   Post form
	 * @param   String  $fieldIdentifier        Field indentifier
	 * @param   Array   $colum                  Column settings
	 * @param   Array   $fieldSettings          Field Settings
	 *
	 * @return void
	 */
	function filter_wr_contactform_get_value_type_password( $post, $fieldIdentifier, $colum, $fieldSettings ) {
		$value = '';
		$validationForm = array();
		if ( count( $post[ 'password' ][ $fieldIdentifier ] ) > 1 ) {
			if ( $post[ 'password' ][ $fieldIdentifier ][ 0 ] == $post[ 'password' ][ $fieldIdentifier ][ 1 ] ) {
				$value = ! empty( $post[ 'password' ][ $fieldIdentifier ][ 0 ] ) ? $post[ 'password' ][ $fieldIdentifier ][ 0 ] : '';
			}
			else {
				$validationForm[ 'password' ][ $fieldIdentifier ] = __( 'Both password must be the same.', WR_CONTACTFORM_TEXTDOMAIN );
				return $validationForm;
			}
		}
		else {
			$value = ! empty( $post[ 'password' ][ $fieldIdentifier ][ 0 ] ) ? $post[ 'password' ][ $fieldIdentifier ][ 0 ] : '';
		}
		if ( ! empty( $value ) ) {
			if ( ! empty( $fieldSettings->options->encrypt ) && $fieldSettings->options->encrypt == 'md5' ) {
				$value = md5( $value );
			}
			else if ( ! empty( $fieldSettings->options->encrypt ) && $fieldSettings->options->encrypt == 'sha1' ) {
				$value = sha1( $value );
			}
		}
		return $value;
	}
}
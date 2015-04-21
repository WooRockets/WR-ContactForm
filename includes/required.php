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
 * WR ContactForm form pro field hook check required field.
 *
 * @package  WR_ContactForm
 * @since    1.0.0
 */
class WR_Contactform_Includes_Required {

	public function __construct() {
		/* Add Filter wr_contactform_get_value_type_address*/
		add_filter(
			'wr_contactform_filter_required_type_address', array(
				&$this,
				'filter_wr_contactform_filter_required_type_address',
			), 10, 5
		);

		/* Add Filter wr_contactform_filter_required_type_name*/
		add_filter(
			'wr_contactform_filter_required_type_name', array(
				&$this,
				'filter_wr_contactform_filter_required_type_name',
			), 10, 5
		);

		/* Add Filter wr_contactform_filter_required_type_likert*/
		add_filter(
			'wr_contactform_filter_required_type_likert', array(
				&$this,
				'filter_wr_contactform_filter_required_type_likert',
			), 10, 5
		);

		/* Add Filter wr_contactform_filter_required_type_file_upload*/
		add_filter(
			'wr_contactform_filter_required_type_file_upload', array(
				&$this,
				'filter_wr_contactform_filter_required_type_file_upload',
			), 10, 5
		);

		/* Add Filter wr_contactform_filter_required_type_email*/
		add_filter(
			'wr_contactform_filter_required_type_email', array(
				&$this,
				'filter_wr_contactform_filter_required_type_email',
			), 10, 5
		);

		/* Add Filter wr_contactform_filter_required_type_number*/
		add_filter(
			'wr_contactform_filter_required_type_number', array(
				&$this,
				'filter_wr_contactform_filter_required_type_number',
			), 10, 5
		);

		/* Add Filter wr_contactform_filter_required_type_date*/
		add_filter(
			'wr_contactform_filter_required_type_date', array(
				&$this,
				'filter_wr_contactform_filter_required_type_date',
			), 10, 5
		);

		/* Add Filter wr_contactform_filter_required_type_phone*/
		add_filter(
			'wr_contactform_filter_required_type_phone', array(
				&$this,
				'filter_wr_contactform_filter_required_type_phone',
			), 10, 5
		);

		/* Add Filter wr_contactform_filter_required_type_currency*/
		add_filter(
			'wr_contactform_filter_required_type_currency', array(
				&$this,
				'filter_wr_contactform_filter_required_type_currency',
			), 10, 5
		);

		/* Add Filter wr_contactform_filter_required_type_password*/
		add_filter(
			'wr_contactform_filter_required_type_password', array(
				&$this,
				'filter_wr_contactform_filter_required_type_password',
			), 10, 5
		);

		/* Add Filter wr_contactform_filter_required_type_website*/
		add_filter(
			'wr_contactform_filter_required_type_website', array(
				&$this,
				'filter_wr_contactform_filter_required_type_website',
			), 10, 5
		);
	}

	/**
	 * check required field address
	 */
	function filter_wr_contactform_filter_required_type_address( $checkValidation, $post, $fieldName, $colum, $fieldSettings ) {
		$postAddress = $post[ 'address' ][ $fieldName ];
		$requiredForm = array();
		if ( $postAddress[ 'street' ] == '' && $postAddress[ 'line2' ] == '' && $postAddress[ 'city' ] == '' && $postAddress[ 'code' ] == '' && $postAddress[ 'state' ] == '' ) {
			$requiredForm[ 'address' ][ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
		}
		return $requiredForm;
	}

	/**
	 * check required field name
	 */
	function filter_wr_contactform_filter_required_type_name( $checkValidation, $post, $fieldName, $colum, $fieldSettings ) {
		$postFieldName = isset( $post[ 'name' ][ $fieldName ] ) ? $post[ 'name' ][ $fieldName ] : '';
		$requiredForm = array();
		if ( $postFieldName[ 'first' ] == '' && $postFieldName[ 'last' ] == '' && $postFieldName[ 'suffix' ] == '' ) {
			$requiredForm[ 'name' ][ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
		}
		return $requiredForm;
	}

	/**
	 * check required field webiste
	 */
	function filter_wr_contactform_filter_required_type_website( $checkValidation, $post, $fieldName, $colum, $fieldSettings ) {
		$postWebsite = isset( $post[ $fieldName ] ) ? $post[ $fieldName ] : '';
		$requiredForm = array();
		$regex = '/^((http|https|ftp):\/\/|www([0-9]{0,9})?\.)?([a-zA-Z0-9][a-zA-Z0-9_-]*(?:\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+):?(\d+)?\/?/i';
		if ( ! preg_match( $regex, $postWebsite ) ) {
			$requiredForm[ $fieldName ] = __( 'The information is invalid, please correct.', WR_CONTACTFORM_TEXTDOMAIN );
		}
		return $requiredForm;
	}

	/**
	 * check required field file upload
	 */
	function filter_wr_contactform_filter_required_type_file_upload( $checkValidation, $post, $fieldName, $colum, $fieldSettings ) {
		$requiredForm = array();
		if ( empty( $_FILES[ $fieldName ][ 'name' ] ) ) {
			$requiredForm[ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
		}
		return $requiredForm;
	}


	/**
	 * check required field email
	 */
	function filter_wr_contactform_filter_required_type_email( $checkValidation, $post, $fieldName, $colum, $fieldSettings ) {
		$postFieldEmail = isset( $post[ $fieldName ] ) ? $post[ $fieldName ] : '';
		$requiredForm = array();
		$postEmail = stripslashes( $postFieldEmail );
		$regex = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,6})$/';
		if ( ! preg_match( $regex, $postEmail ) ) {
			$requiredForm[ $fieldName ] = __( 'The information is invalid, please correct.', WR_CONTACTFORM_TEXTDOMAIN );
		}
		return $requiredForm;
	}

	/**
	 * check required field number
	 */
	function filter_wr_contactform_filter_required_type_number( $checkValidation, $post, $fieldName, $colum, $fieldSettings ) {
		$requiredForm = array();
		if ( $post[ 'number' ][ $fieldName ] == '' ) {
			$requiredForm[ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
		}
		else {
			$postNumber = $post[ 'number' ][ $fieldName ][ 'value' ];
			$postNumberDecimal = $post[ 'number' ][ $fieldName ][ 'decimal' ];

			$regex = '/^(-[0-9])?[0-9]*$/';
			$checkNumber = false;
			if ( $postNumber != '' ) {
				if ( preg_match( $regex, $postNumber ) ) {
					$checkNumber = true;
				}
			}
			if ( $postNumberDecimal != '' ) {
				if ( preg_match( $regex, $postNumberDecimal ) ) {
					$checkNumber = true;
				}
				else {
					$checkNumber = false;
				}
			}
			if ( ! $checkNumber ) {
				$requiredForm[ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
			}
		}
		return $requiredForm;
	}

	/**
	 * check required field date
	 */
	function filter_wr_contactform_filter_required_type_date( $checkValidation, $post, $fieldName, $colum, $fieldSettings ) {
		$requiredForm = array();
		if ( isset( $fieldSettings->options->enableRageSelection ) && $fieldSettings->options->enableRageSelection == '1' ) {
			if ( $post[ 'date' ][ $fieldName ][ 'date' ] == '' || $post[ 'date' ][ $fieldName ][ 'daterange' ] == '' ) {
				$requiredForm[ 'date' ][ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
			}
		}
		else {
			if ( $post[ 'date' ][ $fieldName ][ 'date' ] == '' ) {
				$requiredForm[ 'date' ][ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
			}
		}
		return $requiredForm;
	}

	/**
	 * check required field phone
	 */
	function filter_wr_contactform_filter_required_type_phone( $checkValidation, $post, $fieldName, $colum, $fieldSettings ) {
		$requiredForm = array();
		if ( isset( $fieldSettings->options->format ) && $fieldSettings->options->format == '3-field' ) {
			if ( $post[ 'phone' ][ $fieldName ][ 'one' ] == '' || $post[ 'phone' ][ $fieldName ][ 'two' ] == '' || $post[ 'phone' ][ $fieldName ][ 'three' ] == '' ) {
				$requiredForm[ 'phone' ][ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
			}
		}
		else {
			if ( $post[ 'phone' ][ $fieldName ][ 'default' ] == '' ) {
				$requiredForm[ 'phone' ][ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
			}
		}
		return $requiredForm;
	}

	/**
	 * check required field currency
	 */
	function filter_wr_contactform_filter_required_type_currency( $checkValidation, $post, $fieldName, $colum, $fieldSettings ) {
		$requiredForm = array();
		if ( $post[ 'currency' ][ $fieldName ][ 'value' ] == '' ) {
			$requiredForm[ 'currency' ][ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
		}
		return $requiredForm;
	}

	/**
	 * check required field password
	 */
	function filter_wr_contactform_filter_required_type_password( $checkValidation, $post, $fieldName, $colum, $fieldSettings ) {
		$requiredForm = array();
		if ( count( $post[ 'password' ][ $fieldName ] ) > 1 ) {
			if ( $post[ 'password' ][ $fieldName ][ 0 ] == '' || $post[ 'password' ][ $fieldName ][ 1 ] == '' ) {
				$requiredForm[ 'password' ][ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
			}
			else if ( $post[ 'password' ][ $fieldName ][ 0 ] != '' && $post[ 'password' ][ $fieldName ][ 1 ] != '' && $post[ 'password' ][ $fieldName ][ 0 ] != $post[ 'password' ][ $fieldName ][ 1 ] ) {
				$requiredForm[ 'password' ][ $fieldName ] = __( 'Both password must be the same.', WR_CONTACTFORM_TEXTDOMAIN );
			}
		}
		else {
			if ( $post[ 'password' ][ $fieldName ][ 0 ] == '' ) {
				$requiredForm[ 'password' ][ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
			}
		}
		return $requiredForm;
	}
}
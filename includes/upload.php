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
 * WR ContactForm form upload helper.
 *
 * @package  WR_ContactForm
 * @since    1.0.0
 */
class WR_Contactform_Includes_Upload {

	/**
	 * Upload Form
	 *
	 * @param   string  $file      POST File
	 *
	 * @param   string  &$err      Message Error
	 *
	 * @param   string  $settings  $Setting
	 *
	 * @return boolean
	 */
	public static function can_upload( $file, &$err, $settings ) {
		if ( empty( $file[ 'name' ] ) ) {
			$err = __( 'WR_CONTACTFORM_ERROR_WARNFILENAME', WR_CONTACTFORM_TEXTDOMAIN );
			return false;
		}
		if ( $file[ 'name' ] !== preg_replace(
			array(
				'#(\.){2,}#',
				'#[^A-Za-z0-9\.\_\- ]#',
				'#^\.#',
			), '', $file[ 'name' ]
		)
		) {
			$err = __( 'WR_CONTACTFORM_ERROR_WARNFILENAME', WR_CONTACTFORM_TEXTDOMAIN );
			return false;
		}
		$format = strtolower( substr( $file[ 'name' ], strrpos( $file[ 'name' ], '.' ) + 1 ) );
		$allowedExtensions = str_replace( ' ', '', $settings->options->allowedExtensions );
		$allowable = explode( ',', $allowedExtensions );
		switch ( $settings->options->maxSizeUnit ) {
			case 'KB':
				$uploadMaxSize = $settings->options->maxSize * 1024;
				break;
			case 'MB':
				$uploadMaxSize = $settings->options->maxSize * 1024 * 1024;
				break;
			case 'GB':
				$uploadMaxSize = $settings->options->maxSize * 1024 * 1024 * 1024;
				break;
		}

		if ( $uploadMaxSize > (int)( ini_get( 'upload_max_filesize' ) ) * 1024 * 1024 ) {

			if ( (int)$file[ 'size' ] == 0 && (int)$file[ 'error' ] == 1 && empty( $file[ 'tmp_name' ] ) ) {
				$err = __( 'WR_CONTACTFORM_POST_UPLOAD_SIZE', WR_CONTACTFORM_TEXTDOMAIN );
				$err = str_replace( '%s', (int)( ini_get( 'upload_max_filesize' ) ) . ' MB', $err );
				return false;
			}
		}

		if ( ! in_array( $format, $allowable ) || in_array(
			$format, array(
				'php',
				'phps',
				'php3',
				'php4',
				'phtml',
				'pl',
				'py',
				'jsp',
				'asp',
				'htm',
				'shtml',
				'sh',
				'cgi',
				'htaccess',
				'exe',
				'dll',
			)
		)
		) {
			$err = __( 'WR_CONTACTFORM_ERROR_WARNFILETYPE', WR_CONTACTFORM_TEXTDOMAIN );
			$err = str_replace( '%s', '.' . $format, $err );
			return false;
		}
		if ( (int)$file[ 'size' ] > $uploadMaxSize ) {
			$err = __( 'WR_CONTACTFORM_POST_UPLOAD_SIZE', WR_CONTACTFORM_TEXTDOMAIN );
			$err = str_replace( '%s', $settings->options->maxSize . ' ' . $settings->options->maxSizeUnit, $err );
			return false;
		}
		elseif ( (int)$file[ 'size' ] == 0 && (int)$file[ 'error' ] == 1 && empty( $file[ 'tmp_name' ] ) ) {
			$err = __( 'WR_CONTACTFORM_POST_UPLOAD_SIZE', WR_CONTACTFORM_TEXTDOMAIN );
			$err = str_replace( '%s', $settings->options->maxSize . ' ' . $settings->options->maxSizeUnit, $err );
			return false;
		}
		return true;
	}

}

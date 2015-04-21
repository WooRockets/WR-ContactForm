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

class WR_CF_Gadget_Contactform_Frontend extends WR_CF_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-frontend';

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
		if ( ! empty( $_GET[ 'task' ] ) && $_GET[ 'task' ] == 'form.save' && ! empty( $_GET[ 'form_id' ] ) ) {
			include_once ( WR_CONTACTFORM_PATH . 'frontend/helpers/browser.php' );
			load_plugin_textdomain( WR_CONTACTFORM_TEXTDOMAIN, false, WR_CONTACTFORM_TEXTDOMAIN . '/frontend/languages/' );
			self::task_save();
		}
		if ( ! empty( $_GET[ 'task' ] ) && $_GET[ 'task' ] == 'form.getHtmlForm' && ! empty( $_GET[ 'form_id' ] ) ) {
			self::get_html_form( (int)$_GET[ 'form_id' ] );
		}
		exit();
	}

	/**
	 * Save data submission
	 *
	 * @return Html messages
	 */
	public function task_save() {
		// Check for request forgeries.
		global $wpdb;

		if ( @$_SERVER[ 'CONTENT_LENGTH' ] < (int)( ini_get( 'post_max_size' ) ) * 1024 * 1024 ) {
			$return = new stdClass;
			$post = $_POST;
			$formID = (int)$_POST[ 'form_id' ];
			$postId = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='form_id' AND meta_value=%d", (int)$formID ) );
			if ( empty( $postId ) ) {
				$postId = $formID;
			}
			$status = get_post_status( $postId );
			if ( ! empty( $postId ) && $status && $status != 'pending' ) {
				$return = self::save( $post, $postId );

			}
			if ( isset( $return->error ) ) {
				echo '<input type="hidden" name="error" value=\'' . htmlentities( json_encode( $return->error ), ENT_QUOTES, 'UTF-8' ) . '\'/>';
				exit();
			}
			else {
				if ( isset( $return->actionForm ) && $return->actionForm == 'message' ) {
					echo '<input type="hidden" name="message" value=\'' . htmlentities( $return->actionFormData, ENT_QUOTES, 'UTF-8' ) . '\'/>';
					exit();
				}
				elseif ( isset( $return->actionForm ) && $return->actionForm == 'url' ) {
					echo '<input type="hidden" name="redirect" value=\'' . htmlentities( $return->actionFormData, ENT_QUOTES, 'UTF-8' ) . '\'/>';
					exit();
				}
				else {
					exit();
				}
			}
		}
		else {
			$postMaxSize = (int)ini_get( 'post_max_size' );
			if ( $postMaxSize > (int)( ini_get( 'upload_max_filesize' ) ) ) {
				$postMaxSize = (int)( ini_get( 'upload_max_filesize' ) );
			}
			echo '<input type="hidden" name="error" value=\'' . htmlentities( json_encode( array( 'max-upload' => __( 'The file you want to upload is too big. Please keep file size under %s MB', WR_CONTACTFORM_TEXTDOMAIN ) ) ), ENT_QUOTES, 'UTF-8' ) . '\'/>';
			exit();
		}
	}

	/**
	 * Get action form
	 *
	 * @param   String  $formAction  Form action
	 * @param   String  $formData    Action data
	 * @param   Array   &$return     Return messages
	 *
	 * @return  string
	 */
	private function get_action_form( $formAction, $formData, &$return ) {
		$term = ! empty( $formData[ $formAction ] ) ? $formData[ $formAction ] : '';
		switch ( $formAction ) {
			case 'contactform_url':
				$return->actionForm = 'url';
				$return->actionFormData = $term;
				break;
			case 'contactform_show_message':
				$return->actionForm = 'message';
				$return->actionFormData = $term;
				break;
			case 'post':
				$return->actionForm = 'url';
				$return->actionFormData = ! empty( $formData[ $formAction ] ) ? get_permalink( (int)$term ) : '';
				break;
			case 'page':
				$return->actionForm = 'url';
				$return->actionFormData = ! empty( $formData[ $formAction ] ) ? get_page_link( (int)$term ) : '';
				break;
			case 'contactform_no_action':
				break;
			default:
				$return->actionForm = 'url';
				$return->actionFormData = ! empty( $formData[ $formAction ] ) ? get_term_link( (int)$term, $formAction ) : '';
				break;
		}
		$getReturn = apply_filters( 'wr_contactform_frontend_get_action_form', $return );
		if ( ! empty( $getReturn ) ) {
			$getReturn = $return;
		}
	}

	/**
	 * Setting field type json
	 *
	 * @param   Array   $post             Post form
	 * @param   String  $fieldType        Field type
	 * @param   String  $fieldIdentifier  Field indentifier
	 *
	 * @return void
	 */
	public static function field_json( $post, $fieldType, $fieldIdentifier ) {
		$checkFieldJson = array();
		$checkFieldJson[ 'address' ] = 'address';
		$checkFieldJson[ 'name' ] = 'name';
		$checkFieldJson[ 'likert' ] = 'likert';
		$checkFieldJson = apply_filters( 'wr_contactform_frontend_check_field_json', $checkFieldJson );
		if ( in_array( $fieldType, $checkFieldJson ) ) {
			$postFieldIdentifier = isset( $post[ $fieldType ][ $fieldIdentifier ] ) ? $post[ $fieldType ][ $fieldIdentifier ] : '';
			$data = array();
			if ( ! empty( $postFieldIdentifier ) ) {
				foreach ( $postFieldIdentifier as $key => $item ) {
					if ( isset( $item ) ) {
						$data[ $key ] = $item;
					}
				}
			}
			return $data ? json_encode( $data ) : '';
		}
		else {
			$postFieldIdentifier = isset( $post[ $fieldIdentifier ] ) ? $post[ $fieldIdentifier ] : '';
			$data = array();
			if ( ! empty( $postFieldIdentifier ) ) {
				foreach ( $postFieldIdentifier as $key => $item ) {
					if ( isset( $item ) ) {
						$data[ $key ] = $item;
					}
				}
			}
			return $data ? json_encode( array_filter( $data, 'strlen' ) ) : '';
		}
	}

	/**
	 * Check field duplicates
	 *
	 * @param   Array   $post             Post form
	 * @param   String  $tableSubmission  Table submission
	 * @param   String  $fieldIdentifier  Field indentifier
	 * @param   String  $fieldTitle       Field Title
	 * @param   Array   &$validationForm  Validation form
	 *
	 * @return  array
	 */
	public static function check_duplicates( $post, $fieldIdentifier, $fieldTitle, &$validationForm ) {
		$formId = isset( $post[ 'form_id' ] ) ? $post[ 'form_id' ] : '0';
		$postFieldIdentifier = isset( $post[ $fieldIdentifier ] ) ? $post[ $fieldIdentifier ] : '';
		$postIndentifier = stripslashes( $postFieldIdentifier );
		if ( $postIndentifier ) {
			global $wpdb;
			$columsSubmission = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT submission_id FROM {$wpdb->prefix}wr_contactform_submission_data WHERE form_id = %d AND submission_data_value=%s", (int)$formId, $postIndentifier
				)
			);

			if ( $columsSubmission ) {
				$error = __( 'WR_CONTACTFORM_FIELD_EXISTING', WR_CONTACTFORM_TEXTDOMAIN );
				$validationForm[ $fieldIdentifier ] = str_replace( '%s', $fieldTitle, $error );
			}
		}
	}

	/**
	 * Check filed limit char
	 *
	 * @param   Array   $post             Post form
	 * @param   String  $fieldSettings    Field settings
	 * @param   String  $fieldIdentifier  Field indentifier
	 * @param   String  $fieldTitle       Field Title
	 * @param   Array   &$validationForm  Validation form
	 *
	 * @return  array
	 */
	public static function check_limit_char( $post, $fieldSettings, $fieldIdentifier, $fieldTitle, &$validationForm ) {
		if ( isset( $fieldSettings->type ) && $fieldSettings->type != 'password' ) {
			$postFieldIdentifier = isset( $post[ $fieldIdentifier ] ) ? $post[ $fieldIdentifier ] : '';
		}
		else {
			$postFieldIdentifier = isset( $post[ $fieldIdentifier ][ 0 ] ) ? $post[ $fieldIdentifier ][ 0 ] : '';
		}
		$postIndentifier = stripslashes( $postFieldIdentifier );
		if ( isset( $fieldSettings->options->limitType ) && $fieldSettings->options->limitType == 'Words' ) {
			$countValue = explode( ' ', preg_replace( '/\s+/', ' ', trim( $postIndentifier ) ) );

			if ( count( $countValue ) < $fieldSettings->options->limitMin ) {
				$validationForm[ $fieldIdentifier ] = __( 'The information cannot contain less than', WR_CONTACTFORM_TEXTDOMAIN ) . ' ' . $fieldSettings->options->limitMin . ' Words';
			}
			else if ( count( $countValue ) > $fieldSettings->options->limitMax ) {
				$validationForm[ $fieldIdentifier ] = __( 'The information cannot contain more than', WR_CONTACTFORM_TEXTDOMAIN ) . ' ' . $fieldSettings->options->limitMax . ' Words';
			}
		}
		else {
			if ( isset( $fieldSettings->type ) && $fieldSettings->type != 'password' ) {
				if ( strlen( $postIndentifier ) < $fieldSettings->options->limitMin ) {
					$validationForm[ $fieldIdentifier ] = __( 'The information cannot contain less than', WR_CONTACTFORM_TEXTDOMAIN ) . ' ' . $fieldSettings->options->limitMin . ' Character';
				}
				else if ( strlen( $postIndentifier ) > $fieldSettings->options->limitMax ) {
					$validationForm[ $fieldIdentifier ] = __( 'The information cannot contain more than', WR_CONTACTFORM_TEXTDOMAIN ) . ' ' . $fieldSettings->options->limitMax . ' Character';
				}
			}
			else {
				if ( strlen( $postIndentifier ) < $fieldSettings->options->limitMin ) {
					$validationForm[ 'password' ][ $fieldIdentifier ] = __( 'The information cannot contain less than', WR_CONTACTFORM_TEXTDOMAIN ) . ' ' . $fieldSettings->options->limitMin . ' Character';
				}
				else if ( strlen( $postIndentifier ) > $fieldSettings->options->limitMax ) {
					$validationForm[ 'password' ][ $fieldIdentifier ] = __( 'The information cannot contain more than', WR_CONTACTFORM_TEXTDOMAIN ) . ' ' . $fieldSettings->options->limitMax . ' Character';
				}
			}
		}
	}

	/**
	 * Settings filed type choices and check validadion filed type choicces
	 *
	 * @param   Array   $post             Post form
	 * @param   String  $fieldSettings    Field settings
	 * @param   String  $fieldIdentifier  Field indentifier
	 *
	 * @return array
	 */
	public static function field_others( $post, $fieldSettings, $fieldIdentifier ) {
		if ( isset( $fieldSettings->options->allowOther ) && $fieldSettings->options->allowOther == 1 && isset( $post[ $fieldIdentifier ] ) && $post[ $fieldIdentifier ] == 'Others' ) {

			return isset( $post[ 'fieldOthers' ][ $fieldIdentifier ] ) ? $post[ 'fieldOthers' ][ $fieldIdentifier ] : '';
		}
		else {
			return isset( $post[ $fieldIdentifier ] ) ? $post[ $fieldIdentifier ] : '';

		}
	}

	/**
	 * Save form submission
	 *
	 * @param   Array  $post    Post form
	 * @param   int    $postID  Post ID
	 *
	 * @return  Messages
	 */
	public function save( $post, $postID ) {

		global $wpdb;
		$return = new stdClass;
		$submissionsData = array();
		$validationForm = array();
		$requiredField = array();
		$postFormId = isset( $post[ 'form_id' ] ) ? $post[ 'form_id' ] : '';
		$dataForms = get_post_meta( (int)$postID );
		$formSettings = ! empty( $dataForms[ 'form_settings' ][ 0 ] ) ? json_decode( $dataForms[ 'form_settings' ][ 0 ] ) : '';

		if ( empty( $formSettings ) ) {
			return;
		}
		$dataForms[ 'form_id' ] = (int)$postFormId;
		$dataContentEmail = '';
		$fileAttach = '';
		$nameFileByIndentifier = '';

		$global_captcha_setting = get_option( 'wr_contactform_global_captcha_setting', 2 );
		if ( $global_captcha_setting != 0 ) {
			if ( ! empty( $formSettings->form_captcha ) && $formSettings->form_captcha == 1 && isset( $_POST[ 'recaptcha_challenge_field' ] ) ) {
				include_once ( WR_CONTACTFORM_PATH . 'libraries/3rd-party/recaptchalib.php' );
				$recaptchaChallenge = isset( $_POST[ 'recaptcha_challenge_field' ] ) ? $_POST[ 'recaptcha_challenge_field' ] : '';
				$recaptchaResponse = isset( $_POST[ 'recaptcha_response_field' ] ) ? $_POST[ 'recaptcha_response_field' ] : '';

				$resp = recaptcha_check_answer( WR_CONTACTFORM_CAPTCHA_PRIVATEKEY, $_SERVER[ 'REMOTE_ADDR' ], $recaptchaChallenge, $recaptchaResponse );

				if ( ! $resp->is_valid ) {
					$return->error[ 'captcha' ] = __( 'Incorrect captcha text!', WR_CONTACTFORM_TEXTDOMAIN );

					return $return;
				}
			}
			else if ( ( ! empty( $formSettings->form_captcha ) && $formSettings->form_captcha == 2 ) || $global_captcha_setting == 1 ) {
				if ( ! empty( $_POST[ 'form_name' ] ) && ! empty( $_POST[ 'captcha' ] ) ) {
					$sCaptcha = $_SESSION[ 'securimage_code_value' ][ $_POST[ 'form_name' ] ] ? $_SESSION[ 'securimage_code_value' ][ $_POST[ 'form_name' ] ] : '';
					if ( strtolower( $sCaptcha ) != strtolower( $_POST[ 'captcha' ] ) ) {
						$return->error[ 'captcha_2' ] = __( 'Incorrect captcha text!', WR_CONTACTFORM_TEXTDOMAIN );
						return $return;
					}
				}
				else {
					$return->error[ 'captcha_2' ] = __( 'Incorrect captcha text!', WR_CONTACTFORM_TEXTDOMAIN );
					return $return;
				}
			}
		}
		$columsSubmission = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}wr_contactform_fields WHERE form_id = %d ORDER BY field_ordering ASC", (int)$postFormId
			)
		);

		$fieldClear = array();
		if ( isset( $dataForms->form_type ) && $dataForms->form_type == 1 ) {
			$dataPages = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}wr_contactform_form_pages WHERE form_id = %d ORDER BY page_id ASC", (int)$dataForms[ 'form_id' ]
				)
			);
			foreach ( $dataPages as $index => $page ) {
				if ( $index > 0 ) {
					$contentPage = isset( $page->page_content ) ? json_decode( $page->page_content ) : '';
					foreach ( $contentPage as $item ) {
						$fieldClear[ ] = $item->id;
					}
				}
			}
		}

		$postAction = ! empty( $dataForms[ 'form_post_action' ][ 0 ] ) ? $dataForms[ 'form_post_action' ][ 0 ] : '';
		$postActionData = ! empty( $dataForms[ 'form_post_action_data' ][ 0 ] ) ? unserialize( $dataForms[ 'form_post_action_data' ][ 0 ] ) : '';
		self::get_action_form( $postAction, $postActionData, $return );
		$fieldEmail = array();
		$ip = getenv( 'REMOTE_ADDR' );
		$browser = new Browser;
		$submissionsData[ ] = array(
			'form_id' => $postFormId,
			'submission_data_value' => $browser->getPlatform(),
			'field_type' => 'os',
		);
		$submissionsData[ ] = array(
			'form_id' => $postFormId,
			'submission_data_value' => $browser->getBrowser(),
			'field_type' => 'browser',
		);
		$submissionsData[ ] = array(
			'form_id' => $postFormId,
			'submission_data_value' => $ip,
			'field_type' => 'ip',
		);
		foreach ( $columsSubmission as $colum ) {

			if ( ! in_array( $colum->field_id, $fieldClear ) ) {

				$fieldName = '';
				$fieldName = $colum->field_id;
				$fieldSettings = isset( $colum->field_settings ) ? json_decode( $colum->field_settings ) : '';

				$value = '';
				$fieldEmail[ $colum->field_id ] = $colum->field_identifier;
				$formTypeNotSave = array( 'static-content', 'google-maps' );
				$formTypeNotSave = apply_filters( 'wr_contactform_filter_form_type_not_save', $formTypeNotSave );

				if ( isset( $colum->field_type ) && ! in_array( $colum->field_type, $formTypeNotSave ) ) {
					if ( in_array(
						$colum->field_type, array(
							'single-line-text',
							'paragraph-text',
							'country',
						)
					)
					) {
						$postFieldName = isset( $post[ $fieldName ] ) ? $post[ $fieldName ] : '';
						$postName = stripslashes( $postFieldName );
						$value = $postName ? $postName : '';
					}
					elseif ( $colum->field_type == 'choices' || $colum->field_type == 'dropdown' ) {
						$value = self::field_others( $post, $fieldSettings, $fieldName );
					}
					elseif ( in_array( $colum->field_type, array( 'checkboxes', 'list' ) ) ) {
						$value = self::field_json( $post, $colum->field_type, $fieldName );
					}
					else {
						$getValue = '';
						$getValue = apply_filters( 'wr_contactform_get_value_type_' . str_replace( '-', '_', $colum->field_type ), $post, $fieldName, $colum, $fieldSettings );

						if ( is_array( $getValue ) ) {
							foreach ( $getValue as $idField => $text ) {
								$validationForm[ $idField ] = $text;
							}
						}
						else if ( is_string( $getValue ) ) {
							$value = $getValue;
						}
					}

					// htmlentities to form inputs
					if ( in_array( $colum->field_type,
							array(
								'single-line-text',
								'paragraph-text',
								'address',
								'name',
								'password'
							)
						) ) {
						$value = htmlentities( $value );
					}

					$submissionsData[ ] = array(
						'form_id' => $postFormId,
						'field_id' => $colum->field_id,
						'submission_data_value' => $value,
						'field_type' => $colum->field_type,
					);
					$keyField = $colum->field_id;
					$submissions = new stdClass();
					$submissions->$keyField = $value;

					if ( isset( $colum->field_type ) ) {
						$nameFileByIndentifier[ $colum->field_identifier ] = $colum->field_title;
						$contentField = WR_Contactform_Helpers_Contactform::get_data_field( $colum->field_type, $submissions, $colum->field_id, $postFormId, false, false, 'email' );
						if ( $colum->field_type == 'file-upload' ) {
							$fileAttach[ $colum->field_identifier ] = WR_Contactform_Helpers_Contactform::get_data_field( $colum->field_type, $submissions, $colum->field_id, $postFormId, false, false, 'fileAttach' );
						}
						/* Create Filter get file attachment*/
						$fileAttach = apply_filters( 'wr_contactform_frontend_file_attachment_email', $fileAttach, $colum, $submissions, $postFormId );
						$dataContentEmail[ $colum->field_identifier ] = $contentField ? str_replace( '\n', '<br/>', trim( $contentField ) ) : '<span>N/A</span>';
						$requiredField[ $colum->field_identifier ] = $fieldSettings->options->required;
					}
					if ( ! empty( $fieldSettings->options->noDuplicates ) && (int)$fieldSettings->options->noDuplicates == 1 ) {
						WR_CF_Gadget_Contactform_Frontend::check_duplicates( $post, $fieldName, $colum->field_title, $validationForm );
					}
					if ( isset( $fieldSettings->options->limitation ) && (int)$fieldSettings->options->limitation == 1 && ! empty( $post[ $fieldName ] ) ) {
						if ( $fieldSettings->options->limitMin <= $fieldSettings->options->limitMax && $fieldSettings->options->limitMax > 0 ) {
							self::check_limit_char( $post, $fieldSettings, $fieldName, $colum->field_title, $validationForm );
						}
					}
					if ( isset( $fieldSettings->options->requiredConfirm ) && (int)$fieldSettings->options->requiredConfirm == 1 ) {
						$postData = isset( $post[ $fieldName ] ) ? $post[ $fieldName ] : '';
						$postDataConfirm = isset( $post[ $fieldName . '_confirm' ] ) ? $post[ $fieldName . '_confirm' ] : '';
						if ( isset( $fieldSettings->options->required ) && (int)$fieldSettings->options->required == 1 && $postData != $postDataConfirm ) {
							$error = __( 'Both %s addresses must be the same.', WR_CONTACTFORM_TEXTDOMAIN );
							$validationForm[ $fieldName ] = str_replace( '%s', $colum->field_title, $error );
						}
						else if ( ! empty( $postData ) && ! empty( $postDataConfirm ) && $postData != $postDataConfirm ) {
							$error = __( 'Both %s addresses must be the same.', WR_CONTACTFORM_TEXTDOMAIN );
							$validationForm[ $fieldName ] = str_replace( '%s', $colum->field_title, $error );
						}
					}
					if ( isset( $fieldSettings->options->required ) && (int)$fieldSettings->options->required == 1 && (int)$fieldSettings->options->hideField != 1 ) {
						$checkValidation = array();
						$checkValidation = apply_filters( 'wr_contactform_filter_required_type_' . str_replace( '-', '_', $colum->field_type ), $checkValidation, $post, $fieldName, $colum, $fieldSettings );
						if ( ! empty( $checkValidation ) ) {
							if ( is_array( $checkValidation ) ) {
								$validationForm = array_merge( $validationForm, $checkValidation );
							}
						}
						else {
							if ( isset( $post[ $fieldName ] ) && $post[ $fieldName ] == '' ) {
								$validationForm[ $fieldName ] = __( 'This field can not be empty, please enter required information.', WR_CONTACTFORM_TEXTDOMAIN );
							}
						}
					}
					do_action( 'wr_contactform_frontend_action_save_form', $validationForm, $submissions, $postFormId, $fieldSettings, $post, $fieldName, $colum );
					$validationForm = apply_filters( 'wr_contactform_frontend_validation_save_form', $validationForm, $colum, $submissions, $postFormId, $fieldSettings, $post, $fieldName );
				}
				else {
					$formTypeNotSendEmail = array();
					$formTypeNotSendEmail[ ] = 'google-maps';
					$formTypeNotSendEmail[ ] = 'file-upload';
					$formTypeNotSendEmail = apply_filters( 'wr_contactform_filter_form_type_not_send_email', $formTypeNotSendEmail );
					if ( isset( $colum->field_type ) && ! in_array( $colum->field_type, $formTypeNotSendEmail ) ) {
						$nameFileByIndentifier[ $colum->field_identifier ] = $colum->field_title;
						$dataContentEmail[ $colum->field_identifier ] = $fieldSettings->options->value;
					}
				}
			}
		}
		if ( ! $validationForm ) {
			self::_save( $dataForms, (int)$postID, $return, $post, $submissionsData, $dataContentEmail, $nameFileByIndentifier, $requiredField, $fileAttach );
			return $return;
		}
		else {
			$return->error = $validationForm;
			return $return;
		}
	}

	/**
	 * Save data
	 *
	 * @param   Array    $dataForms                Data form
	 * @param   Int      $postID                   Post ID
	 * @param   Array    &$return                  Return
	 * @param   Array    $post                     Post form
	 * @param   String   $submissionsData          Submission Data
	 * @param   String   $fieldId                  Field Id
	 * @param   String   $dataContentEmail         Data content Email
	 * @param   String   $nameFileByIndentifier    Get name Field by Indentifier
	 * @param   String   $requiredField            required field
	 * @param   String   $fileAttach               Email File Attach
	 *
	 * @return boolean
	 */
	private function _save( $dataForms, $postID, &$return, $post, $submissionsData, $dataContentEmail, $nameFileByIndentifier, $requiredField, $fileAttach ) {
		global $wpdb;
		do_action( 'wr_contactform_before_save_form', $dataForms, $postID, $post, $submissionsData, $dataContentEmail, $nameFileByIndentifier, $requiredField, $fileAttach );
		$checkSaveSubmission = true;
		$getMeta = get_post_meta( (int)$postID );
		if ( ! empty( $dataForms[ 'action_save_submissions' ][ 0 ] ) && $dataForms[ 'action_save_submissions' ][ 0 ] == 'No' ) {
			$checkSaveSubmission = false;
		}
		if ( $checkSaveSubmission ) {
			$my_post = array(
				'post_type' => 'wr_cfsb_post_type',
				'post_status' => 'publish',
				'post_content' => (int)$post[ 'form_id' ],
				'post_title' => get_the_title( (int)$postID ),
			);
			$submissionID = wp_insert_post( $my_post );
		}
		$listEmailSendTo = ! empty( $getMeta[ 'list_email_send_to' ][ 0 ] ) ? unserialize( $getMeta[ 'list_email_send_to' ][ 0 ] ) : '';
		$listEmailSendToSubmitter = ! empty( $getMeta[ 'list_email_send_to_submitter' ][ 0 ] ) ? unserialize( $getMeta[ 'list_email_send_to_submitter' ][ 0 ] ) : '';
		$contentEmailSendTo = ! empty( $getMeta[ 'content_email_send_to' ][ 0 ] ) ? unserialize( $getMeta[ 'content_email_send_to' ][ 0 ] ) : '';
		$contentEmailSendToSubmitter = ! empty( $getMeta[ 'content_email_send_to_submitter' ][ 0 ] ) ? unserialize( $getMeta[ 'content_email_send_to_submitter' ][ 0 ] ) : '';

		$formSubmitter = isset( $dataForms->form_submitter ) ? json_decode( $dataForms->form_submitter ) : '';
		$checkEmailSubmitter = true;
		$defaultSubject = isset( $dataForms->form_title ) ? $dataForms->form_title . ' [' . $dataForms[ 'form_id' ] . ']' : '';

		if ( ! empty( $contentEmailSendTo ) && count( $listEmailSendTo ) ) {
			if ( count( $listEmailSendTo ) ) {
				$getContentSendTo = self::get_content_email( $contentEmailSendTo, $dataContentEmail, $nameFileByIndentifier, $requiredField, $defaultSubject );
				$this->send_email_list( $getContentSendTo, $listEmailSendTo, $fileAttach );
				// Set the success message if it was a success
			}
		}
		if ( $contentEmailSendToSubmitter && ! empty( $listEmailSendToSubmitter ) ) {
			if ( count( $listEmailSendToSubmitter ) ) {
				$getContentSendSubmitter = self::get_content_email( $contentEmailSendToSubmitter, $dataContentEmail, $nameFileByIndentifier, $requiredField, $defaultSubject );
				$listEmailSubmitter = array();
				foreach ( $listEmailSendToSubmitter as $item ) {
					if ( ! empty( $item ) ) {
						if ( ! empty( $dataContentEmail[ $item ] ) ) {
							$listEmailSubmitter[ ] = $dataContentEmail[ $item ];
						}
					}
				}
				$this->send_email_list( $getContentSendSubmitter, $listEmailSubmitter, $fileAttach );
				// Set the success message if it was a success
			}
		}
		if ( $checkSaveSubmission ) {
			foreach ( $submissionsData as $submission ) {
				if ( ! empty( $submission ) ) {
					$submission[ 'submission_id' ] = $submissionID;
					if ( in_array( $submission[ 'field_type' ], array( 'os', 'browser', 'ip', 'date' ) ) ) {
						$wpdb->insert(
							$wpdb->prefix . 'wr_contactform_submission_data', $submission, array( '%d', '%s', '%s', '%d' )
						);
					}
					else {
						$wpdb->insert(
							$wpdb->prefix . 'wr_contactform_submission_data', $submission, array(
								'%d',
								'%d',
								'%s',
								'%s',
								'%d',
							)
						);
					}
				}
			}
			$countPost = wp_count_posts( 'wr_cfsb_post_type' );
			$countForm = (int)$countPost->publish + (int)$countPost->future + (int)$countPost->draft + (int)$countPost->pending + (int)$countPost->private + (int)$countPost->trash;
		}
		if ( ! empty( $_SESSION[ 'securimage_code_value' ][ $_POST[ 'form_name' ] ] ) ) {
			unset( $_SESSION[ 'securimage_code_value' ][ $_POST[ 'form_name' ] ] );
			unset( $_SESSION[ 'securimage_code_disp' ][ $_POST[ 'form_name' ] ] );
			unset( $_SESSION[ 'securimage_code_ctime' ][ $_POST[ 'form_name' ] ] );
		}
		do_action( 'wr_contactform_after_save_form', $dataForms, $postID, $post, $submissionsData, $dataContentEmail, $nameFileByIndentifier, $requiredField, $fileAttach );
		return true;
	}

	/**
	 * Get Cotent Email
	 *
	 * @param   type    $emailTemplate            email content
	 * @param   String  $dataContentEmail         Data content Email
	 * @param   Strig   $nameFileByIndentifier    Get name Field by Indentifier
	 * @param   String  $requiredField            required field
	 * @param   String  $defaultSubject           Default Subject Email
	 *
	 * @return stdClass
	 */
	public function get_content_email( $emailTemplate, $dataContentEmail, $nameFileByIndentifier, $requiredField, $defaultSubject ) {
		if ( ! empty( $emailTemplate[ 'message' ] ) ) {
			$emailTemplate[ 'message' ] = preg_replace( '/\{\$([^\}]+)\}/ie', '@$dataContentEmail["\\1"]', $emailTemplate[ 'message' ] );
		}
		else {
			$htmlMessage = array();
			if ( $dataContentEmail ) {
				$htmlMessage = $this->email_template_default( $dataContentEmail, $nameFileByIndentifier, $requiredField );
			}
			$emailTemplate[ 'message' ] = $htmlMessage;
		}

		$emailTemplate[ 'subject' ] = preg_replace( '/\{\$([^\}]+)\}/ie', '@$dataContentEmail["\\1"]', $emailTemplate[ 'subject' ] );
		$emailTemplate[ 'subject' ] = ! empty( $emailTemplate[ 'subject' ] ) ? $emailTemplate[ 'subject' ] : $defaultSubject;
		$emailTemplate[ 'from' ] = preg_replace( '/\{\$([^\}]+)\}/ie', '@$dataContentEmail["\\1"]', $emailTemplate[ 'from' ] );
		$emailTemplate[ 'reply' ] = preg_replace( '/\{\$([^\}]+)\}/ie', '@$dataContentEmail["\\1"]', $emailTemplate[ 'reply' ] );
		$emailTemplate[ 'subject' ] = strip_tags( $emailTemplate[ 'subject' ] );
		$emailTemplate[ 'from' ] = strip_tags( $emailTemplate[ 'from' ] );
		$emailTemplate[ 'reply' ] = strip_tags( $emailTemplate[ 'reply' ] );

		return $emailTemplate;
	}

	/**
	 * get content email
	 *
	 * @param type      $emailContent         email content
	 * @param   String  $requiredField        required field
	 *
	 * @return string
	 */
	public function email_template_default( $emailContent, $nameFileByIndentifier, $requiredField ) {
		$i = 0;
		$htmlMessage = '';
		foreach ( $emailContent as $key => $value ) {
			$i ++;
			$value = ! empty( $value ) ? $value : 'Null';
			$name = ! empty( $nameFileByIndentifier[ $key ] ) ? $nameFileByIndentifier[ $key ] : $key;
			$required = '';
			if ( isset( $requiredField[ $key ] ) && $requiredField[ $key ] == 1 ) {
				$required = '<span style="  color: red;font-weight: bold; margin: 0 5px;">*</span>';
			}
			if ( $i % 2 == 0 ) {
				$htmlMessage .= '<tr style="background-color: #FEFEFE;">';
				if ( $name ) {
					$htmlMessage .= ' <td style="width: 30%; font-weight: bold;border-left: 1px solid #DDDDDD;line-height: 20px;padding: 8px;text-align: left;vertical-align: top;">' . $name . $required . '</td>';
				}
				$htmlMessage .= '<td style="border-left: 1px solid #DDDDDD;line-height: 20px;padding: 8px;text-align: left;vertical-align: top;">' . $value . '</td></tr>';
			}
			else {
				$htmlMessage .= '<tr style="background-color: #F6F6F6;">';
				if ( $name ) {
					$htmlMessage .= ' <td style="width: 30%; font-weight: bold;border-left: 1px solid #DDDDDD;line-height: 20px;padding: 8px;text-align: left;vertical-align: top;">' . $name . $required . '</td>';
				}
				$htmlMessage .= '<td style="border-left: 1px solid #DDDDDD;line-height: 20px;padding: 8px;text-align: left;vertical-align: top;">' . $value . '</td></tr>';
			}
		}
		return '<table style="border-spacing: 0;width: 100%;-moz-border-bottom-colors: none;-moz-border-left-colors: none;-moz-border-right-colors: none; -moz-border-top-colors: none; border-collapse: separate; border-color: #DDDDDD #DDDDDD #DDDDDD -moz-use-text-color; border-image: none; border-radius: 4px 4px 4px 4px;  border-style: solid solid solid none;border-width: 1px 1px 1px 0;"><tbody>' . $htmlMessage . '</tbody></table>';
	}

	/**
	 * Send email by list email
	 *
	 * @param   Object  $dataTemplates         Data tempalte
	 *
	 * @param   Array   $listEmail             List email
	 *
	 * @param   Array   $fileAttach            File Attach
	 *
	 * @return  boolean
	 */
	private function send_email_list( $dataTemplates, $listEmail, $fileAttach = null ) {
		$regex = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,6})$/';
		add_filter( 'wp_mail_content_type', array( &$this, 'set_html_content_type' ) );
		if ( ! empty( $listEmail ) && is_array( $listEmail ) && count( $listEmail ) ) {
			$headers[ ] = 'From: ' . $dataTemplates[ 'from' ];
			$subject = $dataTemplates[ 'subject' ];
			$body = $dataTemplates[ 'message' ];
			$to = '';
			$attachments = array();
			$message = stripslashes( $body );
			if ( ! empty( $dataTemplates[ 'reply' ] ) && preg_match( $regex, $dataTemplates[ 'reply' ] ) ) {
				$headers[ ] = 'Reply-To: ' . $dataTemplates[ 'reply' ] . ' <' . $dataTemplates[ 'reply' ] . '>';
			}
			if ( ! empty( $dataTemplates[ 'attach' ] ) && ! empty( $fileAttach ) ) {
				$attach = $dataTemplates[ 'attach' ];
				if ( ! empty( $attach ) ) {
					foreach ( $attach as $file ) {
						if ( ! empty( $fileAttach[ $file ] ) ) {
							foreach ( $fileAttach[ $file ] as $f ) {
								$attachments[ ] = $f;
							}
						}
					}
				}
			}

			// Add filter wp_mail
			global $wr_contactform_mail_args;
			if ( empty( $dataTemplates[ 'from' ] ) ) {
				$wr_contactform_mail_args[ 'from' ] = get_option( 'wr_contactform_default_mail_from', WR_Contactform_Helpers_Contactform::get_default_mail_from() );
			} else {
				$wr_contactform_mail_args[ 'from' ] = $dataTemplates[ 'from' ];
			}
			$wr_contactform_mail_args[ 'from_name' ] = $dataTemplates[ 'from' ];
			add_filter( 'wp_mail_from', array( $this, 'set_mail_from' ), 9, 1 );
			add_filter( 'wp_mail_from_name', array( $this, 'set_mail_from_name' ), 9, 1 );

			foreach ( $listEmail as $email ) {
				if ( preg_match( $regex, $email ) ) {
					wp_mail( $email, $subject, $message, $headers, $attachments );
				}
			}
			// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
			remove_filter( 'wp_mail_content_type', array( &$this, 'set_html_content_type' ) );
		}
	}

	function set_html_content_type() {

		return 'text/html';
	}

	/**
	 * set "From" argument of mail
	 *
	 * @return string
	 */
	function set_mail_from( $from ) {
		global $wr_contactform_mail_args;
		return $wr_contactform_mail_args[ 'from' ];
	}

	/**
	 * set "From name" argument of mail
	 *
	 * @return string
	 */
	function set_mail_from_name( $from_name ) {
		global $wr_contactform_mail_args;
		return $wr_contactform_mail_args[ 'from_name' ];
	}

	/**
	 *     get html form
	 *
	 * @return string
	 */
	function get_html_form( $formId ) {
		if ( ! empty( $formId ) && is_numeric( $formId ) ) {
			global $wpdb;
			$postId = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE  meta_key='form_id' AND meta_value=%d", (int)$formId ) );
			if ( empty( $postId ) ) {
				$postId = $formId;
			}
			$formName = md5( date( 'Y-m-d H:i:s' ) ) . rand( 0, 1000 );
			echo '' . WR_Contactform_Helpers_Contactform::generate_html_pages( $postId, $formId, $formName, 'ajax' );
			exit();
		}
	}
}

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
 * WR ContactForm action Ajax.
 * 
 * @package  WR_ContactForm
 * @since    1.0.0
 */
class WR_Contactform_Helpers_Ajax {

	/**
	 * Constructor.
	 *
	 * @return  void
	 */
	public function __construct() {
		// Prepare admin pages
		if ( defined( 'WP_ADMIN' ) ) {
			add_action( 'wp_ajax_wr_contactform_save_page', array( &$this, 'wr_contactform_save_page' ) );
			add_action( 'wp_ajax_wr_contactform_load_session_field', array( &$this, 'wr_contactform_load_session_field' ) );
			add_action( 'wp_ajax_wr_contactform_load_page', array( &$this, 'wr_contactform_load_page' ) );
			add_action( 'wp_ajax_wr_contactform_getcountfield', array( &$this, 'wr_contactform_getcountfield' ) );
			add_action( 'wp_ajax_wr_contactform_hidden_columns', array( &$this, 'wr_contactform_ajax_hidden_columns' ) );
		}
	}

	function wr_contactform_ajax_hidden_columns() {
		// Set custom error reporting level
		error_reporting( E_ALL ^ E_NOTICE );
		if ( ! empty( $_POST ) ) {
			$form = ! empty( $_POST[ 'form_id' ] ) ? $_POST[ 'form_id' ] : '';
			$postColumns = ! empty( $_POST[ 'columns' ] ) ? $_POST[ 'columns' ] : '';

			if ( ! empty( $form ) ) {
				if ( ! $user = wp_get_current_user() ) {
					wp_die( - 1 );
				}
				$columns = array();
				$getColumns = get_user_option( 'wr_cfsb_post_type_column', $user->ID );

				if ( ! empty( $getColumns ) ) {
					$columns = $getColumns;
					$columns[ $form ] = $postColumns;
				}
				else {
					$columns[ $form ] = $postColumns;
				}
				update_user_option( $user->ID, 'wr_cfsb_post_type_column', $columns, true );
			}
		}
		else if ( ! empty( $_GET ) ) {
			$form = ! empty( $_GET[ 'form_id' ] ) ? $_GET[ 'form_id' ] : '';
			if ( ! $user = wp_get_current_user() ) {
				wp_die( - 1 );
			}
			$columns = get_user_option( 'wr_cfsb_post_type_column', $user->ID );
			$data = ! empty( $columns[ $form ] ) ? json_encode( $columns[ $form ] ) : '';
			echo '' . $data;
		}
		exit();
	}

	/**
	 * Save page form to session
	 *
	 * @return void
	 */
	public function wr_contactform_save_page() {
		// Set custom error reporting level
		error_reporting( E_ALL ^ E_NOTICE );
		$post = $_POST;
		$formId = ! empty( $post[ 'form_id' ] ) ? $post[ 'form_id' ] : 0;

		if ( ! empty( $post[ 'form_list_container' ] ) ) {
			$formPageName = stripslashes( $post[ 'form_page_name' ] );
			$_SESSION[ 'form-design-' . $formId ][ 'form_container_page_' . $formPageName ] = $post[ 'form_list_container' ];
		}
		if ( ! empty( $post[ 'form_page_name' ] ) ) {
			$tmpIdentify = array();
			$formContent = '';
			if ( isset( $post[ 'form_content' ] ) ) {
				$formContent = is_array( $post[ 'form_content' ] ) ? json_encode( $post[ 'form_content' ] ) : $post[ 'form_content' ];
				$formContent = stripslashes( $formContent );
			}
			$formPageName = stripslashes( $post[ 'form_page_name' ] );
			$_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $formPageName ] = $formContent;
		}
		if ( ! empty( $post[ 'form_list_page' ] ) ) {
			$count = 0;
			foreach ( $post[ 'form_list_page' ] as $listPage ) {
				//set default data field
				$dataField = '';
				//set page name
				$pageName = stripslashes( $listPage[ 0 ] );
				if ( isset( $pageName ) && isset( $post[ 'form_page_name' ] ) ) {
					$dataField = ! empty( $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $pageName ] ) ? $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $pageName ] : '';
					if ( ! empty( $dataField ) ) {
						if ( ! is_array( $dataField ) ) {
							$dataField = json_decode( $dataField );
						}
						if ( ! empty( $dataField ) ) {
							foreach ( $dataField as $index => $field ) {
								$count ++;
								if ( ! empty( $field->identify ) ) {
									while ( in_array( $field->identify, $tmpIdentify ) ) {
										$field->identify = $field->identify . '_' . ( $count + 1 );
									}
									$tmpIdentify[ ] = $field->identify;
									$dataField[ $index ]->identify = preg_replace( '/[^a-z0-9-._]/i', '', $field->identify );
								}
							}
						}
						$_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $pageName ] = json_encode( $dataField );
					}
				}
			}
			$formListPage = stripslashes( json_encode( $post[ 'form_list_page' ] ) );
			$_SESSION[ 'form-design-' . $formId ][ 'form_list_page' ] = $formListPage;
		}
		exit();
	}

	/**
	 * load data field on session
	 *
	 * @return json code
	 */
	public function wr_contactform_load_session_field() {
		// Set custom error reporting level
		error_reporting( E_ALL ^ E_NOTICE );
		//set $post
		$post = $_POST;
		//set form id
		$formId = ! empty( $post[ 'form_id' ] ) ? $post[ 'form_id' ] : 0;
		$formPage = array();
		//set default $tmpIdentify
		$tmpIdentify = array();

		if ( isset( $post[ 'form_page_name' ] ) && isset( $post[ 'form_content' ] ) ) {
			//set $formContent
			$formContent = is_array( $post[ 'form_content' ] ) ? json_encode( $post[ 'form_content' ] ) : $post[ 'form_content' ];
			//stripslashes $formContent
			$formContent = stripslashes( $formContent );
			//set $formPageName
			$formPageName = stripslashes( $post[ 'form_page_name' ] );
			$_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $formPageName ] = $formContent;
		}
		if ( ! empty( $post[ 'form_list_page' ] ) ) {
			$count = 0;
			foreach ( $post[ 'form_list_page' ] as $listPage ) {
				$dataField = '';
				//stripslashes $pageName
				$pageName = stripslashes( $listPage[ 0 ] );
				if ( isset( $pageName ) && isset( $post[ 'form_page_name' ] ) ) {
					$dataField = ! empty( $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $pageName ] ) ? $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $pageName ] : '';

					if ( isset( $dataField ) ) {
						if ( ! is_array( $dataField ) ) {
							$dataField = json_decode( $dataField );
						}
						if ( is_array( $dataField ) ) {
							foreach ( $dataField as $index => $field ) {
								$count ++;
								while ( in_array( $field->identify, $tmpIdentify ) ) {
									$field->identify = $field->identify . '_' . ( $count + 1 );
								}
								$tmpIdentify[ ] = $field->identify;
								$dataField[ $index ]->identify = preg_replace( '/[^a-z0-9-._]/i', '', $field->identify );
							}
							$_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $pageName ] = json_encode( $dataField );
						}
						if ( ! empty( $dataField ) && $dataField != 'null' ) {
							$formPage = array_merge( $formPage, $dataField );
						}
					}
				}
			}
			if ( ! empty( $formPage ) ) {
				echo json_encode( $formPage );
			}
		}
		exit();
	}

	/**
	 * load page on session
	 *
	 * @return json code
	 */
	public function wr_contactform_load_page() {
		// Set custom error reporting level
		error_reporting( E_ALL ^ E_NOTICE );
		//set $post
		$post = $_POST;
		//set form id
		$formId = ! empty( $post[ 'form_id' ] ) ? $post[ 'form_id' ] : 0;
		//set default $dataPage
		$dataPage = '';
		//set $pageDefault
		$pageDefault = isset( $post[ 'join_page' ] ) ? $post[ 'join_page' ] : '';

		if ( ! empty( $post[ 'form_page_name' ] ) ) {
			$formPageName = stripslashes( $post[ 'form_page_name' ] );
			$formPage = ! empty( $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $formPageName ] ) ? $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $formPageName ] : '';
			if ( isset( $post[ 'form_page_old_name' ] ) && $post[ 'form_page_old_name' ] != $formPageName ) {

				if ( ! empty( $post[ 'form_page_old_content' ] ) ) {

					$formContentOld = is_array( $post[ 'form_page_old_content' ] ) ? json_encode( $post[ 'form_page_old_content' ] ) : $post[ 'form_page_old_content' ];
					$formOldContent = stripslashes( $formContentOld );
					$_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $post[ 'form_page_old_name' ] ] = $formOldContent;
				}
				if ( ! empty( $post[ 'form_page_old_container' ] ) ) {

					$formContainerOld = is_array( $post[ 'form_page_old_container' ] ) ? json_encode( $post[ 'form_page_old_container' ] ) : $post[ 'form_page_old_container' ];
					$formContainerOld = stripslashes( $formContainerOld );
					$_SESSION[ 'form-design-' . $formId ][ 'form_container_page_' . $post[ 'form_page_old_name' ] ] = $formContainerOld;
				}
			}

			if ( isset( $formPage ) && $pageDefault != 'defaultPage' ) {
				if ( is_array( $formPage ) ) {
					$dataPage = json_encode( $formPage );
				}
				else {
					$dataPage = $formPage;
				}
			}
			else {
				if ( ! empty( $post[ 'form_id' ] ) ) {
					//set form ID
					$formId = (int)$post[ 'form_id' ];
					// set form content
					$formContent = WR_Contactform_Helpers_Contactform::get_form_content( $formId );
					if ( ! empty( $formContent ) ) {
						foreach ( $formContent as $formContent ) {
							$_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $formContent->page_id ] = $formContent->page_content;
						}
						$dataPage = ! empty( $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $formPageName ] ) ? $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $formPageName ] : '';
					}
				}
				else {
					$dataPage = ! empty( $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $formPageName ] ) ? $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $formPageName ] : '';
				}
			}
		}
		$containerPage = ! empty( $_SESSION[ 'form-design-' . $formId ][ 'form_container_page_' . $formPageName ] ) ? $_SESSION[ 'form-design-' . $formId ][ 'form_container_page_' . $formPageName ] : '';
		$containerPage = stripslashes( $containerPage );
		if ( ! empty( $post[ 'join_page' ] ) && $post[ 'join_page' ] == 'join' && isset( $post[ 'form_list_page' ] ) && count( $post[ 'form_list_page' ] ) > 1 ) {
			$dataListPage = array();
			$listPage = $_SESSION[ 'form_list_page' ];
			//set default form page index
			$formPageIndex = array();
			//set default count position
			$countPosition = 0;
			//set default list page container
			$listPageContainer = array();
			foreach ( $post[ 'form_list_page' ] as $index => $listPage ) {
				$pageName = stripslashes( $listPage[ 0 ] );
				if ( ! empty( $pageName ) && ! empty( $post[ 'form_page_name' ] ) ) {
					$positionContainer = array();
					$pageContent = ! empty( $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $pageName ] ) ? $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $pageName ] : '';

					$pageContainer = ! empty( $_SESSION[ 'form-design-' . $formId ][ 'form_container_page_' . $pageName ] ) ? $_SESSION[ 'form-design-' . $formId ][ 'form_container_page_' . $pageName ] : '';
					$pageContainer = stripslashes( $pageContainer );
					$pageContainer = json_decode( $pageContainer );

					foreach ( $pageContainer as $containerDetail ) {
						$countPosition ++;
						foreach ( $containerDetail as $cd ) {
							//set $position
							$position = explode( '_', $cd->columnName );
							//add array list position container
							$positionContainer[ $cd->columnName ] = $position[ 0 ] . '_' . ( $countPosition );
							//set columnName
							$cd->columnName = $position[ 0 ] . '_' . ( $countPosition );
							//add array list page container
							$listPageContainer[ $countPosition - 1 ][ ] = $cd;
						}
					}
					if ( ! empty( $pageContent ) && $pageContent != 'null' ) {
						//set default pContent
						$pContent = array();
						//set page content
						$pageContent = json_decode( $pageContent );
						foreach ( $pageContent as $pct ) {
							//set position container
							$pct->position = $positionContainer[ $pct->position ];
							//add array list pages content
							$pContent[ ] = $pct;
						}
						$dataListPage = array_merge( $dataListPage, $pContent );
					}
				}
				if ( $index == 0 ) {
					$formPageIndex[ ] = $pageName;
					$pageName1 = stripslashes( $listPage[ 1 ] );
					$formPageIndex[ ] = $pageName1;
				}
				else {
					unset( $_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $pageName ] );
				}
			}
			$dataListPageEncode = json_encode( $dataListPage );
			unset( $_SESSION[ 'form-design-' . $formId ][ 'form_list_page' ] );
			$_SESSION[ 'form-design-' . $formId ][ 'form_page_' . $formPageIndex[ 0 ] ] = $dataListPageEncode;
			$_SESSION[ 'form-design-' . $formId ][ 'form_list_page' ] = json_encode( $formPageIndex );
			$_SESSION[ 'form-design-' . $formId ][ 'form_container_page_' . $formPageIndex[ 0 ] ] = json_encode( $listPageContainer );
			echo json_encode(
				array(
					'dataField' => $dataListPageEncode,
					'containerPage' => json_encode( $listPageContainer )
				)
			);
		}
		else {
			echo json_encode( array( 'dataField' => $dataPage, 'containerPage' => $containerPage ) );
		}
		exit();

	}

	/**
	 * get count field
	 *
	 * @return  void
	 */
	public static function wr_contactform_getcountfield() {
		// Set custom error reporting level
		error_reporting( E_ALL ^ E_NOTICE );
		$post = $_POST;
		// get Field ID
		$fieldId = isset( $post[ 'field_id' ] ) ? $post[ 'field_id' ] : 0;
		// get Form ID
		$formId = ! empty( $post[ 'form_id' ] ) ? $post[ 'form_id' ] : 0;
		if ( $formId && $fieldId ) {
			echo json_encode( JSNContactformHelper::getDataSumbissionByField( $fieldId, $formId ) );
		}
		exit();

	}

}

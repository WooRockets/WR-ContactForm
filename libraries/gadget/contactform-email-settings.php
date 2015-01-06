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

class WR_CF_Gadget_Contactform_Email_Settings extends WR_CF_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-email-settings';

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
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @return  void
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'jquery-ui-resizable' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-button' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		$assets = array(
			'wr-jquery-placeholder-js',
			'wr-jquery-tipsy-js',
			'wr-jquery-json-js',
			'wr-jquery-select2-js',
			'wr-jquery-wysiwyg-js',
			'wr-jquery-wysiwyg-colorpicker-js',
			'wr-jquery-wysiwyg-table-js',
			'wr-jquery-wysiwyg-cssWrap-js',
			'wr-jquery-wysiwyg-image-js',
			'wr-jquery-wysiwyg-link-js',
			'wr-jquery-wysiwyg-css',
			'wr-bootstrap2-css',
			'wr-jquery-select2-css',
			'wr-bootstrap2-responsive-css',
			'wr-bootstrap2-jsn-gui-css',
			'wr-bootstrap2-icomoon-css',
			'wr-jquery-ui-css',
			'wr-jquery-tipsy-css',
			'wr-contactform-css',
			'wr-contactform-modal-css',
			'wr-contactform-emailsettings-js',
		);
		WR_CF_Init_Assets::load( $assets );
	}

	/**
	 * Schedule rendering the output.
	 *
	 * @param   string  $action  Gadget action to execute.
	 *
	 * @return  void
	 */
	protected function render( $action = 'default' ) {
		// Store scheduled action
		$this->scheduled = $action;

		add_action( 'admin_head', array( &$this, 'admin_head' ) );
	}

	/**
	 * Render the output.
	 *
	 * @return  void
	 */
	public function admin_head() {
		include WR_CF_Loader::get_path( 'gadget/tmpl/email-settings/default.php' );
		exit;
	}
}

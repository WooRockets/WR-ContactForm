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
 * WR ContactForm Hook.
 *
 * @package  WR_ContactForm
 * @since    1.0.0
 */
class WR_Contactform_Helpers_Hook {

	/**
	 * IT Contactform Plugin's custom post type slug.
	 *
	 * @var  string
	 */
	public $type_slug = 'wr_cf_post_type';

	/**
	 * Define pages.
	 *
	 * @var  array
	 */
	public static $pages = array( 'wr_cf_post_type', 'wr_cfsb_post_type' );


	/**
	 * Render configuration page.
	 *
	 * @return  void
	 */
	public static function settings() {
		WR_CF_Init_Assets::load(
			array(
				//'wr-bootstrap-css',
				'wr-bootstrap2-jsn-gui-css',
				'wr-contactform-css',
			)
		);
		WR_Contactform_Settings::render();
	}

	/**
	 * Render addons management screen.
	 *
	 * @return  void
	 */
	public static function addons() {
		// Instantiate product addons class
		WR_CF_Init_Assets::load(
			array(
				'wr-bootstrap3-css',
				'wr-bootstrap3-jsn-gui-css',
				//'wr-jquery-ui-css',
				//'wr-contactform-css',
				'wr-form-css',
				'wr-form-js',
				'wr-addons-css',
				'wr-addons-js',
			)
		);
		WR_CF_Product_Addons::init( WR_CONTACTFORM_IDENTIFICATION );
	}

	/**
	 * Render About page.
	 *
	 * @return  void
	 */
	public static function about() {
		// Instantiate form object
		$form = WR_CF_Form::get_instance( 'wr_contactform_about_us' );
		// Render HTML form
		$form->render( 'about-us' );
	}

	/**
	 * Overwrite submission customer view count data
	 *
	 * @param $views
	 *
	 * @return mixed
	 */
	public static function wr_contactform_submissions_custom_view_count( $views ) {
		global $wpdb;

		/*
		 * This needs refining, and maybe a better method
		 * e.g. Attachments have completely different counts
		 */
		$formID = ! empty( $_SESSION[ 'wr-contactform' ][ 'form_id' ] ) ? $_SESSION[ 'wr-contactform' ][ 'form_id' ] : '';
		$where = '';
		$total = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'publish' OR post_status = 'trash' OR post_status = 'draft' OR post_status = 'pending') AND (post_content = '" . (int)$formID . "'  AND post_type = 'wr_cfsb_post_type' ) " . $where );
		$publish = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'wr_cfsb_post_type' AND post_content = " . (int)$formID . $where );
		$trash = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'trash' AND post_type = 'wr_cfsb_post_type' AND post_content = " . (int)$formID . $where );
		$draft = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'draft'  AND post_type = 'wr_cfsb_post_type' AND post_content = " . (int)$formID . $where );
		$pending = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'pending' AND post_type = 'wr_cfsb_post_type' AND post_content = " . (int)$formID . $where );
		/*
		 * Only tested with Posts/Pages
		 * - there are moments where Draft and Pending shouldn't return any value
		 */
		$views[ 'all' ] = preg_replace( '/\(.+\)/U', '(' . $total . ')', $views[ 'all' ] );
		if ( ! empty( $views[ 'publish' ] ) ) {
			$views[ 'publish' ] = preg_replace( '/\(.+\)/U', '(' . $publish . ')', $views[ 'publish' ] );
		}
		if ( ! empty( $views[ 'trash' ] ) ) {
			$views[ 'trash' ] = preg_replace( '/\(.+\)/U', '(' . $trash . ')', $views[ 'trash' ] );
		}
		if ( ! empty( $views[ 'draft' ] ) ) {
			$views[ 'draft' ] = preg_replace( '/\(.+\)/U', '(' . $draft . ')', $views[ 'draft' ] );
		}
		if ( ! empty( $views[ 'pending' ] ) ) {
			$views[ 'pending' ] = preg_replace( '/\(.+\)/U', '(' . $pending . ')', $views[ 'pending' ] );
		}
		return $views;
	}

	//------------------------------------------------------
	//------------- PAGE/POST EDIT PAGE ---------------------

	public static function page_supports_add_form_button() {
		if ( ! defined( 'RG_CURRENT_PAGE' ) ) define( 'RG_CURRENT_PAGE', basename( $_SERVER[ 'PHP_SELF' ] ) );
		$is_post_edit_page = in_array(
			RG_CURRENT_PAGE, array(
				'post.php',
				'page.php',
				'page-new.php',
				'post-new.php',
			)
		);
		WR_CF_Init_Assets::hook();
		wp_enqueue_script( 'jquery' );
		WR_CF_Init_Assets::load(
			array(
				'wr-contactform-editor-plugin-css',
				'wr-contactform-editor-plugin-js',
			)
		);
		add_action( 'admin_footer', array( __CLASS__, 'add_mce_popup' ) );
		$display_add_form_button = apply_filters( 'wr_contactform_display_add_form_button', $is_post_edit_page );
		return $display_add_form_button;
	}

	//Action target that displays the popup to insert a form to a post/page
	public static function add_mce_popup() {
		?>
	<div id="select_contactform_form" style="display:none;">
		<div class="wrap wr-contactform-thickbox-add-field">
			<div class="wr-contactform-thickbox-header">
				<h3><?php _e( 'Insert A Form', WR_CONTACTFORM_TEXTDOMAIN ); ?></h3>
				<span> <?php _e( 'Select a form below to add it to your post or page.', WR_CONTACTFORM_TEXTDOMAIN ); ?> </span>
			</div>
			<div class="wr-contactform-thickbox-content">
				<select class="wr-contactform-list-form">
					<option value="">  <?php _e( 'Select a Form', WR_CONTACTFORM_TEXTDOMAIN ); ?>  </option>
					<?php
					$forms = get_posts(
						array(
							'post_type' => 'wr_cf_post_type',
							'post_status' => 'any',
							'numberposts' => '99999',
						)
					);
					if ( ! empty( $forms ) ) {
						foreach ( $forms as $form ) {
							$formTitle = ! empty( $form->post_title ) ? $form->post_title : '(no title)';
							$meta = get_post_meta( (int)$form->ID );
							if ( ! empty( $meta[ 'form_id' ][ 0 ] ) ) {
								$formID = (int)$meta[ 'form_id' ][ 0 ];
							}
							else {
								$formID = (int)$form->ID;
							}
							?>
							<option value="<?php echo absint( $formID ) ?>"><?php echo esc_html( $formTitle ) ?></option>
							<?php
						}
					}
					?>
				</select>

				<div class="wr-contactform-thickbox-messages"><?php _e( 'Can\'t find your form? Make sure it is active.', WR_CONTACTFORM_TEXTDOMAIN ); ?></div>
			</div>
			<div class="wr-contactform-thicjbox-action">
				<input type="button" class="button-primary" id="wr_contactform_btn_add_fied" value="<?php _e( 'Insert Form', WR_CONTACTFORM_TEXTDOMAIN ); ?>" />
				<a class="button" href="#" onclick="tb_remove(); return false;"><?php _e( 'Cancel', WR_CONTACTFORM_TEXTDOMAIN ); ?></a>
			</div>
		</div>
	</div>
	<?php
	}

	//Action target that adds the 'Insert Form' button to the post/page edit screen
	public static function add_form_button() {

		$is_add_form_page = self::page_supports_add_form_button();
		if ( ! $is_add_form_page ) return;

		// do a version check for the new 3.5 UI
		$version = get_bloginfo( 'version' );

		if ( $version < 3.5 ) {
			// show button for v 3.4 and below
			$image_btn = WR_CONTACTFORM_URI . 'assets/images/icons-16/icon-form-16x16.png';
			echo '<a href="#TB_inline?width=350&height=500&inlineId=select_contactform_form" class="thickbox" id="add_wr_contactform" title="' . __( 'WR ContactForm Add Form', WR_CONTACTFORM_TEXTDOMAIN ) . '"><img src="' . $image_btn . '" alt="' . __( 'WR ContactForm Add Form', WR_CONTACTFORM_TEXTDOMAIN ) . '" /></a>';
		}
		else {
			// display button matching new UI
			echo '<style>.wr-contactform-media-icon{
                    background:url(' . WR_CONTACTFORM_URI . 'assets/images/icons-16/icon-form-16x16.png) no-repeat top left;
                    display: inline-block;
                    height: 16px;
                    margin: 0 2px 0 0;
                    vertical-align: text-top;
                    width: 16px;
                    }
                    .wp-core-ui a.wr-contactform-media-icon{
                     padding-left: 0.4em;
                    }
                 </style>
                  <a href="#TB_inline?width=350&height=500&inlineId=select_contactform_form" class="thickbox button" id="add_wr_contactform" title="' . __( 'WR ContactForm Add Form', WR_CONTACTFORM_TEXTDOMAIN ) . '"><span class="wr-contactform-media-icon "></span> ' . __( 'Add Form', WR_CONTACTFORM_TEXTDOMAIN ) . '</a>';
		}
	}

	/**
	 * Register admin menu for IT Contactform Plugin.
	 *
	 * @return  void
	 */
	public static function wr_contactform_register_menus() {
		global $pagenow;
		// Get product information
		$plugin = WR_CF_Product_Info::get( WR_CONTACTFORM_IDENTIFICATION );
		// Generate menu title
		$menu_title = __( 'WR ContactForm', WR_CONTACTFORM_TEXTDOMAIN );

		if ( isset( $plugin[ 'Available_Update' ] ) && ( 'edit.php' != $pagenow || ! isset( $_GET[ 'post_type' ] ) || ! in_array( $_GET[ 'post_type' ], self::$pages ) ) ) {
			WR_CF_Init_Admin_Menu::replace(
				'WR ContactForm', array(
					0 => "WR ContactForm  <span class='wr-available-updates update-plugins count-{$plugin['Available_Update']}'><span class='pending-count'>{$plugin['Available_Update']}</span></span>",
					1 => 'edit_posts',
					2 => 'edit.php?post_type=wr_cf_post_type',
					3 => '',
					4 => 'menu-top menu-icon-wr_cf_post_type',
					5 => 'menu-posts-wr_cf_post_type',
					6 => WR_CONTACTFORM_URI . '/assets/images/icons-16/icon-forms.png',
				)
			);
		}
		// Register menu item for Forms page
		WR_CF_Init_Admin_Menu::add(
			array(
				'parent_slug' => 'edit.php?post_type=wr_cf_post_type',
				'menu_title' => __( 'All Forms', WR_CONTACTFORM_TEXTDOMAIN ),
				'page_title' => __( 'All Forms', WR_CONTACTFORM_TEXTDOMAIN ),
				'menu_slug' => 'edit.php?post_type=wr_cf_post_type',
				'capability' => 'edit_posts',
				'menu_slug' => 'edit.php?post_type=wr_cf_post_type',
			)
		);
		// Register menu item for Forms page
		WR_CF_Init_Admin_Menu::add(
			array(
				'parent_slug' => 'edit.php?post_type=wr_cf_post_type',
				'menu_title' => __( 'Add New', WR_CONTACTFORM_TEXTDOMAIN ),
				'page_title' => __( 'Add New', WR_CONTACTFORM_TEXTDOMAIN ),
				'menu_slug' => 'post-new.php?post_type=wr_cf_post_type',
				'capability' => 'edit_posts',
				'menu_slug' => 'post-new.php?post_type=wr_cf_post_type',
			)
		);
		// Register menu item for Submissions page
		WR_CF_Init_Admin_Menu::add(
			array(
				'parent_slug' => 'edit.php?post_type=' . 'wr_cf_post_type',
				'page_title' => 'WR ContactForm Plugin - Submissions',
				'menu_title' => 'Submissions',
				'capability' => 'edit_posts',
				'menu_slug' => 'edit.php?post_type=wr_cfsb_post_type',
			)
		);
		// Register menu item for configuration page
		WR_CF_Init_Admin_Menu::add(
			array(
				'parent_slug' => 'edit.php?post_type=' . 'wr_cf_post_type',
				'page_title' => 'WR ContactForm Plugin - Settings',
				'menu_title' => 'Settings',
				'capability' => 'edit_posts',
				'menu_slug' => 'wr-contactform-settings',
				'function' => array( 'WR_Contactform_Helpers_Hook', 'settings' )
			)
		);

		if ( $plugin[ 'Addons' ] ) {
			// Generate menu title
			$menu_title = __( 'Add-ons', WR_CONTACTFORM_TEXTDOMAIN );

			if ( $plugin[ 'Available_Update' ] && ( 'edit.php' == $pagenow && isset( $_GET[ 'post_type' ] ) && in_array( $_GET[ 'post_type' ], self::$pages ) ) ) {
				$menu_title .= " <span class='wr-available-updates update-plugins count-{$plugin['Available_Update']}'><span class='pending-count'>{$plugin['Available_Update']}</span></span>";
			}
			// Register menu item for configuration page
			WR_CF_Init_Admin_Menu::add(
				array(
					'parent_slug' => 'edit.php?post_type=' . 'wr_cf_post_type',
					'page_title' => 'WR ContactForm Plugin - Addons',
					'menu_title' => $menu_title,
					'capability' => 'edit_posts',
					'menu_slug' => 'wr-contactform-addons',
					'function' => array( 'WR_Contactform_Helpers_Hook', 'addons' )
				)
			);
		}

		WR_CF_Init_Admin_Menu::add(
			array(
				'parent_slug' => 'edit.php?post_type=' . 'wr_cf_post_type',
				'page_title' => 'WR ContactForm Plugin - About',
				'menu_title' => 'About',
				'capability' => 'edit_posts',
				'menu_slug' => 'wr-contactform-about-us',
				'function' => array( 'WR_Contactform_Helpers_Hook', 'about' )
			)
		);
	}

	/**
	 * Load necessary assets.
	 *
	 * @return  void
	 */
	public static function load_assets() {
		global $pagenow;
		if ( in_array( $pagenow, array( 'edit.php', 'post.php', 'post-new.php' ) ) ) {
			$post_type = $pagenow == 'post.php' ? ( isset( $_REQUEST[ 'post' ] ) ? get_post_type(
				$_REQUEST[ 'post' ]
			) : '' ) : ( isset ( $_REQUEST[ 'post_type' ] ) ? $_REQUEST[ 'post_type' ] : '' );	
			if ( $post_type == 'wr_cf_post_type' || $post_type == 'wr_cfsb_post_type' ) {
				// Load common assets
				$assets = WR_Contactform_Helpers_Contactform::load_asset_edit_form();
				self::insert_banner();
				add_filter( 'wr_contactform_form_edit_assets', array( 'WR_Contactform_Helpers_Contactform', 'load_asset_edit_form' ) );
				// Load additional assets for add/edit post page
				if ( $pagenow == 'edit.php' AND isset( $_REQUEST[ 'page' ] ) AND $_REQUEST[ 'page' ] == 'wr-sample-configuration' ) {
					$assets = array_merge( $assets, array() );
				}
				if ( $post_type != 'wr_cfsb_post_type' && $pagenow != 'edit.php' ) {
					WR_CF_Init_Assets::load( $assets );
				}
			}
			if ( $post_type == 'wr_cf_post_type' && empty( $_GET[ 'page' ] ) ) {
				add_action( 'delete_post', array( 'WR_Contactform_Helpers_Hook', 'delete_form' ) );
				if ( $pagenow == 'edit.php' ) {
					add_filter( 'post_row_actions', array( 'WR_Contactform_Helpers_Hook', 'hook_action_view_forms' ), 9, 2 );
					wp_enqueue_script( 'jquery' );
					$assets = array(
						'wr-bootstrap2-css',
						'wr-bootstrap2-jsn-gui-css',
						'wr-jquery-ui-css',
						'wr-contactform-css',
						'wr-contactform-forms-js',
					);
					add_filter( 'admin_footer_text', array( 'WR_Contactform_Helpers_Contactform', 'get_footer' ) );
					WR_CF_Init_Assets::load( $assets );
				}
			}
			if ( $post_type == 'wr_cfsb_post_type' && $pagenow == 'edit.php' ) {
				add_filter( 'admin_footer_text', array( 'WR_Contactform_Helpers_Contactform', 'get_footer' ) );
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'jquery-ui' );
				wp_enqueue_script( 'jquery-ui-dialog' );
				$assets = array(
					'wr-bootstrap2-css',
					'wr-jquery-daterangepicker-bs2-css',
					'wr-bootstrap2-jsn-gui-css',
					'wr-jquery-ui-css',
					'wr-contactform-css',
					'wr-jquery-json-js',
					'wr-jquery-daterangepicker-js',
					'wr-jquery-daterangepicker-moment-js',
					'wr-contactform-submissions-js',
				);
				WR_CF_Init_Assets::load( $assets );
				add_filter( 'months_dropdown_results', array( __CLASS__, 'wr_contactform_remove_filter_date' ), 10, 2 );
				add_action(
					'restrict_manage_posts', array(
						'WR_Contactform_Helpers_Hook',
						'submissions_restrict_manage_data',
					)
				);
				add_action( 'pre_get_posts', array( 'WR_Contactform_Helpers_Hook', 'filter_posts' ) );
				add_action( 'delete_post', array( 'WR_Contactform_Helpers_Hook', 'delete_submission' ) );
				add_filter(
					'views_edit-wr_cfsb_post_type', array(
						'WR_Contactform_Helpers_Hook',
						'wr_contactform_submissions_custom_view_count',
					), 10, 2
				);
			}
			if ( ( $post_type == 'wr_cf_post_type' ) && ( $pagenow == 'post-new.php' ) ) {
				WR_CF_Init_Assets::load( array(
					'wr-contactform-post-new-js'
				) );
			}
		}
	}

	/**
	 * Insert WooRockets banner.
	 * 
	 * @return void
	 */
	public static function insert_banner() {
			$style = '
			/*** Premium ***/
			#wr-promo-ab {
				background: url(' . WR_CONTACTFORM_URI . 'assets/images/about-us/bg-wr-promo-2.jpg) center top no-repeat;
				background-size: auto 100%;
				text-align: center;
				overflow: hidden;
				font-family: \'Open Sans\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;
			}
			#wr-promo-ab h3 {
			    margin: 180px 0 15px;
			    color: #fff;
			    font-size: 25px;
			    font-weight: bold;
			}
			#wr-promo-ab ul {
			    margin: 0 auto 25px auto;
			    padding: 0;
			    list-style: none;
			    color: #6c7885;
			    width: 250px;
			}
			#wr-promo-ab li {
			    line-height: 31px;
			    margin: 0 5px 10px;
			    text-align: left;
			    list-style: none;
			    background: none;
			    padding: 0;
			}
			#wr-promo-ab li span {
			    background: #6c7886;
			    float: left;
			    border-radius: 50%;
			    -o-border-radius: 50%;
			    -ms-border-radius: 50%;
			    -moz-border-radius: 50%;
			    -webkit-border-radius: 50%;
			    margin: 0 5px 0 0;
			}
			#wr-promo-ab li img {
			    margin: 8px;
			    float: left !important;
			}
			#wr-promo-ab .btn-premium {
			    margin: 0 0 78px 0;
			}
			#wr-promo-ab .btn-premium a {
				display: inline-block;
				margin: 0 10px;
				background: #418858;
				color: #fff;
				padding: 10px 5px;
				border-radius: 3px;
				-o-border-radius: 3px;
				-ms-border-radius: 3px;
				-moz-border-radius: 3px;
				-webkit-border-radius: 3px;
				font-size: 11px;
				box-shadow: 0 4px 0 0 #2a6d40;
				-o-box-shadow: 0 4px 0 0 #2a6d40;
				-ms-box-shadow: 0 4px 0 0 #2a6d40;
				-moz-box-shadow: 0 4px 0 0 #2a6d40;
				-webkit-box-shadow: 0 4px 0 0 #2a6d40;
				text-decoration: none;
				transition: all 0.3s;
				-o-transition: all 0.3s;
				-ms-transition: all 0.3s;
				-moz-transition: all 0.3s;
				-webkit-transition: all 0.3s;
			}
			#wr-promo-ab .btn-premium strong {
			    font-size: 18px;
			}
			#wr-promo-ab .btn-premium a:hover {
			    background: #2a6d40;
			    text-decoration:none;
			    box-shadow: 0 4px 0 0 #418858;
			    -o-box-shadow: 0 4px 0 0 #418858;
			    -ms-box-shadow: 0 4px 0 0 #418858;
			    -moz-box-shadow: 0 4px 0 0 #418858;
			    -webkit-box-shadow: 0 4px 0 0 #418858;
			}
			@media only screen and (max-width: 1200px) and (min-width: 768px), (max-device-width: 1200px) and (max-device-width: 768px) {
				#wr-promo-ab .btn-premium a {
					padding: 10px 0;
					margin: 0 10px;
				}
				#wr-promo-ab .btn-premium strong {
					font-size:16px;
				}
			}
        ';
		WR_CF_Init_Assets::inline( 'css', $style );

		$content = '<div id=\"wr-promo-ab\"><h3>Premium<br> WooCommerce Themes</h3><ul><li><span><img src=\"' . WR_CONTACTFORM_URI . 'assets/images/about-us/excellent-icon.png\"></span>Excellent designs</li><li><span><img src=\"' . WR_CONTACTFORM_URI . 'assets/images/about-us/unlimited-icon.png\"></span>Unlimited customization ability</li><li><span><img src=\"' . WR_CONTACTFORM_URI . 'assets/images/about-us/additional-icon.png\"></span>Additional eCommerce features</li></ul><p class=\"btn-premium\"><a href=\"http://www.woorockets.com/themes/?utm_source=ContactForm&utm_medium=Editor&utm_campaign=Cross%20Promo%20Banner\" target=\"_blank\"><strong>View the collection now</strong><br><span>And learn how our themes can boost your business!</span></a></p></div>';

		$script = '
			$("#side-sortables").append("' . $content . '");
		';
		WR_CF_Init_Assets::inline( 'js', $script );


	}

	public static function wr_contactform_remove_filter_date( $months, $post_type ) {
		return array();
	}

	/**
	 * Register custom post type for WR ContactForm Plugin.
	 *
	 * @return  void
	 */
	public static function register_post_type() {
		WR_CF_Init_Post_Type::add(
			array(
				'slug' => 'wr_cf_post_type',
				'options' => array(
					'labels' => array(
						'name' => __( 'Forms', WR_CONTACTFORM_TEXTDOMAIN ),
						'menu_name' => __( 'WR ContactForm', WR_CONTACTFORM_TEXTDOMAIN ),
						'edit_item' => __( 'Edit Form', WR_CONTACTFORM_TEXTDOMAIN ),
						'add_new_item' => __( 'Add New Form', WR_CONTACTFORM_TEXTDOMAIN ),
					),
					'supports' => array( 'title' ),
					'public' => true,
					'has_archive' => true,
					'menu_icon' => WR_CONTACTFORM_URI . 'assets/images/icons-16/icon-forms.png',
				),
				'meta_boxes' => array(
					array(
						'id' => 'wr_contactform_form_settings',
						'title' => __( 'Form Settings', WR_CONTACTFORM_TEXTDOMAIN ),
						'callback' => array( 'WR_Contactform_Form_Settings', 'print_form_settings_html' ),
						'save_post' => array( 'WR_Contactform_Form_Settings', 'wr_contactform_save_form' )
					),
				),
				'list_columns' => array(
					'title' => __( 'Title', WR_CONTACTFORM_TEXTDOMAIN ),
					'total_submissions' => __( 'Submissions', WR_CONTACTFORM_TEXTDOMAIN ),
					'form_short_code' => __( 'Short Code', WR_CONTACTFORM_TEXTDOMAIN ),
					'author' => __( 'Author', WR_CONTACTFORM_TEXTDOMAIN ),
					'date' => __( 'Date', WR_CONTACTFORM_TEXTDOMAIN )
				),
				'render_column' => array( 'WR_Contactform_Post_Type', 'render_form_column' ),
				'sortable_columns' => true,
				'main_feed' => true,

			)
		);
		WR_CF_Init_Post_Type::add(
			array(
				'slug' => 'wr_cfsb_post_type',
				'options' => array(
					'labels' => array(
						'name' => __( 'Submissions', WR_CONTACTFORM_TEXTDOMAIN ),
						'singular_name' => __( 'Submission Edit', WR_CONTACTFORM_TEXTDOMAIN ),
						'edit_item' => __( 'Submission Detail', WR_CONTACTFORM_TEXTDOMAIN ),
						'add_new_item' => __( 'Submission Detail', WR_CONTACTFORM_TEXTDOMAIN ),
					),
					'supports' => array( 'title' ),
					'public' => false,
					'has_archive' => false,
				),
				'meta_boxes' => array(
					array(
						'id' => 'wr_contactform_submission_detail',
						'title' => __( 'Submission Data', WR_CONTACTFORM_TEXTDOMAIN ),
						'callback' => array( 'WR_Contactform_Submission_Detail', 'print_submission_detail_html' ),
						'save_post' => array( 'WR_Contactform_Submission_Detail', 'wr_contactform_submission_save_form' )
					),
				),
				'list_columns' => self::get_submissions_column(),
				'render_column' => array( 'WR_Contactform_Post_Type', 'render_submissions_column' ),
				'sortable_columns' => true,
				'main_feed' => true,
			)
		);
		WR_CF_Init_Admin_Menu::remove( 'post-new.php?post_type=wr_cf_post_type', 'edit.php?post_type=wr_cf_post_type' );
		WR_CF_Init_Admin_Menu::remove( 'edit.php?post_type=wr_cf_post_type', 'edit.php?post_type=wr_cf_post_type' );

	}

	/**
	 * Render submissions page.
	 *
	 * @return  void
	 */
	public static function get_submissions_column() {
		$column = array();
		if ( ! empty( $_GET[ 'wr_contactform_form_id' ] ) ) {
			$_SESSION[ 'wr-contactform' ][ 'form_id' ] = $_GET[ 'wr_contactform_form_id' ];
		}
		$formID = ! empty( $_SESSION[ 'wr-contactform' ][ 'form_id' ] ) ? $_SESSION[ 'wr-contactform' ][ 'form_id' ] : '';
		if ( empty( $formID ) ) {
			$postslist = get_posts(
				array(
					'post_type' => 'wr_cf_post_type',
					'post_status' => 'any',
					'numberposts' => '99999',
				)
			);
			if ( ! empty( $postslist[ 0 ]->ID ) ) {
				$formID = $postslist[ 0 ]->ID;
				$_SESSION[ 'wr-contactform' ][ 'form_id' ] = $formID;
			}
		}
		$column[ 'date_created' ] = __( 'Date Submitted', WR_CONTACTFORM_TEXTDOMAIN );
		if ( ! empty( $formID ) ) {
			$fielForm = WR_Contactform_Helpers_Contactform::get_filed_by_form_id( $formID );
			if ( ! empty( $fielForm ) ) {
				foreach ( $fielForm as $field ) {
					if ( ! empty( $field->field_id ) && ! empty( $field->field_type ) && ! in_array(
						$field->field_type, array(
							'static-content',
							'google-maps',
						)
					)
					) {
						$column[ '_' . $field->field_id ] = ! empty( $field->field_title ) ? $field->field_title : '';
					}
				}
			}
		}
		$column[ 'ip' ] = __( 'IP Address', WR_CONTACTFORM_TEXTDOMAIN );
		$column[ 'browser' ] = __( 'Browser', WR_CONTACTFORM_TEXTDOMAIN );
		$column[ 'os' ] = __( 'Operating System', WR_CONTACTFORM_TEXTDOMAIN );
		return $column;
	}

	/**
	 * Submissions restrict manage data
	 */
	public static function submissions_restrict_manage_data() {
		$forms = get_posts(
			array(
				'post_type' => 'wr_cf_post_type',
				'post_status' => 'any',
				'numberposts' => '99999',
			)
		);
		if ( ! empty( $forms ) ) {
			$formID = ! empty( $_SESSION[ 'wr-contactform' ][ 'form_id' ] ) ? $_SESSION[ 'wr-contactform' ][ 'form_id' ] : '';
			if ( empty( $formID ) ) {
				$postslist = get_posts(
					array(
						'post_type' => 'wr_cf_post_type',
						'post_status' => 'any',
						'numberposts' => '99999',
					)
				);
				if ( ! empty( $postslist[ 0 ]->ID ) ) {
					$formID = $postslist[ 0 ]->ID;
					$_SESSION[ 'wr-contactform' ][ 'form_id' ] = $formID;
				}
			}
			echo '<select name="wr_contactform_form_id" id="dropdown_wr_form_id">';
			echo '<option value="-1">- Select Form -</option>';
			foreach ( $forms as $f ) {
				$fTitle = ! empty( $f->post_title ) ? $f->post_title : '(No Title)';
				$meta = get_post_meta( (int)$f->ID );
				if ( ! empty( $meta[ 'form_id' ][ 0 ] ) ) {
					$fID = (int)$meta[ 'form_id' ][ 0 ];
				}
				else {
					$fID = (int)$f->ID;
				}
				echo '<option value="' . esc_attr( $fID ) . '"';
				if ( isset( $formID ) ) selected( $fID, $formID );
				echo '>' . $fTitle . '</option>';
			}
			echo '</select>';
			$date = ! empty( $_GET[ 'filter_date' ] ) ? $_GET[ 'filter_date' ] : '';
			echo '
			<input type="text" readonly placeholder="' . __( '- Select Date -', WR_CONTACTFORM_TEXTDOMAIN ) . '" value="' . $date . '" name="filter_date" id="wr-submission-filter-date">
			<input type="submit" value="Clear" id="clear-submit" class="button" id="clear-submit" >
			';


		}
	}

	/**
	 *  Get query where
	 *
	 * @param string $where
	 *
	 * @return mixed|string
	 */
	public static function submissions_where( $where = '' ) {
		global $wpdb;
		//get Form id
		$formID = ! empty( $_SESSION[ 'wr-contactform' ][ 'form_id' ] ) ? $_SESSION[ 'wr-contactform' ][ 'form_id' ] : '';
		//check validation form id
		if ( ! empty( $formID ) && is_numeric( $formID ) ) {
			$where .= ' AND post_content = ' . (int)$formID;

			$dateSubmission = ! empty( $_GET[ 'filter_date' ] ) ? $_GET[ 'filter_date' ] : '';
			if ( ! empty( $dateSubmission ) ) {
				$dateSubmission = @explode( ' - ', $dateSubmission );
				$dateStart = @explode( '/', $dateSubmission[ 0 ] );
				$dateStart = @$dateStart[ 2 ] . '-' . @$dateStart[ 0 ] . '-' . @$dateStart[ 1 ];
				if ( @$dateSubmission[ 1 ] ) {
					$dateEnd = @explode( '/', $dateSubmission[ 1 ] );
					$dateEnd = @$dateEnd[ 2 ] . '-' . @$dateEnd[ 0 ] . '-' . @$dateEnd[ 1 ];
					$where = $wpdb->prepare( $where .= ' AND ( date(post_date) BETWEEN %s AND %s )', $dateStart, $dateEnd );
				}
				else {
					$where = $wpdb->prepare( $where .= ' AND date(submission_created_at) = %s ', $dateStart );
				}
			}
			if ( ! empty( $_GET[ 's' ] ) ) {
				//replace query where
				$where = preg_replace( '/AND \(\(\((.*?).post_title LIKE (.*?)\) OR \((.*?).post_content LIKE (.*?)\)\)\)/', '', $where );
				// query get list submission id
				$submissionData = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT submission_id FROM {$wpdb->prefix}wr_contactform_submission_data WHERE form_id = %d AND submission_data_value LIKE '%%%s%%' ORDER BY submission_data_id ASC", (int)$formID, $_GET[ 's' ]
					)
				);
				$listID = array();
				if ( ! empty( $submissionData ) ) {
					foreach ( $submissionData as $getID ) {
						$listID[ ] = $getID->submission_id;
					}
					if ( ! empty( $listID ) ) {
						$listID = array_unique( $listID );
						$where .= ' AND id IN (' . implode( ',', $listID ) . ')';
					}
				}
				else {
					$where .= ' AND 1=2';
				}
			}
		}
		return $where;
	}


	/**
	 * Action Hook delete form data
	 *
	 * @param $post_id
	 */
	public static function delete_form( $post_id ) {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wr_contactform_submission_data WHERE form_id = %d ', (int)$post_id ) );
		$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wr_contactform_fields WHERE form_id = %d ', (int)$post_id ) );
		$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wr_contactform_form_pages WHERE form_id = %d ', (int)$post_id ) );
	}

	/**
	 * Action Hook delete submission data
	 *
	 * @param $post_id
	 */
	public static function delete_submission( $post_id ) {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wr_contactform_submission_data WHERE submission_id = %d ', (int)$post_id ) );
	}

	/**
	 * Submission filter posts
	 *
	 * @param $query
	 */
	public static function filter_posts( $query ) {
		add_filter( 'posts_where', array( 'WR_Contactform_Helpers_Hook', 'submissions_where' ) );
	}

	/**
	 * Action View Forms
	 *
	 * @param $actions
	 * @param $page_object
	 *
	 * @return mixed
	 */
	public static function hook_action_view_forms( $actions, $post_object ) {
		$post_id = $post_object->ID;
		$meta = get_post_meta( (int)$post_id );
		if ( ! empty( $meta[ 'form_id' ][ 0 ] ) ) {
			$form_id = (int)$meta[ 'form_id' ][ 0 ];
		}
		else {
			$form_id = (int)$post_id;
		}
		$action = array();
		foreach ( $actions as $k => $v ) {
			$action[ $k ] = $v;
			if ( $k == 'edit' ) {
				$action[ 'duplicate' ] = '<a href="?wr-cf-gadget=contactform-duplicate&action=default&form_id=' . $post_object->ID . '">' . __( 'Duplicate' ) . '</a>';
				$action[ 'submissions' ] = '<a href="edit.php?post_status=all&post_type=wr_cfsb_post_type&action=-1&m=0&paged=1&mode=list&action2=-1&wr_contactform_form_id=' . $form_id . '">' . __( 'Submissions' ) . '</a>';
			}
		}
		return $action;
	}

	/**
	 *  Show date filters
	 */
	public static function wr_contactform_submissions_filters() {

	}
}
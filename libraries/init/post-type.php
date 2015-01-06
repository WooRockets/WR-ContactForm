<?php
/**
 * @version    $Id$
 * @package    WR_CONTACTFORM_Framework
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 * Technical Support:  Feedback - http://www.innothemes.com/contact-us/get-support.html
 */

/**
 * Custom post type initialization.
 *
 * @package  WR_CONTACTFORM_Framework
 * @since    1.0.0
 */
class WR_CF_Init_Post_Type {

	/**
	 * Array of custom post types to register.
	 *
	 * @var  array
	 */
	protected static $types = array();

	/**
	 * Register a custom post type with WordPress.
	 *
	 * Below is a sample use of this method:
	 *
	 * WR_CF_Init_Post_Type::add(
	 *     'slug' => 'sample_post_type',
	 *     'options' => array(
	 *         'labels' => array(
	 *             'name' => __( 'Sample Items', WR_PLGFW_TEXTDOMAIN ),
	 *             'singular_name' => __( 'Sample Item', WR_PLGFW_TEXTDOMAIN ),
	 *         ),
	 *         'public' => true,
	 *         'has_archive' => true
	 *     ),
	 *     'meta_boxes' => array(
	 *         array(
	 *             'id' => 'wr_contactform-item_url',
	 *             'title' => __( 'URL', WR_PLGFW_TEXTDOMAIN )
	 *         ),
	 *         array(
	 *             'id' => 'wr_contactform-item_referrer',
	 *             'title' => __( 'Referrer', WR_PLGFW_TEXTDOMAIN )
	 *         ),
	 *         array(
	 *             'id' => 'wr_contactform-item_host',
	 *             'title' => __( 'Host', WR_PLGFW_TEXTDOMAIN )
	 *         )
	 *     ),
	 *     'list_columns' => array(
	 *         'url'      => __( 'URL', WR_PLGFW_TEXTDOMAIN ),
	 *         'referrer' => __( 'Referrer', WR_PLGFW_TEXTDOMAIN ),
	 *         'host'     => __( 'Host', WR_PLGFW_TEXTDOMAIN )
	 *     ),
	 *     'render_column' => array( 'wr_contactform_Post_Type', 'render_column' ),
	 *     'sortable_columns' => true,
	 *     'main_feed' => true
	 * );
	 *
	 * @param   array  $type  Post type declaration.
	 *
	 * @return  void
	 */
	public static function add( $type ) {
		if ( isset( $type[ 'slug' ] ) ) {
			self::$types[ $type[ 'slug' ] ] = $type;
		}
		elseif ( isset( $type[ 0 ] ) && isset( $type[ 0 ][ 'slug' ] ) ) {
			foreach ( $type AS $declaration ) {
				if ( isset( $declaration[ 'slug' ] ) ) {
					self::$types[ $declaration[ 'slug' ] ] = $declaration;
				}
			}
		}
	}

	/**
	 * Hook into WordPress.
	 *
	 * @return  void
	 */
	public static function hook() {
		// Register action to add custom post type
		static $registered;

		if ( ! isset( $registered ) ) {
			add_action( 'wp_loaded', array( __CLASS__, 'wp_loaded' ) );

			$registered = true;
		}
	}

	public static function wp_loaded() {
		// Filter custom post types to be registered
		self::$types = apply_filters( 'wr_post_type_register', self::$types );

		foreach ( self::$types AS $slug => $type ) {
			// Register custom meta boxes with WordPress
			if ( isset( $type[ 'meta_boxes' ] ) ) {

				foreach ( $type[ 'meta_boxes' ] AS $meta_box ) {
					if ( ! isset( $meta_box[ 'id' ] ) ) {
						continue;
					}

					// Set post type
					if ( ! isset( $meta_box[ 'post_type' ] ) ) {
						$meta_box[ 'post_type' ] = $slug;
					}
					// Register custom meta box
					WR_CF_Init_Meta_Box::add( $meta_box );
				}
			}

			// Register custom post type with WordPress
			register_post_type( $slug, $type[ 'options' ] );

			// Setup columns to show in the listing page
			if ( isset( $type[ 'list_columns' ] ) ) {
				add_filter( "manage_{$slug}_posts_columns", array( __CLASS__, "list_columns_{$slug}" ) );
			}

			// Setup content retrieval for custom columns
			add_action( 'manage_posts_custom_column', array( __CLASS__, "render_column_{$slug}" ), 10, 2 );

			// Setup sortable for custom post type columns
			if ( isset( $type[ 'sortable_columns' ] ) && $type[ 'sortable_columns' ] ) {
				add_filter( "manage_edit-{$slug}_sortable_columns", array( __CLASS__, "sortable_columns_{$slug}" ) );
			}

			// Add custom post type to website's main feed
			if ( isset( $type[ 'main_feed' ] ) && $type[ 'main_feed' ] ) {
				add_filter( 'request', array( __CLASS__, "main_feed_{$slug}" ) );
			}
		}
	}

	/**
	 * Specify columns to show in the listing page.
	 *
	 * @param   string  $slug       Post type slug.
	 * @param   array   $cols       Current columns.
	 *
	 * @return  array
	 */
	public static function list_columns( $slug, $cols ) {
		if ( isset( self::$types[ $slug ] ) && isset( self::$types[ $slug ][ 'list_columns' ] ) ) {
			// Prepare columns
			if ( ! isset( self::$types[ $slug ][ 'list_columns' ][ 'cb' ] ) ) {
				self::$types[ $slug ][ 'list_columns' ] = array_merge( array( 'cb' => '<input type="checkbox" />' ), self::$types[ $slug ][ 'list_columns' ] );
			}

			$cols = self::$types[ $slug ][ 'list_columns' ];
		}
		return $cols;
	}

	/**
	 * Render a custom column in the listing page.
	 *
	 * @param   string  $slug     Post type slug.
	 * @param   array   $column   Column name.
	 * @param   array   $post_id  Post id.
	 *
	 * @return  void
	 */
	public static function render_column( $slug, $column, $post_id ) {
		$html = '';
		if ( isset( self::$types[ $slug ] ) && isset( self::$types[ $slug ][ 'render_column' ] ) ) {
			$html = call_user_func_array( self::$types[ $slug ][ 'render_column' ], array( $column, $post_id ) );
		}
		else {
			// Get data to show
			$html = get_post_meta( $post_id, $column, true );
		}
		_e( $html, WR_CONTACTFORM_TEXTDOMAIN );
	}

	/**
	 * Setup sortable for custom post type columns.
	 *
	 * @param   string  $slug  Post type slug.
	 *
	 * @return  array
	 */
	public static function sortable_columns( $slug ) {
		$sortable = array();

		if ( isset( self::$types[ $slug ] ) ) {
			if ( @is_array( self::$types[ $slug ][ 'sortable_columns' ] ) ) {
				$sortable = self::$types[ $slug ][ 'sortable_columns' ];
			}
			elseif ( self::$types[ $slug ][ 'sortable_columns' ] && isset( self::$types[ $slug ][ 'list_columns' ] ) ) {
				$listSort = array_combine( array_keys( self::$types[ $slug ][ 'list_columns' ] ), array_keys( self::$types[ $slug ][ 'list_columns' ] ) );
				foreach ( $listSort as $key => $val ) {
					if ( ! in_array( $key, array( 'cb' ) ) ) {
						$sortable [ $key ] = $val;
					}
				}
			}
		}

		return $sortable;
	}

	/**
	 * Add a custom post type to website's main feed.
	 *
	 * @param   string  $slug     Post type slug.
	 * @param   array   $request  Query variables that are passed to the default main SQL query that retrieve page content.
	 *
	 * @return  array
	 */
	public static function main_feed( $slug, $request ) {
		if ( isset( self::$types[ $slug ] ) && isset( $request[ 'feed' ] ) && ! isset( $request[ 'post_type' ] ) ) {
			$request[ 'post_type' ] = array( 'post', $slug );
		}
		return $request;
	}

	/**
	 * Setup registered custom post types.
	 *
	 * @return  void
	 */
	/**
	 * Handle custom post type manipulation.
	 *
	 * @param   string  $name  Name of function to be called.
	 * @param   array   $args  Arguments to be passed.
	 *
	 * @return  mixed
	 */
	public static function __callStatic( $name, $args ) {
		if ( preg_match( '/^(list_columns|render_column|sortable_columns|main_feed)_([^\s]+)$/', $name, $match ) ) {
			// Update arguments
			array_unshift( $args, $match[ 2 ] );
			return call_user_func_array( array( __CLASS__, $match[ 1 ] ), $args );
		}
	}
}

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
 * Custom meta box initialization.
 *
 * @package  WR_CONTACTFORM_Framework
 * @since    1.0.0
 */
class WR_CF_Init_Meta_Box {
	/**
	 * Array of custom meta boxes to register.
	 *
	 * @var  array
	 */
	protected static $boxes = array();

	/**
	 * Register a custom meta box with WordPress.
	 *
	 * Below is a sample use of this method:
	 *
	 * WR_CF_Init_Meta_Box::add(
	 *     array(
	 *         'id' => 'sample_meta_box',
	 *         'title' => 'Sample Meta Box',
	 *         'callback' => array( 'wr_contactform_Meta_Box', 'render_meta_box' ),
	 *         'post_type' => 'sample_post_type',
	 *         'save_post' => array( 'wr_contactform_Meta_Box', 'save_meta_box_data' )
	 *     )
	 * );
	 *
	 * @param   array  $box  Meta box declaration.
	 *
	 * @return  void
	 */
	public static function add( $box ) {
		if ( isset( $box['id'] ) ) {
			self::$boxes[ $box['id'] ] = $box;

			// Register action to save meta box data
			add_action( 'save_post', array( __CLASS__, "save_post_{$box['id']}" ) );
		} elseif ( isset( $box[0] ) && isset( $box[0]['id'] ) ) {
			foreach ( $box AS $declaration ) {
				if ( isset( $declaration['id'] ) ) {
					self::$boxes[ $declaration['id'] ] = $declaration;

					// Register action to save meta box data
					add_action( 'save_post', array( __CLASS__, "save_post_{$declaration['id']}" ) );
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
		// Register action to add custom meta box
		static $registered;

		if ( ! isset( $registered ) ) {
			add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );

			$registered = true;
		}
	}

	/**
	 * Setup registered custom meta boxes.
	 *
	 * @return  void
	 */
	public static function add_meta_boxes() {
		// Filter custom meta boxes to be registered
		self::$boxes = apply_filters( 'wr_meta_box_register', self::$boxes );

		foreach ( self::$boxes AS $id => $box ) {
			// Build required arguments
			$args = array( $id, $box['title'], array( __CLASS__, "print_html_{$id}" ), $box['post_type'] );

			// Build optional arguments
			foreach ( array( 'context', 'priority', 'callback_args' ) AS $arg ) {
				if ( isset( $box[ $arg ] ) ) {
					$args[] = $box[ $arg ];
				}
			}

			// Register meta box
			if ( is_array( $box['post_type'] ) ) {
				foreach ( $box['post_type'] AS $post_type ) {
					// Set post type
					$args[3] = $post_type;

					call_user_func_array( 'add_meta_box', $args );
				}
			} else {
				call_user_func_array( 'add_meta_box', $args );
			}
		}
	}

	/**
	 * Render custom meta box.
	 *
	 * @param   string   $id    Meta box id.
	 * @param   WP_Post  $post  The object for the current post/page.
	 *
	 * @return  void
	 */
	public static function print_html( $id, $post ) {
		$html = '';

		if ( isset( self::$boxes[ $id ] ) ) {
			// Add an nonce field so we can check for it later
			wp_nonce_field( "wr_meta_box_{$id}", "wr_meta_box_{$id}_nonce" );

			if ( isset( self::$boxes[ $id ]['callback'] ) && ! empty( self::$boxes[ $id ]['callback'] ) ) {
				$html = call_user_func_array( self::$boxes[ $id ]['callback'], array( $post ) );
			} else {
				// Get current value
				$value = get_post_meta( $post->ID, $id, true );

				// Render a field to input plain text
				$html = '<input type="text" id="wr_meta_box_' . $id . '" name="wr_meta_box[' . $id . ']" value="' . esc_attr( $value ) . '" />';
			}
		}

		_e( $html, WR_CONTACTFORM_TEXTDOMAIN );
	}

	/**
	 * Save custom meta box data.
	 *
	 * @param   string   $id       Meta box id.
	 * @param   integer  $post_id  Post id.
	 *
	 * @return  void
	 */
	public static function save_post( $id, $post_id ) {

		if ( isset( self::$boxes[ $id ] ) ) {
			// Check if nonce data is set
			if ( ! isset( $_POST["wr_meta_box_{$id}_nonce"] ) ) {
				return;
			}

			// Verify nonce data
			if ( ! wp_verify_nonce( $_POST["wr_meta_box_{$id}_nonce"], "wr_meta_box_{$id}" ) ) {
				return;
			}

			// If this is an autosave action, our form has not been submitted, so we don't want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// Check the user's permissions
			if ( 'page' == $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return;
				}
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}

			// Get meta box data
			if ( isset( self::$boxes[ $id ]['save_post'] ) && ! empty( self::$boxes[ $id ]['save_post'] ) ) {
				$data = call_user_func_array( self::$boxes[ $id ]['save_post'], array( $post_id ) );
			} else {
				// Sanitize meta box data
				$data = sanitize_text_field( $_POST['wr_meta_box'][ $id ] );
			}

			// Update meta field in database
			if ( false !== $data ) {
				update_post_meta( $post_id, $id, $data );
			}
		}
	}

	/**
	 * Handle custom meta box manipulation.
	 *
	 * @param   string  $name  Name of function to be called.
	 * @param   array   $args  Arguments to be passed.
	 *
	 * @return  mixed
	 */
	public static function __callStatic( $name, $args ) {
		if ( preg_match( '/^(print_html|save_post)_([^\s]+)$/', $name, $match ) ) {
			// Update arguments
			array_unshift( $args, $match[2] );

			return call_user_func_array( array( __CLASS__, $match[1] ), $args );
		}
	}
}

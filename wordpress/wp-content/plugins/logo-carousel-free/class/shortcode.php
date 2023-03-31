<?php
/**
 * This is to register the shortcode post type.
 *
 * @package logo-carousel-free
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * SPLC Shortcode
 */
class SPLC_Shortcode {

	/**
	 * Single instance of the class.
	 *
	 * @var  SPLC_Shortcode single instance of the class
	 */
	private static $_instance;

	/**
	 * SPLC_Shortcode constructor.
	 */
	public function __construct() {
		add_filter( 'init', array( $this, 'register_post_type' ) );
		add_filter( 'post_updated_messages', array( $this, 'lc_update_notice' ) );

	}

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @return SPLC_Shortcode
	 */
	public static function getInstance() {
		if ( ! self::$_instance ) {
			self::$_instance = new SPLC_Shortcode();
		}
		return self::$_instance;
	}

	/**
	 * Shortcode Post Type
	 */
	public function register_post_type() {
		$capability = apply_filters( 'sp_lc_ui_permission', 'manage_options' );
		$show_ui    = current_user_can( $capability ) ? true : false;
		register_post_type(
			'sp_lc_shortcodes',
			array(
				'label'           => __( 'Logo Carousel Shortcode', 'logo-carousel-free' ),
				'description'     => __( 'Generate Shortcode for Logo Carousel', 'logo-carousel-free' ),
				'public'          => false,
				'show_ui'         => $show_ui,
				'show_in_menu'    => 'edit.php?post_type=sp_logo_carousel',
				'hierarchical'    => false,
				'query_var'       => false,
				'supports'        => array( 'title' ),
				'capability_type' => 'post',
				'labels'          => array(
					'name'               => __( 'All Logo Carousels', 'logo-carousel-free' ),
					'singular_name'      => __( 'Logo Carousel', 'logo-carousel-free' ),
					'menu_name'          => __( 'Shortcode Generator', 'logo-carousel-free' ),
					'add_new'            => __( 'Add New', 'logo-carousel-free' ),
					'add_new_item'       => __( 'Add New Carousel', 'logo-carousel-free' ),
					'edit'               => __( 'Edit', 'logo-carousel-free' ),
					'edit_item'          => __( 'Edit Carousel', 'logo-carousel-free' ),
					'new_item'           => __( 'New Carousel', 'logo-carousel-free' ),
					'view'               => __( 'View Shortcode', 'logo-carousel-free' ),
					'view_item'          => __( 'View Shortcode', 'logo-carousel-free' ),
					'search_items'       => __( 'Search Carousel', 'logo-carousel-free' ),
					'not_found'          => __( 'No Logo Carousel Found', 'logo-carousel-free' ),
					'not_found_in_trash' => __( 'No Logo Carousel Found in Trash', 'logo-carousel-free' ),
					'parent'             => __( 'Parent Logo Carousel', 'logo-carousel-free' ),
				),
			)
		);
	}

	/**
	 * Logo carousel publish and update notice show function.
	 *
	 * @param array $messages show updated and published notice.
	 * @return array
	 */
	public function lc_update_notice( $messages ) {
		$screen = get_current_screen();
		if ( 'sp_lc_shortcodes' === $screen->post_type ) {
			$messages['sp_lc_shortcodes'][1] = __( 'Shortcode updated.', 'logo-carousel-free' );
			$messages['sp_lc_shortcodes'][6] = __( 'Shortcode published.', 'logo-carousel-free' );
		} elseif ( 'sp_logo_carousel' === $screen->post_type ) {
			$messages['sp_logo_carousel'][1] = __( 'Logo updated.', 'logo-carousel-free' );
			$messages['sp_logo_carousel'][6] = __( 'Logo published.', 'logo-carousel-free' );
		}

		return $messages;
	}

}

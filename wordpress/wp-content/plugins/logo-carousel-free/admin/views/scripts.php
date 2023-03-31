<?php
/**
 * Scripts and styles
 *
 * @package logo-carousel-free
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access

/**
 * Scripts and styles
 */
class SP_LC_Admin_Scripts {

	/**
	 * Single instance of the class
	 *
	 * @var null
	 * @since 1.0
	 */
	protected static $_instance = null;

	/**
	 * Instance
	 *
	 * @return SP_LC_Admin_Scripts
	 * @since 1.0
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Initialize the class
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}
	/**
	 * Enqueue all admin scripts
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_style( 'splc-admin-style', SP_LC_URL . 'admin/assets/css/admin.min.css', false, SP_LC_VERSION );
	}
}

new SP_LC_Admin_Scripts();

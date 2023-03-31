<?php
/**
 * Logo Carousel - route.
 *
 * @package logo-carousel-free
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Logo Carousel - route class
 *
 * @since 3.0
 */
class SPLC_Router {

	/**
	 * Single instance of the class.
	 *
	 * @var SPLC_Router single instance of the class
	 *
	 * @since 3.0
	 */
	protected static $_instance = null;


	/**
	 * Main SPLC Instance
	 *
	 * @since 3.0
	 * @static
	 * @return self Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Include the required files
	 *
	 * @since 3.0
	 * @return void
	 */
	public function includes() {
		include_once SP_LC_PATH . '/includes/free/loader.php';
	}

	/**
	 * SPLC function
	 *
	 * @since 3.0
	 * @return void
	 */
	public function splc_function() {
		include_once SP_LC_PATH . '/includes/functions.php';
	}

	/**
	 * Splc_metabox
	 *
	 * @return void
	 */
	public function splc_metabox() {
		include_once SP_LC_PATH . '/admin/views/sp-framework/classes/setup.class.php';
		include_once SP_LC_PATH . '/admin/views/sp-framework/config/settings.config.php';
		include_once SP_LC_PATH . '/admin/views/sp-framework/config/tools.config.php';
		include_once SP_LC_PATH . '/admin/views/sp-framework/config/metabox.config.php';

	}
}

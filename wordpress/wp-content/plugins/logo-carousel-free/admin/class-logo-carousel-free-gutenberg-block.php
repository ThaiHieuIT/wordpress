<?php
/**
 * The plugin gutenberg block.
 *
 * @link       https://shapedplugin.com/
 * @since      3.4.6
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/Admin
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Logo_Carousel_Free_Gutenberg_Block' ) ) {

	/**
	 * Custom Gutenberg Block.
	 */
	class Logo_Carousel_Free_Gutenberg_Block {

		/**
		 * Block Initializer.
		 */
		public function __construct() {
			require_once SP_LC_PATH . 'admin/GutenbergBlock/class-logo-carousel-free-gutenberg-block-init.php';
			new Logo_Carousel_Free_Gutenberg_Block_Init();
		}

	}
}

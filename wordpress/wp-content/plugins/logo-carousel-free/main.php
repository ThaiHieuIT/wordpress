<?php
/**
 * Plugin Name:       Logo Carousel
 * Plugin URI:        https://logocarousel.com/?ref=1
 * Description:       Display and highlight your clients, partners, supporters, and sponsors logos on your WordPress site in a nice logo carousel. Easy Shortcode Generator | Highly Customizable | No Coding Knowledge Required!
 * Version:           3.4.19
 * Author:            ShapedPlugin, LLC
 * Author URI:        https://shapedplugin.com
 * Text Domain:       logo-carousel-free
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 *
 * @package logo-carousel-free
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The code that runs during plugin updates.
 * This action is documented in includes/class-logo-carousel-free-updates.php
 */
require_once ABSPATH . 'wp-admin/includes/plugin.php';
if ( ! ( is_plugin_active( 'logo-carousel-pro/logo-carousel-pro.php' ) || is_plugin_active_for_network( 'logo-carousel-pro/logo-carousel-pro.php' ) ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-logo-carousel-free-updates.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/views/notices/review.php';
}

if ( ! class_exists( 'SP_Logo_Carousel' ) ) {
	/**
	 * Handles core plugin hooks and action setup.
	 *
	 * @package logo-carousel-free
	 * @since 3.0
	 */
	class SP_Logo_Carousel {
		/**
		 * Plugin name
		 *
		 * @var string
		 */
		public $plugin_name = 'logo-carousel-free';

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		public $version = '3.4.19';

		/**
		 * Single instance of the class
		 *
		 * @var mixed
		 */
		protected static $_instance = null;

		/**
		 * Logo
		 *
		 * @var mixed
		 */
		public $logo;

		/**
		 * Router
		 *
		 * @var mixed
		 */
		public $router;

		/**
		 * Shortcode
		 *
		 * @var mixed
		 */
		public $shortcode;

		/**
		 * Main SPLC Instance
		 *
		 * @since 3.0
		 * @static
		 * @see wpl_lc()
		 * @return self Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Constructor for the SP_Logo_Carousel class
		 */
		public function __construct() {
			// Define constants.
			$this->define_constants();

			// Required class file include.
			spl_autoload_register( array( $this, 'autoload' ) );

			// Include required files.
			$this->includes();

			// instantiate classes.
			$this->instantiate();

			// Initialize the filter hooks.
			$this->init_filters();

			// Initialize the action hooks.
			$this->init_actions();
		}

		/**
		 *  Flush rewrite rules
		 *
		 * @return void
		 */
		public function sp_lc_flush_rewrites() {
			// call your CPT registration function here (it should also be hooked into 'init').
			$this->logo->register_post_type();
			flush_rewrite_rules();
		}

		/**
		 * Initialize WordPress filter hooks
		 *
		 * @return void
		 */
		private function init_filters() {
			add_filter( 'plugin_action_links_' . SP_LC_BASENAME, array( $this, 'add_plugin_action_links' ), 10, 2 );
			add_filter( 'plugin_row_meta', array( $this, 'after_logo_carousel_row_meta' ), 10, 4 );
			add_filter( 'manage_sp_lc_shortcodes_posts_columns', array( $this, 'add_shortcode_column' ) );
		}

		/**
		 * Initialize WordPress action hooks
		 *
		 * @return void
		 */
		private function init_actions() {
			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
			add_action( 'wp_loaded', array( $this, 'register_all_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'public_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_live_preview_scripts' ) );
			add_action( 'manage_sp_lc_shortcodes_posts_custom_column', array( $this, 'add_shortcode_form' ), 10, 2 );
			add_action( 'activated_plugin', array( $this, 'redirect_help_page' ) );
			add_action( 'save_post', array( $this, 'delete_page_lcp_option_on_save' ) );

			$import_export = new Logo_Carousel_Import_Export( SP_LC_ITEM_SLUG, SP_LC_VERSION );

			add_action( 'wp_ajax_lcp_export_shortcodes', array( $import_export, 'export_shortcodes' ) );
			add_action( 'wp_ajax_lcp_import_shortcodes', array( $import_export, 'import_shortcodes' ) );

			// Gutenberg Block.
			if ( version_compare( $GLOBALS['wp_version'], '5.3', '>=' ) ) {
				require_once SP_LC_PATH . 'admin/class-logo-carousel-free-gutenberg-block.php';
				new Logo_Carousel_Free_Gutenberg_Block();
			}

			// Elementor Addons.
			require_once SP_LC_PATH . 'admin/Logo_Carousel_Free_Element_Shortcode_Block.php';
			require_once SP_LC_PATH . 'admin/Logo_Carousel_Free_Element_Shortcode_Block_Deprecated.php';
			new Logo_Carousel_Free_Element_Shortcode_Block();
			new Logo_Carousel_Free_Element_Shortcode_Block_Deprecated();
		}

		/**
		 * Define constants.
		 *
		 * @since 3.0
		 */
		public function define_constants() {
			define( 'SP_LC_ITEM_SLUG', $this->plugin_name );
			define( 'SP_LC_VERSION', $this->version );
			define( 'SP_LC_PATH', plugin_dir_path( __FILE__ ) );
			define( 'SP_LC_URL', plugin_dir_url( __FILE__ ) );
			define( 'SP_LC_BASENAME', plugin_basename( __FILE__ ) );
		}

		/**
		 * Plugin Scripts and Styles
		 */
		public function public_scripts() {
			// Stylesheet loading problem solving here. Shortcode id to push page id option for getting how many shortcode in the page.
			require_once SP_LC_PATH . 'public/views/shortcoderender.php';
			$get_page_data      = SPLC_Shortcode_Render::get_page_data();
			$found_generator_id = $get_page_data['generator_id'];
			if ( $found_generator_id ) {
				wp_enqueue_style( 'sp-lc-swiper' );
				wp_enqueue_style( 'sp-lc-font-awesome' );
				wp_enqueue_style( 'sp-lc-style' );
				$dynamic_style = SPLC_Shortcode_Render::load_dynamic_style( $found_generator_id, '' );
				wp_add_inline_style( 'sp-lc-style', $dynamic_style['dynamic_css'] );
			}
		}

		/**
		 * Live Preview Scripts and Styles
		 */
		public function admin_live_preview_scripts() {
			$current_screen        = get_current_screen();
			$the_current_post_type = $current_screen->post_type;
			if ( 'sp_lc_shortcodes' === $the_current_post_type ) {
				wp_enqueue_style( 'sp-lc-swiper' );
				wp_enqueue_style( 'sp-lc-font-awesome' );
				wp_enqueue_style( 'sp-lc-style' );
				wp_enqueue_script( 'sp-lc-swiper-js' );
			}
		}

		/**
		 * Delete page shortcode ids array option on save
		 *
		 * @param  int $post_ID current post id.
		 * @return void
		 */
		public function delete_page_lcp_option_on_save( $post_ID ) {
			if ( is_multisite() ) {
				$option_key = 'sp_lcp_page_id' . get_current_blog_id() . $post_ID;
				if ( get_site_option( $option_key ) ) {
					delete_site_option( $option_key );
				}
			} else {
				if ( get_option( 'sp_lcp_page_id' . $post_ID ) ) {
					delete_option( 'sp_lcp_page_id' . $post_ID );
				}
			}
		}
		/**
		 * Register the all scripts of the plugin.
		 *
		 * @since    2.0
		 */
		public function register_all_scripts() {
			$setting_data     = get_option( '_sp_lcpro_options' );
			$lcpro_swiper_css = isset( $setting_data['lcpro_swiper_css'] ) ? $setting_data['lcpro_swiper_css'] : true;
			$font_awesome_css = isset( $setting_data['lcpro_fontawesome_css'] ) ? $setting_data['lcpro_fontawesome_css'] : true;
			$lcpro_swiper_js  = isset( $setting_data['lcpro_swiper_js'] ) ? $setting_data['lcpro_swiper_js'] : true;

			if ( $lcpro_swiper_css ) {
				wp_register_style( 'sp-lc-swiper', SP_LC_URL . 'public/assets/css/swiper-bundle.min.css', array(), SP_LC_VERSION );
			}
			if ( $font_awesome_css ) {
				wp_register_style( 'sp-lc-font-awesome', SP_LC_URL . 'public/assets/css/font-awesome.min.css', array(), SP_LC_VERSION );
			}
			wp_register_style( 'sp-lc-style', SP_LC_URL . 'public/assets/css/style.min.css', array(), SP_LC_VERSION );

			if ( $lcpro_swiper_js ) {
				wp_register_script( 'sp-lc-swiper-js', SP_LC_URL . 'public/assets/js/swiper-bundle.min.js', array( 'jquery' ), SP_LC_VERSION, true );
			}
			wp_register_script( 'sp-lc-script', SP_LC_URL . 'public/assets/js/splc-script.min.js', array( 'jquery' ), SP_LC_VERSION, true );
		}


		/**
		 * Load textdomain for plugin.
		 *
		 * @since 3.0
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain(
				'logo-carousel-free',
				false,
				dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
			);
		}

		/**
		 * Add plugin action menu
		 *
		 * @since 3.0
		 *
		 * @param array  $links links.
		 * @param string $file file.
		 *
		 * @return array
		 */
		public function add_plugin_action_links( $links, $file ) {

			if ( SP_LC_BASENAME === $file ) {
				$ui_links = sprintf( '<a href="%s">%s</a>', admin_url( 'post-new.php?post_type=sp_lc_shortcodes' ), __( 'Add New', 'logo-carousel-free' ) );

				array_unshift( $links, $ui_links );

				$links['go_pro'] = sprintf( '<a href="%s" style="%s">%s</a>', 'https://logocarousel.com/pricing/?ref=1', 'color:#1dab87;font-weight:bold', __( 'Go Pro!', 'logo-carousel-free' ) );
			}

			return $links;
		}

		/**
		 * Add plugin row meta link.
		 *
		 * @since 3.0
		 *
		 * @param array  $plugin_meta plugin meta.
		 * @param string $file Base file.
		 *
		 * @return array
		 */
		public function after_logo_carousel_row_meta( $plugin_meta, $file ) {
			if ( SP_LC_BASENAME === $file ) {
				$plugin_meta[] = '<a href="https://logocarousel.com/logo-carousel-lite-version-demos/" target="_blank">' . __( 'Live Demo', 'logo-carousel-free' ) . '</a>';
			}
			return $plugin_meta;
		}

		/**
		 * Autoload class files on demand
		 *
		 * @param string $class requested class name.
		 */
		public function autoload( $class ) {
			$name = explode( '_', $class );
			if ( isset( $name[1] ) ) {
				$class_name = strtolower( $name[1] );
				$filename   = SP_LC_PATH . '/class/' . $class_name . '.php';

				if ( file_exists( $filename ) ) {
					require_once $filename;
				}
			}
		}

		/**
		 * Instantiate all the required classes
		 *
		 * @since 3.0
		 */
		private function instantiate() {

			$this->logo      = SPLC_Logo::getInstance();
			$this->shortcode = SPLC_Shortcode::getInstance();

			do_action( 'splc_instantiate', $this );
		}

		/**
		 * Page router instantiate
		 *
		 * @since 3.0
		 */
		public function page() {
			$this->router = SPLC_Router::instance();

			return $this->router;
		}

		/**
		 * Include the required files
		 *
		 * @return void
		 */
		public function includes() {
			$this->page()->splc_function();
			$this->page()->splc_metabox();
			$this->router->includes();
			require_once SP_LC_PATH . 'includes/class-logo-carousel-import-export.php';

		}

		/**
		 * ShortCode Column
		 *
		 * @return mixed
		 */
		public function add_shortcode_column() {
			$new_columns['cb']        = '<input type="checkbox" />';
			$new_columns['title']     = __( 'Carousel Title', 'logo-carousel-free' );
			$new_columns['shortcode'] = __( 'Shortcode', 'logo-carousel-free' );
			$new_columns['']          = '';
			$new_columns['date']      = __( 'Date', 'logo-carousel-free' );

			return $new_columns;
		}


		/**
		 * Add shortcode form
		 *
		 * @param  mixed $column column.
		 * @param  mixed $post_id id.
		 * @return void
		 */
		public function add_shortcode_form( $column, $post_id ) {

			switch ( $column ) {

				case 'shortcode':
					echo '<div class="lc-after-copy-text"><i class="fa fa-check-circle"></i> ' . esc_html__( 'Shortcode Copied to Clipboard! ', 'logo-carousel-free' ) . '</div><input class="lc_input_shortcode"  style="width: 210px;padding: 6px; cursor:pointer;" type="text" onClick="this.select();" readonly="readonly" value="[logocarousel id=&quot;' . esc_attr( $post_id ) . '&quot;]"/>';
					break;
				default:
					break;

			} // end switch

		}

		/**
		 * Redirect after active
		 *
		 * @param string $plugin plugin.
		 */
		public function redirect_help_page( $plugin ) {
			if ( SP_LC_BASENAME === $plugin ) {
				wp_safe_redirect( admin_url( 'edit.php?post_type=sp_logo_carousel&page=lc_help' ) );
				exit;
			}
		}

	}
}

/**
 * Returns the main instance.
 *
 * @since 3.0
 * @return SP_Logo_Carousel
 */
function sp_logo_carousel() {
	return SP_Logo_Carousel::instance();
}

if ( ! ( is_plugin_active( 'logo-carousel-pro/logo-carousel-pro.php' ) || is_plugin_active_for_network( 'logo-carousel-pro/logo-carousel-pro.php' ) ) ) {
	// sp_logo_carousel instance.
	$cpm = sp_logo_carousel();
}

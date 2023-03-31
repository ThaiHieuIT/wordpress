<?php
/**
 * Metabox Class
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.


if ( ! class_exists( 'SPLC' ) ) {
	/**
	 *
	 * Setup Class
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPLC {


		// Default constants.
		/**
		 * Version
		 *
		 * @var string
		 */
		public static $version = SP_LC_VERSION;

		/**
		 * Dir
		 *
		 * @var string
		 */
		public static $dir = '';

		/**
		 * Url
		 *
		 * @var string
		 */
		public static $url = '';

		/**
		 * File
		 *
		 * @var string
		 */
		public static $file = '';

		/**
		 * Enqueue
		 *
		 * @var bool
		 */
		public static $enqueue = false;

		/**
		 * Webfonts
		 *
		 * @var array
		 */
		public static $webfonts = array();
		/**
		 * Subsets
		 *
		 * @var array
		 */
		public static $subsets = array();
		/**
		 * Inited
		 *
		 * @var array
		 */
		public static $inited = array();
		/**
		 * Fields
		 *
		 * @var array
		 */
		public static $fields = array();
		/**
		 * Args
		 *
		 * @var array
		 */
		public static $args = array(
			'admin_options'   => array(),
			'metabox_options' => array(),
		);

		/**
		 * Shortcode instances.
		 *
		 * @var array
		 */
		public static $shortcode_instances = array();

		/**
		 * Instances.
		 *
		 * @var array
		 */
		private static $instance = null;

		/**
		 * Init
		 *
		 * @param  string $file fill.
		 * @return resource
		 */
		public static function init( $file = __FILE__ ) {

			// Set file constant.
			self::$file = $file;

			// Set constants.
			self::constants();

			// Include files.
			self::includes();

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Initialize.
		 *
		 * @return void
		 */
		public function __construct() {
			// Init action.
			do_action( 'splogocarousel_init' );

			add_action( 'after_setup_theme', array( 'SPLC', 'setup' ) );
			add_action( 'init', array( 'SPLC', 'setup' ) );
			add_action( 'switch_theme', array( 'SPLC', 'setup' ) );
			add_action( 'admin_enqueue_scripts', array( 'SPLC', 'add_admin_enqueue_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( 'SPLC', 'add_typography_enqueue_styles' ), 80 );
		}

		/**
		 * Setup frameworks.
		 *
		 * @return void
		 */
		public static function setup() {
			// Setup admin option framework.
			$params = array();
			if ( class_exists( 'SPLC_FREE_Options' ) && ! empty( self::$args['admin_options'] ) ) {
				foreach ( self::$args['admin_options'] as $key => $value ) {
					if ( ! empty( self::$args['sections'][ $key ] ) && ! isset( self::$inited[ $key ] ) ) {

						$params['args']       = $value;
						$params['sections']   = self::$args['sections'][ $key ];
						self::$inited[ $key ] = true;

						SPLC_FREE_Options::instance( $key, $params );

						if ( ! empty( $value['show_in_customizer'] ) ) {
							$value['output_css']                     = false;
							$value['enqueue_webfont']                = false;
							self::$args['customize_options'][ $key ] = $value;
							self::$inited[ $key ]                    = null;
						}
					}
				}
			}

			// Setup metabox option framework.
			$params = array();
			if ( class_exists( 'SPLC_FREE_Metabox' ) && ! empty( self::$args['metabox_options'] ) ) {
				foreach ( self::$args['metabox_options'] as $key => $value ) {
					if ( ! empty( self::$args['sections'][ $key ] ) && ! isset( self::$inited[ $key ] ) ) {

						$params['args']       = $value;
						$params['sections']   = self::$args['sections'][ $key ];
						self::$inited[ $key ] = true;

						SPLC_FREE_Metabox::instance( $key, $params );
					}
				}
			}

			do_action( 'splogocarousel_loaded' );
		}

		/**
		 * Create options.
		 *
		 * @param  int   $id id.
		 * @param  array $args array.
		 * @return void
		 */
		public static function createOptions( $id, $args = array() ) {
			self::$args['admin_options'][ $id ] = $args;
		}


		/**
		 * Create metabox options
		 *
		 * @param  int   $id id.
		 * @param  array $args args.
		 * @return void
		 */
		public static function createMetabox( $id, $args = array() ) {
			self::$args['metabox_options'][ $id ] = $args;
		}

		/**
		 * Create section
		 *
		 * @param  int   $id  id.
		 * @param  array $sections sections.
		 * @return void
		 */
		public static function createSection( $id, $sections ) {
			self::$args['sections'][ $id ][] = $sections;
			self::set_used_fields( $sections );
		}

		/**
		 * Set directory constants.
		 *
		 * @return void
		 */
		public static function constants() {
			// We need this path-finder code for set URL of framework.
			$dirname        = str_replace( '//', '/', wp_normalize_path( dirname( dirname( self::$file ) ) ) );
			$theme_dir      = str_replace( '//', '/', wp_normalize_path( get_parent_theme_file_path() ) );
			$plugin_dir     = str_replace( '//', '/', wp_normalize_path( WP_PLUGIN_DIR ) );
			$located_plugin = ( preg_match( '#' . self::sanitize_dirname( $plugin_dir ) . '#', self::sanitize_dirname( $dirname ) ) ) ? true : false;
			$directory      = ( $located_plugin ) ? $plugin_dir : $theme_dir;
			$directory_uri  = ( $located_plugin ) ? WP_PLUGIN_URL : get_parent_theme_file_uri();
			$foldername     = str_replace( $directory, '', $dirname );
			$protocol_uri   = ( is_ssl() ) ? 'https' : 'http';
			$directory_uri  = set_url_scheme( $directory_uri, $protocol_uri );

			self::$dir = $dirname;
			self::$url = $directory_uri . $foldername;
		}

		/**
		 * Include file helper.
		 *
		 * @param  string $file file.
		 * @param  string $load load.
		 * @return string
		 */
		public static function include_plugin_file( $file, $load = true ) {
			$path     = '';
			$file     = ltrim( $file, '/' );
			$override = apply_filters( 'splogocarousel_override', 'splogocarousel-override' );

			if ( file_exists( get_parent_theme_file_path( $override . '/' . $file ) ) ) {
				$path = get_parent_theme_file_path( $override . '/' . $file );
			} elseif ( file_exists( get_theme_file_path( $override . '/' . $file ) ) ) {
				$path = get_theme_file_path( $override . '/' . $file );
			} elseif ( file_exists( self::$dir . '/' . $override . '/' . $file ) ) {
				$path = self::$dir . '/' . $override . '/' . $file;
			} elseif ( file_exists( self::$dir . '/' . $file ) ) {
				$path = self::$dir . '/' . $file;
			}

			if ( ! empty( $path ) && ! empty( $file ) && $load ) {

				global $wp_query;

				if ( is_object( $wp_query ) && function_exists( 'load_template' ) ) {

					load_template( $path, true );
				} else {

					require_once $path;
				}
			} else {

				return self::$dir . '/' . $file;
			}
		}

		/**
		 * Is active plugin helper.
		 *
		 * @param  string $file file.
		 * @return array
		 */
		public static function is_active_plugin( $file = '' ) {
			return in_array( $file, (array) get_option( 'active_plugins', array() ) );
		}

		/**
		 * Sanitize dirname.
		 *
		 * @param  string $dirname dirname.
		 * @return string
		 */
		public static function sanitize_dirname( $dirname ) {
			return preg_replace( '/[^A-Za-z]/', '', $dirname );
		}

		/**
		 * Set url constant.
		 *
		 * @param  string $file file.
		 * @return url
		 */
		public static function include_plugin_url( $file ) {
			return esc_url( SP_LC_URL . '/admin/views/sp-framework' ) . '/' . ltrim( $file, '/' );
		}

		/**
		 * Include files.
		 *
		 * @return void
		 */
		public static function includes() {
			// Helpers.
			self::include_plugin_file( 'functions/actions.php' );
			self::include_plugin_file( 'functions/helpers.php' );
			self::include_plugin_file( 'functions/sanitize.php' );
			self::include_plugin_file( 'functions/validate.php' );

			// Includes lasses.
			self::include_plugin_file( 'classes/abstract.class.php' );
			self::include_plugin_file( 'classes/fields.class.php' );
			self::include_plugin_file( 'classes/admin-options.class.php' );
			self::include_plugin_file( 'classes/metabox-options.class.php' );

			// Include all framework fields.
			$fields = apply_filters(
				'splogocarousel_fields',
				array(
					'border',
					'button_set',
					'checkbox',
					'code_editor',
					'color',
					'color_group',
					'column',
					'layout_preset',
					'notice',
					'radio',
					'select',
					'slider',
					'spacing',
					'spinner',
					'subheading',
					'switcher',
					'text',
					'textarea',
					'typography',
					'image_sizes',
					'dimensions_advanced',
					'custom_import',
				)
			);

			if ( ! empty( $fields ) ) {
				foreach ( $fields as $field ) {
					if ( ! class_exists( 'SPLC_FREE_Field_' . $field ) && class_exists( 'SPLC_FREE_Fields' ) ) {
						self::include_plugin_file( 'fields/' . $field . '/' . $field . '.php' );
					}
				}
			}
		}

		/**
		 *  Set all of used fields.
		 *
		 * @param  array $sections section.
		 * @return void
		 */
		public static function set_used_fields( $sections ) {

			if ( ! empty( $sections['fields'] ) ) {

				foreach ( $sections['fields'] as $field ) {

					if ( ! empty( $field['fields'] ) ) {
						self::set_used_fields( $field );
					}

					if ( ! empty( $field['tabs'] ) ) {
						self::set_used_fields( array( 'fields' => $field['tabs'] ) );
					}

					if ( ! empty( $field['accordions'] ) ) {
						self::set_used_fields( array( 'fields' => $field['accordions'] ) );
					}

					if ( ! empty( $field['type'] ) ) {
						self::$fields[ $field['type'] ] = $field;
					}
				}
			}
		}

		/**
		 * Enqueue admin and fields styles and scripts
		 *
		 * @return void
		 */
		public static function add_admin_enqueue_scripts() {
			// Loads scripts and styles only when needed.
			$wpscreen = get_current_screen();

			if ( ! empty( self::$args['admin_options'] ) ) {
				foreach ( self::$args['admin_options'] as $argument ) {
					if ( substr( $wpscreen->id, -strlen( $argument['menu_slug'] ) ) === $argument['menu_slug'] ) {
						self::$enqueue = true;
					}
				}
			}

			if ( ! empty( self::$args['metabox_options'] ) ) {
				foreach ( self::$args['metabox_options'] as $argument ) {
					if ( in_array( $wpscreen->post_type, (array) $argument['post_type'] ) ) {
						self::$enqueue = true;
					}
				}
			}

			if ( ! apply_filters( 'splogocarousel_enqueue_assets', self::$enqueue ) ) {
				return;
			}

			// Check for developer mode.
			$min = SCRIPT_DEBUG ? '' : '.min';

			// Admin utilities.
			wp_enqueue_media();

			// Wp color picker.
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );

			// Font awesome 4 and 5 loader.
			if ( apply_filters( 'splogocarousel_fa4', true ) ) {
				wp_enqueue_style( 'splogocarousel-fa', 'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome' . $min . '.css', array(), '4.7.0', 'all' );
			} else {
				wp_enqueue_style( 'splogocarousel-fa5', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/all' . $min . '.css', array(), '5.15.3', 'all' );
				wp_enqueue_style( 'splogocarousel-fa5-v4-shims', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/v4-shims' . $min . '.css', array(), '5.15.3', 'all' );
			}

			// Main style.
			wp_enqueue_style( 'splogocarousel', self::include_plugin_url( 'assets/css/style' . $min . '.css' ), array(), self::$version, 'all' );

			// Main RTL styles.
			if ( is_rtl() ) {
				wp_enqueue_style( 'splogocarousel-rtl', self::include_plugin_url( 'assets/css/style-rtl' . $min . '.css' ), array(), self::$version, 'all' );
			}

			// Main scripts.
			wp_enqueue_script( 'splogocarousel-plugins', self::include_plugin_url( 'assets/js/plugins' . $min . '.js' ), array(), self::$version, true );
			wp_enqueue_script( 'splogocarousel', self::include_plugin_url( 'assets/js/main' . $min . '.js' ), array( 'splogocarousel-plugins' ), self::$version, true );

			// Main variables.
			wp_localize_script(
				'splogocarousel',
				'splogocarousel_vars',
				array(
					'color_palette' => apply_filters( 'splogocarousel_color_palette', array() ),
					'previewJS'     => esc_url( SP_LC_URL . 'public/assets/js/splc-script' . $min . '.js' ),
					'i18n'          => array(
						'confirm'         => esc_html__( 'Are you sure?', 'logo-carousel-free' ),
						'typing_text'     => esc_html__( 'Please enter or more characters', 'logo-carousel-free' ),
						'searching_text'  => esc_html__( 'Searching...', 'logo-carousel-free' ),
						'no_results_text' => esc_html__( 'No results found.', 'logo-carousel-free' ),
					),

				)
			);

			// Enqueue fields scripts and styles.
			$enqueued = array();

			if ( ! empty( self::$fields ) ) {
				foreach ( self::$fields as $field ) {
					if ( ! empty( $field['type'] ) ) {
						$classname = 'SPLC_FREE_Field_' . $field['type'];
						if ( class_exists( $classname ) && method_exists( $classname, 'enqueue' ) ) {
							$instance = new $classname( $field );
							if ( method_exists( $classname, 'enqueue' ) ) {
								$instance->enqueue();
							}
							unset( $instance );
						}
					}
				}
			}

			do_action( 'splogocarousel_enqueue' );
		}

		/**
		 * Add typography enqueue styles to front page.
		 *
		 * @return void
		 */
		public static function add_typography_enqueue_styles() {
			if ( ! empty( self::$webfonts ) ) {

				if ( ! empty( self::$webfonts['enqueue'] ) ) {

					$query = array();
					$fonts = array();

					foreach ( self::$webfonts['enqueue'] as $family => $styles ) {
						$fonts[] = $family . ( ( ! empty( $styles ) ) ? ':' . implode( ',', $styles ) : '' );
					}

					if ( ! empty( $fonts ) ) {
						$query['family'] = implode( '%7C', $fonts );
					}

					if ( ! empty( self::$subsets ) ) {
						$query['subset'] = implode( ',', self::$subsets );
					}

					$query['display'] = 'swap';

				}

				if ( ! empty( self::$webfonts['async'] ) ) {

					$fonts = array();

					foreach ( self::$webfonts['async'] as $family => $styles ) {
						$fonts[] = $family . ( ( ! empty( $styles ) ) ? ':' . implode( ',', $styles ) : '' );
					}

					wp_enqueue_script( 'splogocarousel-google-web-fonts', esc_url( '//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js' ), array(), null, false );

					wp_localize_script( 'splogocarousel-google-web-fonts', 'WebFontConfig', array( 'google' => array( 'families' => $fonts ) ) );
				}
			}
		}


		/**
		 * Add a new framework field
		 *
		 * @param  array  $field field.
		 * @param  string $value value.
		 * @param  string $unique unique.
		 * @param  string $where css.
		 * @param  string $parent parent field.
		 * @return void
		 */
		public static function field( $field = array(), $value = '', $unique = '', $where = '', $parent = '' ) {

			// Check for Disallow fields.
			if ( ! empty( $field['_notice'] ) ) {

				$field_type = $field['type'];

				$field            = array();
				$field['content'] = esc_html__( 'Oops! Not allowed.', 'logo-carousel-free' ) . ' <strong>(' . $field_type . ')</strong>';
				$field['type']    = 'notice';
				$field['style']   = 'danger';
			}

			$depend     = '';
			$visible    = '';
			$unique     = ( ! empty( $unique ) ) ? $unique : '';
			$class      = ( ! empty( $field['class'] ) ) ? ' ' . esc_attr( $field['class'] ) : '';
			$is_pseudo  = ( ! empty( $field['pseudo'] ) ) ? ' splogocarousel-pseudo-field' : '';
			$field_type = ( ! empty( $field['type'] ) ) ? esc_attr( $field['type'] ) : '';

			if ( ! empty( $field['dependency'] ) ) {

				$dependency      = $field['dependency'];
				$depend_visible  = '';
				$data_controller = '';
				$data_condition  = '';
				$data_value      = '';
				$data_global     = '';

				if ( is_array( $dependency[0] ) ) {
					$data_controller = implode( '|', array_column( $dependency, 0 ) );
					$data_condition  = implode( '|', array_column( $dependency, 1 ) );
					$data_value      = implode( '|', array_column( $dependency, 2 ) );
					$data_global     = implode( '|', array_column( $dependency, 3 ) );
					$depend_visible  = implode( '|', array_column( $dependency, 4 ) );
				} else {
					$data_controller = ( ! empty( $dependency[0] ) ) ? $dependency[0] : '';
					$data_condition  = ( ! empty( $dependency[1] ) ) ? $dependency[1] : '';
					$data_value      = ( ! empty( $dependency[2] ) ) ? $dependency[2] : '';
					$data_global     = ( ! empty( $dependency[3] ) ) ? $dependency[3] : '';
					$depend_visible  = ( ! empty( $dependency[4] ) ) ? $dependency[4] : '';
				}

				$depend .= ' data-controller="' . esc_attr( $data_controller ) . '"';
				$depend .= ' data-condition="' . esc_attr( $data_condition ) . '"';
				$depend .= ' data-value="' . esc_attr( $data_value ) . '"';
				$depend .= ( ! empty( $data_global ) ) ? ' data-depend-global="true"' : '';

				$visible = ( ! empty( $depend_visible ) ) ? ' splogocarousel-depend-visible' : ' splogocarousel-depend-hidden';
			}

			if ( ! empty( $field_type ) ) {
				// These attributes has been sanitized above.
				echo '<div class="splogocarousel-field splogocarousel-field-' . esc_attr( $field_type . $is_pseudo . $class . $visible ) . '"' . wp_kses_post( $depend ) . '>';

				if ( ! empty( $field['fancy_title'] ) ) {
					echo '<div class="splogocarousel-fancy-title">' . wp_kses_post( $field['fancy_title'] ) . '</div>';
				}
				if ( ! empty( $field['title'] ) ) {
					echo '<div class="splogocarousel-title">';
					echo '<h4>' . wp_kses_post( $field['title'] ) . '</h4>';
					echo ( ! empty( $field['title_help'] ) ) ? '<div class="splogocarousel-help splogocarousel-title-help"><span class="splogocarousel-help-text">' . wp_kses_post( $field['title_help'] ) . '</span><i class="fa fa-question-circle"></i></div>' : '';
					echo ( ! empty( $field['subtitle'] ) ) ? '<div class="splogocarousel-subtitle-text">' . wp_kses_post( $field['subtitle'] ) . '</div>' : '';
					echo '</div>';
				}
				echo ( ! empty( $field['title'] ) || ! empty( $field['fancy_title'] ) ) ? '<div class="splogocarousel-fieldset">' : '';
				$value = ( ! isset( $value ) && isset( $field['default'] ) ) ? $field['default'] : $value;
				$value = ( isset( $field['value'] ) ) ? $field['value'] : $value;

				$classname = 'SPLC_FREE_Field_' . $field_type;

				if ( class_exists( $classname ) ) {
					$instance = new $classname( $field, $value, $unique, $where, $parent );
					$instance->render();
				} else {
					echo '<p>' . esc_html__( 'Field not found!', 'logo-carousel-free' ) . '</p>';
				}
			} else {
				echo '<p>' . esc_html__( 'Field not found!', 'logo-carousel-free' ) . '</p>';
			}
			echo ( ! empty( $field['title'] ) || ! empty( $field['fancy_title'] ) ) ? '</div>' : '';
			echo '<div class="clear"></div>';
			echo '</div>';
		}
	}
}

SPLC::init( __FILE__ );

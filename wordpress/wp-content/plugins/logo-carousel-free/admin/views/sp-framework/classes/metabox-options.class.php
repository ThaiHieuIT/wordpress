<?php
/**
 * Metabox Class
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! class_exists( 'SPLC_FREE_Metabox' ) ) {

	/**
	 *
	 * Metabox Class
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPLC_FREE_Metabox extends SPLC_FREE_Abstract {

		// Constants.

		/**
		 * Unique id.
		 *
		 * @var string
		 */
		public $unique = '';

		/**
		 * Abstract.
		 *
		 * @var string
		 */
		public $abstract = 'metabox';

		/**
		 * Pre_fields.
		 *
		 * @var array
		 */
		public $pre_fields = array();

		/**
		 * Post type.
		 *
		 * @var array
		 */
		public $sections = array();

		/**
		 * Post type
		 *
		 * @var array
		 */
		public $post_type = array();

		/**
		 * Array
		 *
		 * @var array
		 */
		public $args = array(
			'title'              => '',
			'post_type'          => 'post',
			'data_type'          => 'serialize',
			'context'            => 'advanced',
			'priority'           => 'default',
			'exclude_post_types' => array(),
			'page_templates'     => '',
			'post_formats'       => '',
			'show_reset'         => false,
			'show_restore'       => false,
			'enqueue_webfont'    => true,
			'async_webfont'      => false,
			'output_css'         => true,
			'nav'                => 'normal',
			'theme'              => 'dark',
			'class'              => '',
			'defaults'           => array(),
		);

		/**
		 * Run metabox construct.
		 *
		 * @param  string $key Key.
		 * @param  array  $params params.
		 * @return void
		 */
		public function __construct( $key, $params = array() ) {
			$this->unique         = $key;
			$this->args           = apply_filters( "splogocarousel_{$this->unique}_args", wp_parse_args( $params['args'], $this->args ), $this );
			$this->sections       = apply_filters( "splogocarousel_{$this->unique}_sections", $params['sections'], $this );
			$this->post_type      = ( is_array( $this->args['post_type'] ) ) ? $this->args['post_type'] : array_filter( (array) $this->args['post_type'] );
			$this->post_formats   = ( is_array( $this->args['post_formats'] ) ) ? $this->args['post_formats'] : array_filter( (array) $this->args['post_formats'] );
			$this->page_templates = ( is_array( $this->args['page_templates'] ) ) ? $this->args['page_templates'] : array_filter( (array) $this->args['page_templates'] );
			$this->pre_fields     = $this->pre_fields( $this->sections );

			add_action( 'add_meta_boxes', array( &$this, 'add_meta_box' ) );
			add_action( 'save_post', array( &$this, 'save_meta_box' ) );
			add_action( 'edit_attachment', array( &$this, 'save_meta_box' ) );
			add_action( 'wp_ajax_splcp_preview_meta_box', array( $this, 'splcp_preview_meta_box' ) );

			if ( ! empty( $this->page_templates ) || ! empty( $this->post_formats ) || ! empty( $this->args['class'] ) ) {
				foreach ( $this->post_type as $post_type ) {
					add_filter( 'postbox_classes_' . $post_type . '_' . $this->unique, array( &$this, 'add_metabox_classes' ) );
				}
			}
			// wp enqeueu for typography and output css.
			parent::__construct();

		}

		/**
		 * Instance.
		 *
		 * @param  string $key key.
		 * @param  array  $params params.
		 * @return mixed
		 */
		public static function instance( $key, $params = array() ) {
			return new self( $key, $params );
		}

		/**
		 * Pre fields.
		 *
		 * @param array $sections section.
		 * @return array
		 */
		public function pre_fields( $sections ) {

			$result = array();

			foreach ( $sections as $key => $section ) {
				if ( ! empty( $section['fields'] ) ) {
					foreach ( $section['fields'] as $field ) {
						$result[] = $field;
					}
				}
			}

			return $result;

		}

		/**
		 * Add metabox classes
		 *
		 * @param string $classes classes.
		 * @return statement
		 */
		public function add_metabox_classes( $classes ) {

			global $post;

			if ( ! empty( $this->post_formats ) ) {

				$saved_post_format = ( is_object( $post ) ) ? get_post_format( $post ) : false;
				$saved_post_format = ( ! empty( $saved_post_format ) ) ? $saved_post_format : 'default';

				$classes[] = 'splogocarousel-post-formats';

				// Sanitize post format for standard to default.
				$key = array_search( 'standard', $this->post_formats, true );
				if ( false !== $key ) {
					$this->post_formats[ $key ] = 'default';
				}

				foreach ( $this->post_formats as $format ) {
					$classes[] = 'splogocarousel-post-format-' . $format;
				}

				if ( ! in_array( $saved_post_format, $this->post_formats ) ) {
					$classes[] = 'splogocarousel-metabox-hide';
				} else {
					$classes[] = 'splogocarousel-metabox-show';
				}
			}

			if ( ! empty( $this->page_templates ) ) {

				$saved_template = ( is_object( $post ) && ! empty( $post->page_template ) ) ? $post->page_template : 'default';

				$classes[] = 'splogocarousel-page-templates';

				foreach ( $this->page_templates as $template ) {
					$classes[] = 'splogocarousel-page-' . preg_replace( '/[^a-zA-Z0-9]+/', '-', strtolower( $template ) );
				}

				if ( ! in_array( $saved_template, $this->page_templates ) ) {
					$classes[] = 'splogocarousel-metabox-hide';
				} else {
					$classes[] = 'splogocarousel-metabox-show';
				}
			}

			if ( ! empty( $this->args['class'] ) ) {
				$classes[] = $this->args['class'];
			}

			return $classes;

		}

		/**
		 * Add metabox
		 *
		 * @param  mixed $post_type post type.
		 * @return void
		 */
		public function add_meta_box( $post_type ) {

			if ( ! in_array( $post_type, $this->args['exclude_post_types'] ) ) {
				add_meta_box( $this->unique, $this->args['title'], array( &$this, 'add_meta_box_content' ), $this->post_type, $this->args['context'], $this->args['priority'], $this->args );
			}

		}

		/**
		 * Get default value
		 *
		 * @param  string $field field.
		 * @return statement
		 */
		public function get_default( $field ) {

			$default = ( isset( $field['default'] ) ) ? $field['default'] : '';
			$default = ( isset( $this->args['defaults'][ $field['id'] ] ) ) ? $this->args['defaults'][ $field['id'] ] : $default;

			return $default;

		}

		/**
		 * Get meta value
		 *
		 * @param  mixed $field fields.
		 * @return mixed
		 */
		public function get_meta_value( $field ) {

			global $post;

			$value = null;

			if ( is_object( $post ) && ! empty( $field['id'] ) ) {

				if ( 'serialize' !== $this->args['data_type'] ) {
					$meta  = get_post_meta( $post->ID, $field['id'] );
					$value = ( isset( $meta[0] ) ) ? $meta[0] : null;
				} else {
					$meta  = get_post_meta( $post->ID, $this->unique, true );
					$value = ( isset( $meta[ $field['id'] ] ) ) ? $meta[ $field['id'] ] : null;
				}
			}

			$default = ( isset( $field['id'] ) ) ? $this->get_default( $field ) : '';
			$value   = ( isset( $value ) ) ? $value : $default;

			return $value;

		}

		/**
		 * Add metabox content
		 *
		 * @param  object $post post.
		 * @param  mixed  $callback callback.
		 * @return void
		 */
		public function add_meta_box_content( $post, $callback ) {

			global $post;

			$has_nav   = ( count( $this->sections ) > 1 && 'side' !== $this->args['context'] ) ? true : false;
			$show_all  = ( ! $has_nav ) ? ' splogocarousel-show-all' : '';
			$post_type = ( is_object( $post ) ) ? $post->post_type : '';
			$errors    = ( is_object( $post ) ) ? get_post_meta( $post->ID, '_splogocarousel_errors_' . $this->unique, true ) : array();
			$errors    = ( ! empty( $errors ) ) ? $errors : array();
			$theme     = ( $this->args['theme'] ) ? ' splogocarousel-theme-' . $this->args['theme'] : '';
			$nav_type  = ( 'inline' === $this->args['nav'] ) ? 'inline' : 'normal';

			$shortcode_show = isset( $this->args['splcp_shortcode'] ) ? $this->args['splcp_shortcode'] : true;
			$is_preview     = isset( $this->args['preview'] ) ? $this->args['preview'] : false;

			if ( is_object( $post ) && ! empty( $errors ) ) {
				delete_post_meta( $post->ID, '_splogocarousel_errors_' . $this->unique );
			}

			wp_nonce_field( 'splogocarousel_metabox_nonce', 'splogocarousel_metabox_nonce' . $this->unique );
			if ( $is_preview ) {
				?>
			<div id="splcp_live_preview">
				<div class="postbox-header ">
					<h2>Live Preview</h2>
				</div>
				<div class="inside">
					<div class="splogocarousel splogocarousel-metabox splogocarousel-theme-dark">
						<div class="splogocarousel-wrapper splogocarousel-show-all">
							<div class="splogocarousel-content">
								<div class="splogocarousel-sections">
									<div class="splogocarousel-field splogocarousel-field-preview">
										<div class="splcp-preview-box">
											<div id="splcp-preview-box">
											</div>
										</div>
										<div class="clear"></div>
									</div>
								</div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
				<?php
			}
			echo '<div class="splogocarousel splogocarousel-metabox' . esc_attr( $theme ) . '">';
			$current_screen        = get_current_screen();
			$the_current_post_type = $current_screen->post_type;
			if ( 'sp_lc_shortcodes' === $the_current_post_type && $shortcode_show ) {
				?>
			<div class="sp_lc_shortcode_header">
			<div class="sp_lc_shortcode_header_logo">
				<img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/images/lc-logo.svg'; ?>" alt="Logo Carousel">
			</div>
			<div class="sp_lc_shortcode_header_support">
				<a href="https://shapedplugin.com/support/?user=lite" target="_blank"><i
						class="fa fa-support"></i><span>Support</span></a>
			</div>
		</div>
		<div class="lc_shortcode text-center">
			<div class="lc-col-lg-6">
				<div class="lc_shortcode_content">
					<h2 class="lc-shortcode-title"><?php esc_html_e( 'Shortcode', 'logo-carousel-free' ); ?> </h2>
					<p><?php esc_html_e( 'Copy and paste this shortcode into your posts or pages:', 'logo-carousel-free' ); ?></p>
					<div class="shortcode-wrap">
					<div class="lc-after-copy-text"><i class="fa fa-check-circle"></i> <?php esc_html_e( 'Shortcode  Copied to Clipboard! ', 'logo-carousel-free' ); ?>  </div>

							<div class="lc-sc-code selectable" >[logocarousel <?php echo 'id="' . esc_attr( $post->ID ) . '"'; ?>]</div>
						</div>
				</div>
			</div>
			<div class="lc-col-lg-6">
				<div class="lc_shortcode_content">
					<h2 class="lc-shortcode-title"><?php esc_html_e( 'Template Include', 'logo-carousel-free' ); ?> </h2>
					<p><?php esc_html_e( 'Paste the PHP code into your template file:', 'logo-carousel-free' ); ?></p>
					<div class="shortcode-wrap">
					<div class="lc-after-copy-text"><i class="fa fa-check-circle"></i> <?php esc_html_e( 'Shortcode  Copied to Clipboard! ', 'logo-carousel-free' ); ?>  </div>
						<div class="lc-sc-code selectable">&lt;?php echo do_shortcode('[logocarousel id="<?php echo esc_attr( $post->ID ); ?>"]'); ?&gt;</div>
						</div>
				</div>
			</div>
		</div>
				<?php
			}
			echo '<div class="splogocarousel-wrapper' . esc_attr( $show_all ) . '">';

			if ( $has_nav ) {

				echo '<div class="splogocarousel-nav splogocarousel-nav-' . esc_attr( $nav_type ) . ' splogocarousel-nav-metabox">';

				echo '<ul>';

				$tab_key = 1;

				foreach ( $this->sections as $section ) {

					if ( ! empty( $section['post_type'] ) && ! in_array( $post_type, array_filter( (array) $section['post_type'] ) ) ) {
						continue;
					}

					$tab_error = ( ! empty( $errors['sections'][ $tab_key ] ) ) ? '<i class="splogocarousel-label-error splogocarousel-error">!</i>' : '';
					$tab_icon  = ( ! empty( $section['icon'] ) ) ? '<i class="splogocarousel-tab-icon ' . esc_attr( $section['icon'] ) . '"></i>' : '';

					echo '<li><a href="#" data-section="' . esc_attr( $this->unique . '_' . $tab_key ) . '" class="' . esc_attr( $this->unique . '_' . $tab_key ) . '">' . wp_kses_post( $tab_icon . $section['title'] . $tab_error ) . '</a></li>';

					$tab_key++;

				}

				echo '</ul>';

				echo '</div>';

			}

			echo '<div class="splogocarousel-content">';

			echo '<div class="splogocarousel-sections">';

			$section_key = 1;

			foreach ( $this->sections as $section ) {

				if ( ! empty( $section['post_type'] ) && ! in_array( $post_type, array_filter( (array) $section['post_type'] ) ) ) {
					continue;
				}

				$section_onload = ( ! $has_nav ) ? ' splogocarousel-onload' : '';
				$section_class  = ( ! empty( $section['class'] ) ) ? ' ' . $section['class'] : '';
				$section_title  = ( ! empty( $section['title'] ) ) ? $section['title'] : '';
				$section_icon   = ( ! empty( $section['icon'] ) ) ? '<i class="splogocarousel-section-icon ' . esc_attr( $section['icon'] ) . '"></i>' : '';

				echo '<div id="splogocarousel-section-' . esc_attr( $this->unique . '_' . $section_key ) . '"   class="splogocarousel-section hidden' . esc_attr( $section_onload . $section_class ) . '">';

				echo ( $section_title || $section_icon ) ? '<div class="splogocarousel-section-title"><h3>' . wp_kses_post( $section_icon . $section_title ) . '</h3></div>' : '';

				if ( ! empty( $section['fields'] ) ) {

					foreach ( $section['fields'] as $field ) {

						if ( ! empty( $field['id'] ) && ! empty( $errors['fields'][ $field['id'] ] ) ) {
							$field['_error'] = $errors['fields'][ $field['id'] ];
						}

						if ( ! empty( $field['id'] ) ) {
							$field['default'] = $this->get_default( $field );
						}

						SPLC::field( $field, $this->get_meta_value( $field ), $this->unique, 'metabox' );

					}
				} else {
					echo '<div class="splogocarousel-no-option">' . esc_html__( 'No data available.', 'logo-carousel-free' ) . '</div>';
				}

				echo '</div>';

				$section_key++;

			}

			echo '</div>';

			if ( ! empty( $this->args['show_restore'] ) || ! empty( $this->args['show_reset'] ) ) {

				echo '<div class="splogocarousel-sections-reset">';
				echo '<label>';
				echo '<input type="checkbox" name="' . esc_attr( $this->unique ) . '[_reset]" />';
				echo '<span class="button splogocarousel-button-reset">' . esc_html__( 'Reset', 'logo-carousel-free' ) . '</span>';
				echo '<span class="button splogocarousel-button-cancel">' . sprintf( '<small>( %s )</small> %s', esc_html__( 'update post', 'logo-carousel-free' ), esc_html__( 'Cancel', 'logo-carousel-free' ) ) . '</span>';
				echo '</label>';
				echo '</div>';

			}

			echo '</div>';

			echo ( $has_nav && 'normal' === $nav_type ) ? '<div class="splogocarousel-nav-background"></div>' : '';
			if ( $is_preview ) {
				echo '<a class="btn btn-success" id="splcp-show-preview" data-id="' . esc_attr( $post->ID ) . '"href=""> <i class="fa fa-eye" aria-hidden="true"></i> Show Preview</a>';
			}
			echo '<div class="clear"></div>';

			echo '</div>';

			echo '</div>';

		}

		/**
		 * Save metabox.
		 *
		 * @param int $post_id post id.
		 * @return mixed
		 */
		public function save_meta_box( $post_id ) {

			$count    = 1;
			$data     = array();
			$errors   = array();
			$noncekey = 'splogocarousel_metabox_nonce' . $this->unique;
			$nonce    = ( ! empty( $_POST[ $noncekey ] ) ) ? sanitize_text_field( wp_unslash( $_POST[ $noncekey ] ) ) : '';  // @codingStandardsIgnoreLine

			if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! wp_verify_nonce( $nonce, 'splogocarousel_metabox_nonce' ) ) {
				return $post_id;
			}

			// XSS ok.
			// No worries, This "POST" requests is sanitizing in the below foreach.
			$request = ( ! empty( $_POST[ $this->unique ] ) ) ? $_POST[ $this->unique ] : array(); // @codingStandardsIgnoreLine
			if ( ! empty( $request ) ) {

				foreach ( $this->sections as $section ) {

					if ( ! empty( $section['fields'] ) ) {

						foreach ( $section['fields'] as $field ) {

							if ( ! empty( $field['id'] ) ) {

								$field_id    = $field['id'];
								$field_value = isset( $request[ $field_id ] ) ? $request[ $field_id ] : '';

								// Sanitize "post" request of field.
								if ( isset( $field['sanitize'] ) && is_callable( $field['sanitize'] ) ) {
										$data[ $field_id ] = call_user_func( $field['sanitize'], $field_value );
								} else {
									if ( is_array( $field_value ) ) {
										$data[ $field_id ] = wp_kses_post_deep( $field_value );
									} else {
										$data[ $field_id ] = wp_kses_post( $field_value );
									}
								}

								// Validate "post" request of field.
								if ( isset( $field['validate'] ) && is_callable( $field['validate'] ) ) {

									$has_validated = call_user_func( $field['validate'], $field_value );

									if ( ! empty( $has_validated ) ) {

										$errors['sections'][ $count ]  = true;
										$errors['fields'][ $field_id ] = $has_validated;
										$data[ $field_id ]             = $this->get_meta_value( $field );

									}
								}
							}
						}
					}

					$count++;

				}
			}

			$data = apply_filters( "splogocarousel_{$this->unique}_save", $data, $post_id, $this );

			do_action( "splogocarousel_{$this->unique}_save_before", $data, $post_id, $this );

			if ( empty( $data ) || ! empty( $request['_reset'] ) ) {

				if ( 'serialize' !== $this->args['data_type'] ) {
					foreach ( $data as $key => $value ) {
						delete_post_meta( $post_id, $key );
					}
				} else {
					delete_post_meta( $post_id, $this->unique );
				}
			} else {

				if ( 'serialize' !== $this->args['data_type'] ) {
					foreach ( $data as $key => $value ) {
						update_post_meta( $post_id, $key, $value );
					}
				} else {
					update_post_meta( $post_id, $this->unique, $data );
				}

				if ( ! empty( $errors ) ) {
					update_post_meta( $post_id, '_splogocarousel_errors_' . $this->unique, $errors );
				}
			}

			do_action( "splogocarousel_{$this->unique}_saved", $data, $post_id, $this );

			do_action( "splogocarousel_{$this->unique}_save_after", $data, $post_id, $this );

		}

		/**
		 * Function Backed preview.
		 *
		 * @since 2.2.5
		 */
		public function splcp_preview_meta_box() {
			$nonce = isset( $_POST['ajax_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['ajax_nonce'] ) ) : ''; // @codingStandardsIgnoreLine
			if ( ! wp_verify_nonce( $nonce, 'splogocarousel_metabox_nonce' ) ) {
				return;
			}
			$count  = 1;
			$errors = array();
			// XSS ok.
			// No worries, This "Preview" requests is sanitizing in the below foreach line 595.
			$request = ( ! empty( $_POST[ 'data'] ) ) ? $_POST['data' ] : array(); // @codingStandardsIgnoreLine
			parse_str( $request, $request );
			$title   = esc_html( $request['post_title'] );
			$post_id = absint( $request['post_ID'] );
			$request = $request['sp_lcp_shortcode_options'];
			if ( ! empty( $request ) ) {
				foreach ( $this->sections as $section ) {

					if ( ! empty( $section['fields'] ) ) {

						foreach ( $section['fields'] as $field ) {
							if ( ! empty( $field['id'] ) ) {

								$field_id    = $field['id'];
								$field_value = isset( $request[ $field_id ] ) ? $request[ $field_id ] : '';
								// Sanitize request of field.
								if ( isset( $field['sanitize'] ) && is_callable( $field['sanitize'] ) ) {
									$data[ $field_id ] = call_user_func( $field['sanitize'], $field_value );
								} else {
									if ( is_array( $field_value ) ) {
										$data[ $field_id ] = wp_kses_post_deep( $field_value );
									} else {
										$data[ $field_id ] = wp_kses_post( $field_value );
									}
								}

								// Validate "post" request of field.
								if ( isset( $field['validate'] ) && is_callable( $field['validate'] ) ) {

									$has_validated = call_user_func( $field['validate'], $field_value );

									if ( ! empty( $has_validated ) ) {
										$errors['sections'][ $count ]  = true;
										$errors['fields'][ $field_id ] = $has_validated;
										$data[ $field_id ]             = $this->get_meta_value( $field );
									}
								}
							}
						}
					}

					$count++;

				}
			}
			echo '<style>';
			$logo_data   = $data;
			$dynamic_css = '';
			require SP_LC_PATH . 'public/views/dynamic-style.php';
			echo $dynamic_css;
			echo '</style>';
			SPLC_Shortcode_Render::splcp_html_show( $post_id, $data, $title );
			die();
		}
	}


}

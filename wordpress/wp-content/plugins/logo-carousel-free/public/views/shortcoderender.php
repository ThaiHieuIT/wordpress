<?php
/**
 * This file render the shortcode to the frontend
 *
 * @package logo-carousel-free
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'SPLC_Shortcode_Render' ) ) {
	/**
	 * Logo Carousel - Shortcode Render class
	 *
	 * @since 3.0
	 */
	class SPLC_Shortcode_Render {
		/**
		 * Single instance of the class
		 *
		 * @var mixed SPLC_Shortcode_Render single instance of the class
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
		 * SPLC_Shortcode_Render constructor.
		 */
		public function __construct() {
			add_shortcode( 'logocarousel', array( $this, 'sp_logo_carousel_render' ) );
		}

		/**
		 * Minify output
		 *
		 * @param  statement $html output.
		 * @return statement
		 */
		public static function minify_output( $html ) {
			$html = preg_replace( '/<!--(?!s*(?:[if [^]]+]|!|>))(?:(?!-->).)*-->/s', '', $html );
			$html = str_replace( array( "\r\n", "\r", "\n", "\t" ), '', $html );
			while ( stristr( $html, '  ' ) ) {
				$html = str_replace( '  ', ' ', $html );
			}
			return $html;
		}

		/**
		 * Gets the existing shortcode-id, page-id and option-key from the current page.
		 *
		 * @return array
		 */
		public static function get_page_data() {
			$current_page_id    = get_queried_object_id();
			$option_key         = 'sp_lcp_page_id' . $current_page_id;
			$found_generator_id = get_option( $option_key );
			if ( is_multisite() ) {
				$option_key         = 'sp_lcp_page_id' . get_current_blog_id() . $current_page_id;
				$found_generator_id = get_site_option( $option_key );
			}
			$get_page_data = array(
				'page_id'      => $current_page_id,
				'generator_id' => $found_generator_id,
				'option_key'   => $option_key,
			);
			return $get_page_data;
		}
		/**
		 * Load dynamic style of the existing shortcode id.
		 *
		 * @param  mixed $found_generator_id to push id option for getting how many shortcode in the page.
		 * @param  mixed $logo_data to push all options.
		 * @return array dynamic style use in the existing shortcodes in the current page.
		 */
		public static function load_dynamic_style( $found_generator_id, $logo_data = '' ) {
			$setting_data = get_option( '_sp_lcpro_options' );
			$dynamic_css  = '';
			// If multiple shortcode found in the current page.
			if ( is_array( $found_generator_id ) ) {
				foreach ( $found_generator_id as $post_id ) {
					if ( $post_id && is_numeric( $post_id ) && get_post_status( $post_id ) !== 'trash' ) {
						$logo_data = get_post_meta( $post_id, 'sp_lcp_shortcode_options', true );
						require SP_LC_PATH . 'public/views/dynamic-style.php';
					}
				}
			} else {
				// If single shortcode found in the current page.
				$post_id = $found_generator_id;
				require SP_LC_PATH . 'public/views/dynamic-style.php';
			}
			// Custom css merge with dynamic style.
			$custom_css = isset( $setting_data['lcpro_custom_css'] ) ? trim( html_entity_decode( $setting_data['lcpro_custom_css'] ) ) : '';
			if ( ! empty( $custom_css ) ) {
				$dynamic_css .= $custom_css;
			}
			$dynamic_style = array(
				'dynamic_css' => self::minify_output( $dynamic_css ),
			);
			return $dynamic_style;
		}

		/**
		 * If the option does not exist, it will be created.
		 *
		 * It will be serialized before it is inserted into the database.
		 *
		 * @param  string $post_id existing shortcode id.
		 * @param  array  $get_page_data get current page-id, shortcode-id and option-key from the the current page.
		 * @return void
		 */
		public static function lcp_db_options_update( $post_id, $get_page_data ) {
			$found_generator_id = $get_page_data['generator_id'];
			$option_key         = $get_page_data['option_key'];
			$current_page_id    = $get_page_data['page_id'];
			if ( $found_generator_id ) {
				$found_generator_id = is_array( $found_generator_id ) ? $found_generator_id : array( $found_generator_id );
				if ( ! in_array( $post_id, $found_generator_id ) || empty( $found_generator_id ) ) {
					// If not found the shortcode id in the page options.
					array_push( $found_generator_id, $post_id );
					if ( is_multisite() ) {
						update_site_option( $option_key, $found_generator_id );
					} else {
						update_option( $option_key, $found_generator_id );
					}
				}
			} else {
				// If option not set in current page add option.
				if ( $current_page_id ) {
					if ( is_multisite() ) {
						add_site_option( $option_key, array( $post_id ) );
					} else {
						add_option( $option_key, array( $post_id ) );
					}
				}
			}
		}

		/**
		 * Full html show.
		 *
		 * @param array $post_id Shortcode ID.
		 * @param array $logo_data get all meta options.
		 * @param array $main_section_title shows section title.
		 */
		public static function splcp_html_show( $post_id, $logo_data, $main_section_title ) {
			$columns             = isset( $logo_data['lcp_number_of_columns'] ) ? $logo_data['lcp_number_of_columns'] : '';
			$items               = isset( $columns['lg_desktop'] ) ? $columns['lg_desktop'] : 5;
			$items_desktop       = isset( $columns['desktop'] ) ? $columns['desktop'] : 4;
			$items_desktop_small = isset( $columns['tablet'] ) ? $columns['tablet'] : 3;
			$items_tablet        = isset( $columns['mobile_landscape'] ) ? $columns['mobile_landscape'] : 2;
			$items_mobile        = isset( $columns['mobile'] ) ? $columns['mobile'] : 1;
			$total_items         = isset( $logo_data['lcp_number_of_total_items'] ) && $logo_data['lcp_number_of_total_items'] ? $logo_data['lcp_number_of_total_items'] : 10000;
			// Navigation.
			$nav_data = isset( $logo_data['lcp_nav_show'] ) ? $logo_data['lcp_nav_show'] : '';
			if ( 'show' === $nav_data ) {
				$nav        = 'true';
				$nav_mobile = 'true';
			} elseif ( 'hide_on_mobile' === $nav_data ) {
				$nav        = 'true';
				$nav_mobile = 'false';
			} else {
				$nav        = 'false';
				$nav_mobile = 'false';
			}
			$dots_data = isset( $logo_data['lcp_carousel_dots'] ) ? $logo_data['lcp_carousel_dots'] : '';
			if ( 'show' === $dots_data ) {
				$dots        = 'true';
				$dots_mobile = 'true';
			} elseif ( 'hide_on_mobile' === $dots_data ) {
				$dots        = 'true';
				$dots_mobile = 'false';
			} else {
				$dots        = 'false';
				$dots_mobile = 'false';
			}
			$auto_play      = isset( $logo_data['lcp_carousel_auto_play'] ) && $logo_data['lcp_carousel_auto_play'] ? 'true' : 'false';
			$pause_on_hover = isset( $logo_data['lcp_carousel_pause_on_hover'] ) && $logo_data['lcp_carousel_pause_on_hover'] ? 'true' : 'false';
			$swipe          = isset( $logo_data['lcp_carousel_swipe'] ) && $logo_data['lcp_carousel_swipe'] ? 'true' : 'false';
			$draggable      = isset( $logo_data['lcp_carousel_draggable'] ) && $logo_data['lcp_carousel_draggable'] ? 'true' : 'false';
			$free_mode      = isset( $logo_data['lcp_free_mode'] ) && $logo_data['lcp_free_mode'] ? 'true' : 'false';
			$infinite       = 'true';
			if ( isset( $logo_data['lcp_carousel_infinite'] ) ) {
				$infinite = $logo_data['lcp_carousel_infinite'] ? 'true' : 'false';
			}
			$logo_border = isset( $logo_data['lc_logo_border'] ) ? $logo_data['lc_logo_border'] : true;
			$rtl_mode    = isset( $logo_data['lcp_rtl_mode'] ) ? $logo_data['lcp_rtl_mode'] : 'false';
			$rtl         = ( 'true' == $rtl_mode ) ? 'rtl' : 'ltr';

			$autoplay_speed   = isset( $logo_data['lcp_carousel_auto_play_speed'] ) ? $logo_data['lcp_carousel_auto_play_speed'] : '3000';
			$pagination_speed = isset( $logo_data['lcp_carousel_scroll_speed'] ) ? $logo_data['lcp_carousel_scroll_speed'] : '600';

			$section_title         = isset( $logo_data['lcp_section_title'] ) ? $logo_data['lcp_section_title'] : 'false';
			$order_by              = isset( $logo_data['lcp_item_order_by'] ) ? $logo_data['lcp_item_order_by'] : 'date';
			$order                 = isset( $logo_data['lcp_item_order'] ) ? $logo_data['lcp_item_order'] : 'ASC';
			$preloader             = isset( $logo_data['lcp_preloader'] ) ? $logo_data['lcp_preloader'] : false;
			$show_image            = isset( $logo_data['lcp_logo_image'] ) ? $logo_data['lcp_logo_image'] : true;
			$image_sizes           = isset( $logo_data['lcp_image_sizes'] ) ? $logo_data['lcp_image_sizes'] : '';
			$show_image_title_attr = isset( $logo_data['lcp_image_title_attr'] ) ? $logo_data['lcp_image_title_attr'] : false;
			$logo_margin           = isset( $logo_data['lcp_logo_margin']['all'] ) && $logo_data['lcp_logo_margin']['all'] >= -50 ? (int) $logo_data['lcp_logo_margin']['all'] : '12';
			$logo_margin_vertical  = isset( $logo_data['lcp_logo_margin']['vertical'] ) && $logo_data['lcp_logo_margin']['vertical'] >= -50 ? (int) $logo_data['lcp_logo_margin']['vertical'] : '12';

			$args = new WP_Query(
				array(
					'post_type'      => 'sp_logo_carousel',
					'orderby'        => $order_by,
					'order'          => $order,
					'posts_per_page' => intval( $total_items ),
				)
			);

			// swiper data attributes.
			$swiper_data_attr = 'data-carousel=\'{ "speed":' . esc_attr( $pagination_speed ) . ',"spaceBetween": ' . esc_attr( $logo_margin ) . ', "autoplay": ' . esc_attr( $auto_play ) . ', "infinite":' . esc_attr( $infinite ) . ', "autoplay_speed": ' . esc_attr( $autoplay_speed ) . ', "stop_onHover": ' . esc_attr( $pause_on_hover ) . ', "pagination": ' . esc_attr( $dots ) . ', "navigation": ' . esc_attr( $nav ) . ', "MobileNav": ' . esc_attr( $nav_mobile ) . ', "MobilePagi": ' . esc_attr( $dots_mobile ) . ', "simulateTouch": ' . esc_attr( $draggable ) . ',"freeMode": ' . esc_attr( $free_mode ) . ', "allowTouchMove": ' . esc_attr( $swipe ) . ', "slidesPerView": { "lg_desktop": ' . esc_attr( $items ) . ', "desktop": ' . esc_attr( $items_desktop ) . ', "tablet": ' . esc_attr( $items_desktop_small ) . ', "mobile": ' . esc_attr( $items_mobile ) . ', "mobile_landscape": ' . esc_attr( $items_tablet ) . ' } }\'';

			$output          = '';
			$preloader_class = '';
			require SP_LC_PATH . 'public/views/templates/carousel.php';
			echo $output;
		}

		/**
		 * Shortcode render
		 *
		 * @param  mixed $attribute attributes.
		 * @return mixed
		 */
		public function sp_logo_carousel_render( $attribute ) {
			if ( empty( $attribute['id'] ) || 'sp_lc_shortcodes' !== get_post_type( $attribute['id'] ) || ( get_post_status( $attribute['id'] ) === 'trash' ) || ( get_post_status( $attribute['id'] ) === 'draft' ) ) {
				return;
			}
			$post_id = esc_attr( intval( $attribute['id'] ) );
			// All Options of Shortcode.
			$logo_data = get_post_meta( $post_id, 'sp_lcp_shortcode_options', true );
			ob_start();
			// Stylesheet loading problem solving here. Shortcode id to push page id option for getting how many shortcode in the page.
			// Get the existing shortcode ids from the current page.
			$get_page_data      = self::get_page_data();
			$found_generator_id = $get_page_data['generator_id'];
			if ( ! is_array( $found_generator_id ) || ! $found_generator_id || ! in_array( $post_id, $found_generator_id ) ) {
				wp_enqueue_style( 'sp-lc-swiper' );
				wp_enqueue_style( 'sp-lc-font-awesome' );
				wp_enqueue_style( 'sp-lc-style' );
				$dynamic_style = self::load_dynamic_style( $post_id, $logo_data );
				// Load dynamic style.
				echo '<style id="sp_lcp_dynamic_css' . esc_attr( $post_id ) . '">' . $dynamic_style['dynamic_css'] . '</style>';
			}
			// Update options if the existing shortcode id option not found.
			self::lcp_db_options_update( $post_id, $get_page_data );

			$main_section_title = get_the_title( $post_id );
			self::splcp_html_show( $post_id, $logo_data, $main_section_title );

			wp_enqueue_script( 'sp-lc-swiper-js' );
			wp_enqueue_script( 'sp-lc-script' );
			return ob_get_clean();
		}

	}

	new SPLC_Shortcode_Render();
}

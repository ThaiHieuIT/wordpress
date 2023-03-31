<?php
/**
 * The plugin elementor widget.
 *
 * @link       https://shapedplugin.com/
 * @since      3.4.7
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/Admin
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

/**
 * Elementor Logo Carousel Free ShortCode Widget.
 *
 * @since 3.4.7
 */
class Logo_Carousel_Free_Element_Shortcode_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 3.4.7
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'sp_logo_carousel_pro_shortcode';
	}

	/**
	 * Get widget title.
	 *
	 * @since 3.4.7
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Logo Carousel Free', 'logo-carousel-free' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 3.4.7
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'lc-icon-block';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 3.4.7
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'basic' );
	}

	/**
	 * Get all post list.
	 *
	 * @since 3.4.7
	 * @return array
	 */
	public function splcf_post_list() {
		$post_list   = array();
		$splcf_posts = new \WP_Query(
			array(
				'post_type'      => 'sp_lc_shortcodes',
				'post_status'    => 'publish',
				'posts_per_page' => 10000,
			)
		);
		$posts       = $splcf_posts->posts;
		foreach ( $posts as $post ) {
			$post_list[ $post->ID ] = $post->post_title;
		}
		krsort( $post_list );
		return $post_list;
	}

	/**
	 * Controls register.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'Content', 'logo-carousel-free' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'sp_logo_carousel_pro_shortcode',
			array(
				'label'       => __( 'Logo Carousel Free Shortcode(s)', 'logo-carousel-free' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'default'     => '',
				'options'     => $this->splcf_post_list(),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render product slider pro shortcode widget output on the frontend.
	 *
	 * @since 3.4.7
	 * @access protected
	 */
	protected function render() {
		$settings        = $this->get_settings_for_display();
		$splcf_shortcode = $settings['sp_logo_carousel_pro_shortcode'];

		if ( '' === $splcf_shortcode ) {
			echo '<div style="text-align: center; margin-top: 0; padding: 10px" class="elementor-add-section-drag-title">Select a shortcode</div>';
			return;
		}

		$post_id = $splcf_shortcode;

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$logo_data          = get_post_meta( $post_id, 'sp_lcp_shortcode_options', true );
			$main_section_title = get_the_title( $post_id );

			// Stylesheet loading problem solving here. Shortcode id to push page id option for getting how many shortcode in the page.
			require_once SP_LC_PATH . 'public/views/shortcoderender.php';
			$dynamic_style = SPLC_Shortcode_Render::load_dynamic_style( $post_id, $logo_data );
			echo '<style id="sp_lcp_dynamic_css' . esc_attr( $post_id ) . '">' . $dynamic_style['dynamic_css'] . '</style>';

			SPLC_Shortcode_Render::splcp_html_show( $post_id, $logo_data, $main_section_title );
			?>
			<script src="<?php echo esc_url( SP_LC_URL . 'public/assets/js/splc-script.min.js' ); ?>" ></script>
			<?php
		} else {
			echo do_shortcode( '[logocarousel id="' . $post_id . '"]' );
		}

	}
}

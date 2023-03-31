<?php
/**
 * Metabox config
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access pages directly.

$prefix = 'sp_lcp_shortcode_options';

// -----------------------------------------
// Shortcode Generator Options.
// -----------------------------------------
SPLC::createMetabox(
	$prefix,
	array(
		'title'     => __( 'Shortcode Options', 'logo-carousel-free' ),
		'post_type' => 'sp_lc_shortcodes',
		'class'     => 'sp_logo_carousel_shortcode',
		'context'   => 'normal',
		'priority'  => 'default',
		'preview'   => true,
	)
);

// General Settings.
SPLC::createSection(
	$prefix,
	array(
		'title'  => __( 'General Settings', 'logo-carousel-free' ),
		'icon'   => 'fa fa-cog',
		'fields' => array(
			array(
				'id'       => 'lcp_layout',
				'class'    => 'lcp_layout',
				'type'     => 'layout_preset',
				'title'    => __( 'Layout Preset', 'logo-carousel-free' ),
				'subtitle' => __( 'Select your layout to display the logos.', 'logo-carousel-free' ),
				'desc'     => __( 'To unlock Grid, Isotope, List, and Inline layouts and Settings, <b><a href="https://logocarousel.com/pricing/?ref=1" target="_blank">Upgrade To Pro</a></b>!', 'logo-carousel-free' ),
				'options'  => array(
					'carousel' => array(
						'image' => SP_LC_URL . 'admin/assets/images/carousel.svg',
						'text'  => __( 'Carousel', 'logo-carousel-free' ),
					),
					'grid'     => array(
						'image'    => SP_LC_URL . 'admin/assets/images/grid.svg',
						'text'     => __( 'Grid', 'logo-carousel-free' ),
						'pro_only' => true,
					),
					'filter'   => array(
						'image'    => SP_LC_URL . 'admin/assets/images/isotope.svg',
						'text'     => __( 'Isotope', 'logo-carousel-free' ),
						'pro_only' => true,
					),
					'list'     => array(
						'image'    => SP_LC_URL . 'admin/assets/images/list.svg',
						'text'     => __( 'List', 'logo-carousel-free' ),
						'pro_only' => true,
					),
					'inline'   => array(
						'image'    => SP_LC_URL . 'admin/assets/images/inline.svg',
						'text'     => __( 'Inline', 'logo-carousel-free' ),
						'pro_only' => true,
					),
				),
				'default'  => 'carousel',
			),
			array(
				'id'         => 'lcp_logo_carousel_mode',
				'type'       => 'button_set',
				'title'      => __( 'Carousel Mode', 'logo-carousel-free' ),
				'subtitle'   => __( 'Select a carousel mode.', 'logo-carousel-free' ),
				'class'      => 'sp-lc-pro-only',
				'options'    => array(
					'standard' => __( 'Standard', 'logo-carousel-free' ),
					'ticker'   => __( 'Ticker', 'logo-carousel-free' ),
					'center'   => __( 'Center', 'logo-carousel-free' ),
				),
				'default'    => 'standard',
				'dependency' => array( 'lcp_layout', '==', 'carousel' ),
			),
			array(
				'id'       => 'lcp_number_of_columns',
				'type'     => 'column',
				'title'    => __( 'Logo Column(s)', 'logo-carousel-free' ),
				'subtitle' => __( 'Set number of column(s) in different devices for responsive view.', 'logo-carousel-free' ),
				'help'     => '<i class="fa fa-television"></i> <strong>Large Desktop</strong> - is larger than 1200px,<br><i class="fa fa-desktop"></i> <strong>Desktop</strong> - size is smaller than 1024px,<br> <i class="fa fa-tablet"></i> <strong>Tablet</strong> - size is smaller than 768,<br> <i class="fa fa-mobile"></i> <strong>Mobile Landscape</strong>- size is smaller than 576px.,<br> <i class="fa fa-mobile"></i> <strong>Mobile</strong> - size is smaller than 480px.',
				'sanitize' => 'splogocarousel_sanitize_number_array_field',
				'default'  => array(
					'lg_desktop'       => '5',
					'desktop'          => '4',
					'tablet'           => '3',
					'mobile_landscape' => '2',
					'mobile'           => '1',
				),
			),
			array(
				'id'       => 'lcp_display_logos_from',
				'class'    => 'lcp_display_logos_from',
				'type'     => 'select',
				'title'    => __( 'Filter Logos', 'logo-carousel-free' ),
				'subtitle' => __( 'Select an option to display by filtering logos.', 'logo-carousel-free' ),
				'options'  => array(
					'latest'         => __( 'All', 'logo-carousel-free' ),
					'category'       => array(
						'text'     => __( 'Category(Pro)', 'logo-carousel-free' ),
						'pro_only' => true,
					),
					'specific_logos' => array(
						'text'     => __( 'Specific(Pro)', 'logo-carousel-free' ),
						'pro_only' => true,
					),
				),
				'default'  => 'latest',
			),
			array(
				'id'       => 'lcp_number_of_total_items',
				'type'     => 'spinner',
				'class'    => 'lcp_spinner',
				'title'    => __( 'Limit', 'logo-carousel-free' ),
				'subtitle' => __( 'Number of total logos to show.', 'logo-carousel-free' ),
				'help'     => __( 'Leave it empty to show all found logos.', 'logo-carousel-free' ),
				'default'  => ' ',
				'sanitize' => 'splogocarousel_sanitize_number_field',
				'min'      => -1,
			),
			array(
				'id'       => 'lcp_logo_link_type',
				'type'     => 'button_set',
				'title'    => __( 'Logo Link Type ', 'logo-carousel-free' ),
				'subtitle' => __( 'Select a logo link type.', 'logo-carousel-free' ),
				'class'    => 'sp-lc-link-pro--only',
				'options'  => array(
					'Link '  => __( 'Link ', 'logo-carousel-free' ),
					'Popup ' => __( 'Popup ', 'logo-carousel-free' ),
					'none'   => __( 'None', 'logo-carousel-free' ),
				),
				'default'  => 'none',
			),
			array(
				'id'       => 'lcp_item_order_by',
				'type'     => 'select',
				'class'    => 'order_by_pro',
				'title'    => __( 'Order by', 'logo-carousel-free' ),
				'subtitle' => __( 'Select an order by option.', 'logo-carousel-free' ),
				'options'  => array(
					'title'      => __( 'Title', 'logo-carousel-free' ),
					'date'       => __( 'Date', 'logo-carousel-free' ),
					'menu_order' => __( 'Drag & Drop (Pro)', 'logo-carousel-free' ),
					'rand'       => __( 'Random (Pro)', 'logo-carousel-free' ),
				),
				'default'  => 'date',
			),
			array(
				'id'       => 'lcp_item_order',
				'type'     => 'select',
				'title'    => __( 'Order', 'logo-carousel-free' ),
				'subtitle' => __( 'Select an order option.', 'logo-carousel-free' ),
				'options'  => array(
					'ASC'  => __( 'Ascending', 'logo-carousel-free' ),
					'DESC' => __( 'Descending', 'logo-carousel-free' ),
				),
				'default'  => 'ASC',
			),
			array(
				'id'         => 'lcp_preloader',
				'type'       => 'switcher',
				'title'      => __( 'Preloader', 'logo-carousel-free' ),
				'subtitle'   => __( 'Carousel will be hidden until page load completed.', 'logo-carousel-free' ),
				'default'    => true,
				'text_on'    => __( 'Enabled', 'logo-carousel-free' ),
				'text_off'   => __( 'Disabled', 'logo-carousel-free' ),
				'text_width' => 95,
			),
		),
	)
);

// Style Settings.
SPLC::createSection(
	$prefix,
	array(
		'title'  => __( 'Style Settings', 'logo-carousel-free' ),
		'icon'   => 'fa fa-paint-brush',
		'fields' => array(
			array(
				'id'         => 'lcp_section_title',
				'type'       => 'switcher',
				'title'      => __( 'Section Title', 'logo-carousel-free' ),
				'subtitle'   => __( 'Display logo section title.', 'logo-carousel-free' ),
				'default'    => false,
				'text_on'    => __( 'Show', 'logo-carousel-free' ),
				'text_off'   => __( 'Hide', 'logo-carousel-free' ),
				'text_width' => 80,
			),
			array(
				'id'            => 'lcp_logo_margin',
				'type'          => 'spacing',
				'title'         => __( 'Space', 'logo-carousel-free' ),
				'subtitle'      => __( 'Set a margin or space between the logos.', 'logo-carousel-free' ),
				'units'         => array(
					__( 'px', 'logo-carousel-free' ),
				),
				'show_title'    => true,
				'all'           => true,
				'vertical'      => true,
				'all_icon'      => '<i class="fa fa-arrows-h" aria-hidden="true"></i>',
				'vertical_icon' => '<i class="fa fa-arrows-v" aria-hidden="true"></i>',
				'default'       => array(
					'all'      => '12',
					'vertical' => '12',
				),
			),
			array(
				'id'       => 'lcp_content_position',
				'class'    => 'lcp_content_position',
				'type'     => 'layout_preset',
				'title'    => __( 'Logo Position', 'logo-carousel-free' ),
				'subtitle' => __( 'Choose your logo position to display the logos.', 'logo-carousel-free' ),
				'options'  => array(
					'default'     => array(
						'image' => SP_LC_URL . 'admin/assets/images/default.svg',
						'text'  => __( 'Default', 'logo-carousel-free' ),
					),
					'top-logo'    => array(
						'image'    => SP_LC_URL . 'admin/assets/images/top-logo.svg',
						'text'     => __( 'Top', 'logo-carousel-free' ),
						'pro_only' => true,
					),
					'bottom-logo' => array(
						'image'    => SP_LC_URL . 'admin/assets/images/Bottom-Logo.svg',
						'text'     => __( 'Bottom', 'logo-carousel-free' ),
						'pro_only' => true,
					),
					'left-logo'   => array(
						'image'    => SP_LC_URL . 'admin/assets/images/Left-Logo.svg',
						'text'     => __( 'Left', 'logo-carousel-free' ),
						'pro_only' => true,
					),
					'right-logo'  => array(
						'image'    => SP_LC_URL . 'admin/assets/images/Right-Logo.svg',
						'text'     => __( 'Right', 'logo-carousel-free' ),
						'pro_only' => true,
					),
					'overlay'     => array(
						'image'    => SP_LC_URL . 'admin/assets/images/Overlay.svg',
						'text'     => __( 'Overlay', 'logo-carousel-free' ),
						'pro_only' => true,
					),
				),
				'desc'     => __( 'To display logo with content, changing positions, read more button, etc, <a href="https://logocarousel.com/pricing/?ref=1" target="_blank"><b>Upgrade To Pro!</b></a>', 'logo-carousel-free' ),
				'default'  => 'default',
			),
			array(
				'id'      => 'lcp_section_logo_tooltip',
				'type'    => 'subheading',
				'content' => __( 'Tooltip', 'logo-carousel-free' ),
			),
			array(
				'type'    => 'notice',
				'style'   => 'normal',
				'content' => __( 'To unlock the following amazing tooltip settings, <a href="https://logocarousel.com/pricing/?ref=1" target="_blank"><b>Upgrade To Pro!</b></a>', 'logo-carousel-free' ),
			),
			array(
				'id'         => 'lcp_logo_tooltip',
				'type'       => 'switcher',
				'class'      => 'lcp_only_pro',
				'title'      => __( 'Tooltip', 'logo-carousel-free' ),
				'subtitle'   => __( 'Show/Hide logo tooltip on hover.', 'logo-carousel-free' ),
				'default'    => true,
				'text_on'    => __( 'Show', 'logo-carousel-free' ),
				'text_off'   => __( 'Hide', 'logo-carousel-free' ),
				'text_width' => 80,
			),
			array(
				'id'         => 'lcp_logo_tooltip_position',
				'type'       => 'select',
				'class'      => 'tooltip_only_pro',
				'title'      => __( 'Position', 'logo-carousel-free' ),
				'subtitle'   => __( 'Select the tooltip position.', 'logo-carousel-free' ),
				'options'    => array(
					'top'    => __( 'Top', 'logo-carousel-free' ),
					'bottom' => __( 'Bottom', 'logo-carousel-free' ),
					'left'   => __( 'Left', 'logo-carousel-free' ),
					'right'  => __( 'Right', 'logo-carousel-free' ),
				),
				'default'    => 'top',
				'dependency' => array( 'lcp_logo_tooltip', '==', 'true' ),
			),
			array(
				'id'         => 'lcp_logo_tooltip_width',
				'type'       => 'spinner',
				'class'      => 'tooltip_only_pro',
				'title'      => __( 'Tooltip Width', 'logo-carousel-free' ),
				'subtitle'   => __( 'Maximum width of the tooltip.', 'logo-carousel-free' ),
				'default'    => '220',
				'unit'       => __( 'px', 'logo-carousel-free' ),
				'dependency' => array( 'lcp_logo_tooltip', '==', 'true' ),
				'min'        => 0,
			),
			array(
				'id'         => 'lcp_logo_tooltip_effect',
				'type'       => 'select',
				'class'      => 'tooltip_only_pro',
				'title'      => __( 'Tooltip Effect', 'logo-carousel-free' ),
				'subtitle'   => __( 'Choose an effect for the tooltip.', 'logo-carousel-free' ),
				'options'    => array(
					'grow'  => __( 'Grow', 'logo-carousel-free' ),
					'fade'  => __( 'Fade', 'logo-carousel-free' ),
					'swing' => __( 'Swing', 'logo-carousel-free' ),
					'slide' => __( 'Slide', 'logo-carousel-free' ),
					'fall'  => __( 'Fall', 'logo-carousel-free' ),
				),
				'default'    => 'grow',
				'dependency' => array( 'lcp_logo_tooltip', '==', 'true' ),
			),
			array(
				'id'         => 'lcp_logo_tooltip_color',
				'type'       => 'color_group',
				'class'      => 'tooltip_only_pro',
				'title'      => __( 'Tooltip Color', 'logo-carousel-free' ),
				'subtitle'   => __( 'Set tooltip color.', 'logo-carousel-free' ),
				'options'    => array(
					'color1' => __( 'Color', 'logo-carousel-free' ),
					'color2' => __( 'Background', 'logo-carousel-free' ),
				),
				'default'    => array(
					'color1' => '#ffffff',
					'color2' => '#000000',
				),
				'dependency' => array( 'lcp_logo_tooltip', '==', 'true' ),
			),
			array(
				'id'      => 'lcp_section_logo_border',
				'type'    => 'subheading',
				'content' => __( 'Background, Border and BoxShadow', 'logo-carousel-free' ),
			),
			array(
				'type'    => 'notice',
				'style'   => 'normal',
				'content' => __( 'To unlock logo background, radius, and boxshadow settings, <a href="https://logocarousel.com/pricing/?ref=1" target="_blank"><b>Upgrade To Pro!</b></a>', 'logo-carousel-free' ),
			),
			array(
				'id'       => 'lcp_logo_bg_type',
				'type'     => 'button_set',
				'class'    => 'sp-lc-pro-only',
				'title'    => __( 'Logo Background Type', 'logo-carousel-free' ),
				'subtitle' => __( 'Choose a logo background type.', 'logo-carousel-free' ),
				'options'  => array(
					'none'     => __( 'None', 'logo-carousel-free' ),
					'solid'    => __( 'Solid', 'logo-carousel-free' ),
					'gradient' => __( 'Gradient', 'logo-carousel-free' ),
				),
				'default'  => 'none',
			),
			array(
				'id'          => 'lcp_logo_border',
				'type'        => 'border',
				'title'       => __( 'Logo Border', 'logo-carousel-free' ),
				'subtitle'    => __( 'Set border for logo image.', 'logo-carousel-free' ),
				'all'         => true,
				'default'     => array(
					'all'         => '1',
					'style'       => 'solid',
					'color'       => '#dddddd',
					'hover_color' => '#16a08b',
				),
				'hover_color' => true,
			),
			array(
				'id'         => 'lcp_logo_outer_border',
				'type'       => 'switcher',
				'class'      => 'tooltip_only_pro',
				'title'      => __( 'Outer Border', 'logo-carousel-free' ),
				'subtitle'   => __( 'Show/Hide logo outer border.', 'logo-carousel-free' ),
				'default'    => true,
				'dependency' => array( 'lcp_layout', '==', 'inline', true ),
			),
			array(
				'id'         => 'lcp_border_radius',
				'type'       => 'spacing',
				'class'      => 'tooltip_only_pro',
				'title'      => __( 'Border Radius', 'logo-carousel-free' ),
				'subtitle'   => __( 'Set logo border radius.', 'logo-carousel-free' ),
				'all'        => true,
				'sanitize'   => 'splogocarousel_sanitize_number_array_field',
				'units'      => array(
					'px',
					'%',
				),
				'default'    => array(
					'all'  => 0,
					'unit' => 'px',
				),
				'all_icon'   => '<i class="fa fa-arrows-alt"></i>',
				'dependency' => array( 'lcp_layout', '!=', 'inline', true ),
			),
			array(
				'id'       => 'lcp_logo_shadow_type',
				'type'     => 'button_set',
				'class'    => 'sp-lc-pro-only',
				'title'    => __( 'BoxShadow', 'logo-carousel-free' ),
				'subtitle' => __( 'Set boxshadow for the logo.', 'logo-carousel-free' ),
				'options'  => array(
					'none'          => __( 'None', 'logo-carousel-free' ),
					'shadow_inset'  => __( 'Inset', 'logo-carousel-free' ),
					'shadow_outset' => __( 'Outset', 'logo-carousel-free' ),
				),
				'default'  => 'none',
			),
			array(
				'id'      => 'lcp_section_logo_pagination',
				'type'    => 'subheading',
				'content' => __( 'Pagination', 'logo-carousel-free' ),
			),
			array(
				'type'    => 'notice',
				'style'   => 'normal',
				'content' => __( 'To unlock the following amazing pagination settings, <a href="https://logocarousel.com/pricing/?ref=1" target="_blank"><b>Upgrade To Pro!</b></a>', 'logo-carousel-free' ),
			),
			array(
				'id'         => 'lcp_pagination',
				'type'       => 'switcher',
				'class'      => 'lcp_only_pro',
				'title'      => __( 'Pagination', 'logo-carousel-free' ),
				'subtitle'   => __( 'Enable/Disable pagination.', 'logo-carousel-free' ),
				'default'    => false,
				'text_on'    => __( 'Enabled', 'logo-carousel-free' ),
				'text_off'   => __( 'Disabled', 'logo-carousel-free' ),
				'text_width' => 96,
			),
			array(
				'id'       => 'lcp_pagination_type',
				'type'     => 'radio',
				'class'    => 'lcp_only_pro',
				'title'    => __( 'Pagination Type', 'logo-carousel-free' ),
				'subtitle' => __( 'Choose a pagination type.', 'logo-carousel-free' ),
				'options'  => array(
					'ajax_number'     => __( 'Ajax Number Pagination', 'logo-carousel-free' ),
					'ajax_load_more'  => __( 'Load More Button (Ajax)', 'logo-carousel-free' ),
					'infinite_scroll' => __( 'Infinite Scroll (Ajax)', 'logo-carousel-free' ),
					'no_ajax'         => __( 'No Ajax (Normal Pagination)', 'logo-carousel-free' ),
				),
				'default'  => 'ajax_load_more',
			),
			array(
				'id'       => 'lcp_number_of_pagination',
				'type'     => 'spinner',
				'title'    => __( 'Logo(s) To Show Per Page/Click', 'logo-carousel-free' ),
				'class'    => 'lcp_only_pro',
				'subtitle' => __( 'Set number of logo(s) to show per page or click.', 'logo-carousel-free' ),
				'default'  => '15',
				'min'      => -1,
				'max'      => 1000,
			),
			array(
				'id'      => 'lcp_section_logo_pagination',
				'type'    => 'subheading',
				'content' => __( 'Contact Us Button', 'logo-carousel-free' ),
			),
			array(
				'id'         => 'lcp_pagination',
				'type'       => 'switcher',
				'class'      => 'lcp_only_pro',
				'title'      => __( 'Contact Us Button', 'logo-carousel-free' ),
				'subtitle'   => __( 'Show/Hide call to action button.', 'logo-carousel-free' ),
				'default'    => false,
				'text_on'    => __( 'Show', 'logo-carousel-free' ),
				'text_off'   => __( 'Hide', 'logo-carousel-free' ),
				'text_width' => 80,
			),
		),
	)
);

// Logo Image Settings.
SPLC::createSection(
	$prefix,
	array(
		'title'  => __( 'Logo Image Settings', 'logo-carousel-free' ),
		'icon'   => 'fa fa-image',
		'fields' => array(
			array(
				'id'         => 'lcp_logo_image',
				'type'       => 'switcher',
				'title'      => __( 'Logo Image', 'logo-carousel-free' ),
				'subtitle'   => __( 'Show/Hide logo image.', 'logo-carousel-free' ),
				'default'    => true,
				'text_on'    => __( 'Show', 'logo-carousel-free' ),
				'text_off'   => __( 'Hide', 'logo-carousel-free' ),
				'text_width' => 80,
			),
			array(
				'id'         => 'lcp_image_sizes',
				'type'       => 'image_sizes',
				'chosen'     => true,
				'title'      => __( 'Logo Image Size', 'logo-carousel-free' ),
				'default'    => 'full',
				'subtitle'   => __( 'Set a size for logo image.', 'logo-carousel-free' ),
				'dependency' => array( 'lcp_logo_image', '==', 'true', true ),
			),
			array(
				'id'                => 'lcp_image_crop_size',
				'type'              => 'dimensions_advanced',
				'title'             => __( 'Custom Logo Size', 'logo-carousel-free' ),
				'subtitle'          => __( 'Set width and height of the logo image.', 'logo-carousel-free' ),
				'chosen'            => true,
				'bottom'            => false,
				'left'              => false,
				'color'             => false,
				'top_icon'          => '<i class="fa fa-arrows-h"></i>',
				'right_icon'        => '<i class="fa fa-arrows-v"></i>',
				'top_placeholder'   => 'width',
				'right_placeholder' => 'height',
				'styles'            => array(
					'Soft-crop',
					'Hard-crop',
				),
				'default'           => array(
					'top'   => '',
					'right' => '',
					'style' => 'Hard-crop',
					'unit'  => 'px',
				),
				'attributes'        => array(
					'min' => 0,
				),
				'dependency'        => array( 'lcp_logo_image|lcp_image_sizes', '==|==', 'true|custom', true ),
			),

			array(
				'id'         => 'load_2x_image',
				'type'       => 'switcher',
				'class'      => 'lcp_only_pro',
				'title'      => __( 'Load 2x Resolution Image in Retina Display', 'logo-carousel-free' ),
				'subtitle'   => __(
					'You should upload 2x sized images for the retina display.
				',
					'logo-carousel-free'
				),
				'default'    => false,
				'text_on'    => __( 'Enabled', 'logo-carousel-free' ),
				'text_off'   => __( 'Disabled', 'logo-carousel-free' ),
				'text_width' => 95,
				'dependency' => array( 'lcp_logo_image|lcp_image_sizes', '==|==', 'true|custom', true ),
			),
			array(
				'id'         => 'lcp_logo_zoom_effect_types',
				'type'       => 'select',
				'title'      => __( 'Hover Animation', 'logo-carousel-free' ),
				'subtitle'   => __( 'Select a hover animation effect for the logo image.', 'logo-carousel-free' ),
				'class'      => 'order_by_pro',
				'options'    => array(
					'off'               => __( 'None', 'logo-carousel-free' ),
					'zoom_in'           => __( 'Zoom In (Pro)', 'logo-carousel-free' ),
					'zoom_out'          => __( 'Zoom Out (Pro)', 'logo-carousel-free' ),
					'bounce'            => __( 'Bounce (Pro)', 'logo-carousel-free' ),
					'flash'             => __( 'Flash (Pro)', 'logo-carousel-free' ),
					'pulse'             => __( 'Pulse (Pro)', 'logo-carousel-free' ),
					'rubberBand'        => __( 'RubberBand (Pro)', 'logo-carousel-free' ),
					'shakeY'            => __( 'ShakeY (Pro)', 'logo-carousel-free' ),
					'swing'             => __( 'Swing (Pro)', 'logo-carousel-free' ),
					'tada'              => __( 'Tada (Pro)', 'logo-carousel-free' ),
					'heartBeat'         => __( 'HeartBeat (Pro)', 'logo-carousel-free' ),
					'backInDown'        => __( 'BackInDown (Pro)', 'logo-carousel-free' ),
					'backInLeft'        => __( 'BackInLeft (Pro)', 'logo-carousel-free' ),
					'backInRight'       => __( 'BackInRight (Pro)', 'logo-carousel-free' ),
					'bounceIn'          => __( 'BounceIn (Pro)', 'logo-carousel-free' ),
					'bounceInLeft'      => __( 'BounceInLeft (Pro)', 'logo-carousel-free' ),
					'bounceInRight'     => __( 'BounceInRight (Pro)', 'logo-carousel-free' ),
					'fadeIn'            => __( 'FadeIn (Pro)', 'logo-carousel-free' ),
					'fadeInDown'        => __( 'FadeInDown (Pro)', 'logo-carousel-free' ),
					'fadeInUp'          => __( 'FadeInUp (Pro)', 'logo-carousel-free' ),
					'fadeInTopLeft'     => __( 'FadeInTopLeft (Pro)', 'logo-carousel-free' ),
					'fadeInTopRight'    => __( 'FadeInTopRight (Pro)', 'logo-carousel-free' ),
					'fadeInBottomLeft'  => __( 'FadeInBottomLeft (Pro)', 'logo-carousel-free' ),
					'fadeInBottomRight' => __( 'FadeInBottomRight (Pro)', 'logo-carousel-free' ),
					'flip'              => __( 'Flip (Pro)', 'logo-carousel-free' ),
					'flipInX'           => __( 'FlipInX (Pro)', 'logo-carousel-free' ),
					'flipInY'           => __( 'FlipInY (Pro)', 'logo-carousel-free' ),
					'lightSpeedInRight' => __( 'LightSpeedInRight (Pro)', 'logo-carousel-free' ),
					'lightSpeedInLeft'  => __( 'LightSpeedInLeft (Pro)', 'logo-carousel-free' ),
					'rotateIn'          => __( 'RotateIn (Pro)', 'logo-carousel-free' ),
					'rotateInDownLeft'  => __( 'RotateInDownLeft (Pro)', 'logo-carousel-free' ),
					'rotateInDownRight' => __( 'RotateInDownRight (Pro)', 'logo-carousel-free' ),
					'rotateInUpRight'   => __( 'RotateInUpRight (Pro)', 'logo-carousel-free' ),
					'jackInTheBox'      => __( 'JackInTheBox (Pro)', 'logo-carousel-free' ),
					'slideInDown'       => __( 'SlideInDown (Pro)', 'logo-carousel-free' ),
					'slideInLeft'       => __( 'SlideInLeft (Pro)', 'logo-carousel-free' ),
					'slideInRight'      => __( 'SlideInRight (Pro)', 'logo-carousel-free' ),
					'slideInUp'         => __( 'SlideInUp (Pro)', 'logo-carousel-free' ),
				),
				'default'    => 'off',
				'dependency' => array( 'lcp_logo_image|lcp_logo_carousel_mode', '==|any', 'true|standard,ticker', true ),
			),
			array(
				'id'         => 'lcp_logo_blur_effect',
				'type'       => 'switcher',
				'class'      => 'lcp_only_pro',
				'title'      => __( 'Blur', 'logo-carousel-free' ),
				'subtitle'   => __( 'Enable/Disable loge image blur effect.', 'logo-carousel-free' ),
				'default'    => false,
				'text_on'    => __( 'Enabled', 'logo-carousel-free' ),
				'text_off'   => __( 'Disabled', 'logo-carousel-free' ),
				'text_width' => 95,
				'dependency' => array( 'lcp_logo_image', '==', 'true', true ),

			),
			array(
				'id'         => 'lcp_logo_opacity',
				'type'       => 'slider',
				'class'      => 'sp-lc-opacity',
				'title'      => __( 'Opacity', 'logo-carousel-free' ),
				'subtitle'   => __( 'Set opacity for the logo images.', 'logo-carousel-free' ),
				'step'       => 0.01,
				'min'        => 0.01,
				'max'        => 1,
				'default'    => 1,
				'dependency' => array( 'lcp_logo_image', '==', 'true', true ),

			),
			array(
				'id'         => 'lcp_logo_gray_scale',
				'type'       => 'select',
				'class'      => 'order_by_pro',
				'title'      => __( 'Image Mode', 'logo-carousel-free' ),
				'subtitle'   => __( 'Set a mode for logo images.', 'logo-carousel-free' ),
				'options'    => array(
					'off'              => __( 'Normal', 'logo-carousel-free' ),
					'gray_with_normal' => __( 'Grayscale and normal on hover (Pro)', 'logo-carousel-free' ),
					'gray_on_hover'    => __( 'Grayscale on hover (Pro)', 'logo-carousel-free' ),
					'always_gray'      => __( 'Always grayscale (Pro)', 'logo-carousel-free' ),
					'custom-color'     => __( 'Custom Color (Pro)', 'logo-carousel-free' ),
				),
				'default'    => 'off',
				'dependency' => array( 'lcp_logo_image', '==', 'true', true ),
			),
			array(
				'id'         => 'lcp_grid_inline_vertical_alignment',
				'type'       => 'select',
				'class'      => 'order_by_pro',
				'title'      => __( 'Vertical Alignment', 'logo-carousel-free' ),
				'subtitle'   => __( 'Select vertical alignment type.', 'logo-carousel-free' ),
				'options'    => array(
					'middle' => __( 'Middle', 'logo-carousel-free' ),
					'bottom' => __( 'Bottom (Pro)', 'logo-carousel-free' ),
					'top'    => __( 'Top (Pro)', 'logo-carousel-free' ),
				),
				'default'    => 'middle',
				'dependency' => array( 'lcp_logo_image', '==', 'true', true ),
			),
			array(
				'id'         => 'lcp_image_title_attr',
				'type'       => 'checkbox',
				'title'      => __( 'Logo Title Attribute', 'logo-carousel-free' ),
				'subtitle'   => __( 'Check to add logo title attribute.', 'logo-carousel-free' ),
				'default'    => false,
				'dependency' => array( 'lcp_logo_image', '==', 'true', true ),
			),
		),
	)
);



// Carousel Controls.
SPLC::createSection(
	$prefix,
	array(
		'title'  => __( 'Carousel Controls', 'logo-carousel-free' ),
		'icon'   => 'fa fa-sliders',
		'fields' => array(
			array(
				'id'         => 'lcp_vertical_horizontal',
				'type'       => 'button_set',
				'class'      => 'sp-lc-pro-only',
				'title'      => __( 'Carousel Orientation', 'logo-carousel-free' ),
				'subtitle'   => __( 'Choose a carousel orientation.', 'logo-carousel-free' ),
				'options'    => array(
					'horizontal' => __( 'Horizontal', 'logo-carousel-free' ),
					'vertical'   => __( 'Vertical', 'logo-carousel-free' ),
				),
				'default'    => 'horizontal',
				'dependency' => array( 'lcp_layout', '==', 'carousel', true ),
			),
			array(
				'type'       => 'switcher',
				'id'         => 'lcp_carousel_auto_play',
				'title'      => __( 'AutoPlay', 'logo-carousel-free' ),
				'subtitle'   => __( 'Enable/Disable autoplay for the carousel.', 'logo-carousel-free' ),
				'text_on'    => __( 'Enabled', 'logo-carousel-free' ),
				'text_off'   => __( 'Disabled', 'logo-carousel-free' ),
				'text_width' => 95,
				'default'    => true,
			),
			array(
				'id'         => 'lcp_carousel_auto_play_speed',
				'type'       => 'spinner',
				'title'      => __( 'AutoPlay Speed', 'logo-carousel-free' ),
				'subtitle'   => __( 'Set auto play speed in millisecond.', 'logo-carousel-free' ),
				'unit'       => __( 'ms', 'logo-carousel-free' ),
				'sanitize'   => 'splogocarousel_sanitize_number_field',
				'default'    => '3000',
				'min'        => 1,
				'step'       => 10,
				'max'        => 15000,
				'dependency' => array(
					'lcp_carousel_auto_play',
					'==',
					'true',
					true,
				),
			),
			array(
				'id'       => 'lcp_carousel_scroll_speed',
				'type'     => 'spinner',
				'title'    => __( 'Pagination Speed', 'logo-carousel-free' ),
				'subtitle' => __( 'Set pagination/slide scroll speed in millisecond.', 'logo-carousel-free' ),
				'unit'     => __( 'ms', 'logo-carousel-free' ),
				'sanitize' => 'splogocarousel_sanitize_number_field',
				'max'      => 6000,
				'step'     => 10,
				'default'  => '600',
			),
			array(
				'id'         => 'lcp_carousel_pause_on_hover',
				'type'       => 'switcher',
				'title'      => __( 'Pause on Hover', 'logo-carousel-free' ),
				'subtitle'   => __( 'Enable/Disable pause on hover carousel.', 'logo-carousel-free' ),
				'text_on'    => __( 'Enabled', 'logo-carousel-free' ),
				'text_off'   => __( 'Disabled', 'logo-carousel-free' ),
				'text_width' => 95,
				'default'    => true,
				'dependency' => array(
					'lcp_carousel_auto_play',
					'==',
					'true',
					true,
				),
			),
			array(
				'id'       => 'lcp_slides_to_scroll',
				'type'     => 'column',
				'class'    => 'pro_only_field',
				'title'    => __( 'Slide To Scroll', 'logo-carousel-free' ),
				'subtitle' => __( 'Set number of slide to scroll on devices.', 'logo-carousel-free' ),
				'sanitize' => 'splogocarousel_sanitize_number_array_field',
				'default'  => array(
					'lg_desktop'       => '1',
					'desktop'          => '1',
					'tablet'           => '1',
					'mobile_landscape' => '1',
					'mobile'           => '1',
				),
				'min'      => '1',
			),
			array(
				'id'         => 'lcp_carousel_infinite',
				'type'       => 'switcher',
				'title'      => __( 'Infinite Loop', 'logo-carousel-free' ),
				'subtitle'   => __( 'Enable/Disable infinite looping for the carousel.', 'logo-carousel-free' ),
				'text_on'    => __( 'Enabled', 'logo-carousel-free' ),
				'text_off'   => __( 'Disabled', 'logo-carousel-free' ),
				'text_width' => 95,
				'default'    => true,
			),
			array(
				'id'       => 'lcp_rtl_mode',
				'type'     => 'button_set',
				'title'    => __( 'Carousel Direction', 'logo-carousel-free' ),
				'subtitle' => __( 'Set carousel direction as you need.', 'logo-carousel-free' ),
				'options'  => array(
					'false' => __( 'Right to Left', 'logo-carousel-free' ),
					'true'  => __( 'Left to Right', 'logo-carousel-free' ),
				),
				'default'  => 'false',
			),
			array(
				'id'       => 'lcp_rows',
				'type'     => 'column',
				'title'    => __( 'Row', 'logo-carousel-free' ),
				'subtitle' => __( 'Set number of row on devices.', 'logo-carousel-free' ),
				'default'  => array(
					'lg_desktop'       => '1',
					'desktop'          => '1',
					'tablet'           => '1',
					'mobile_landscape' => '1',
					'mobile'           => '1',
				),
				'min'      => '1',
				'class'    => 'pro_only_field',
			),
			array(
				'type'    => 'notice',
				'style'   => 'normal',
				'content' => __( 'To unlock vertical carousel, slide to scroll, multiple rows carousel, and many more amazing settings, <a href="https://logocarousel.com/pricing/?ref=1" target="_blank"><b>Upgrade To Pro!</b></a>', 'logo-carousel-free' ),
			),
			array(
				'type'    => 'subheading',
				'content' => __( 'Navigation', 'logo-carousel-free' ),
			),
			array(
				'id'       => 'lcp_nav_show',
				'type'     => 'button_set',
				'title'    => __( 'Navigation', 'logo-carousel-free' ),
				'subtitle' => __( 'Show/hide navigation.', 'logo-carousel-free' ),
				'options'  => array(
					'show'           => __( 'Show', 'logo-carousel-free' ),
					'hide'           => __( 'Hide', 'logo-carousel-free' ),
					'hide_on_mobile' => __( 'Hide on Mobile', 'logo-carousel-free' ),
				),
				'default'  => 'show',
			),
			array(
				'id'         => 'lcp_nav_position',
				'type'       => 'select',
				'class'      => 'order_by_pro',
				'title'      => __( 'Position', 'logo-carousel-free' ),
				'subtitle'   => __( 'Select a position of the navigation arrows.', 'logo-carousel-free' ),
				'options'    => array(
					'top_right'                   => __( 'Top right', 'logo-carousel-free' ),
					'top_center'                  => __( 'Top center (Pro)', 'logo-carousel-free' ),
					'top_left'                    => __( 'Top left (Pro)', 'logo-carousel-free' ),
					'bottom_left'                 => __( 'Bottom left (Pro)', 'logo-carousel-free' ),
					'bottom_center'               => __( 'Bottom center (Pro)', 'logo-carousel-free' ),
					'bottom_right'                => __( 'Bottom right (Pro)', 'logo-carousel-free' ),
					'vertical_center'             => __( 'Vertically center (Pro)', 'logo-carousel-free' ),
					'vertical_center_inner'       => __( 'Vertically center inner (Pro)', 'logo-carousel-free' ),
					'vertical_center_inner_hover' => __( 'Vertically center inner on hover (Pro)', 'logo-carousel-free' ),
				),
				'default'    => 'top_right',
				'dependency' => array(
					'lcp_nav_show',
					'!=',
					'hide',
				),
			),
			array(
				'id'         => 'lcp_nav_color',
				'type'       => 'color_group',
				'title'      => __( 'Color', 'logo-carousel-free' ),
				'subtitle'   => __( 'Set navigation color.', 'logo-carousel-free' ),
				'options'    => array(
					'color1' => __( 'Color', 'logo-carousel-free' ),
					'color2' => __( 'Hover Color', 'logo-carousel-free' ),
					'color3' => __( 'Background', 'logo-carousel-free' ),
					'color4' => __( 'Hover Background', 'logo-carousel-free' ),
				),
				'default'    => array(
					'color1' => '#aaaaaa',
					'color2' => '#ffffff',
					'color3' => 'transparent',
					'color4' => '#16a08b',
				),
				'dependency' => array(
					'lcp_nav_show',
					'!=',
					'hide',
				),
			),
			array(
				'id'          => 'lcp_nav_border',
				'type'        => 'border',
				'title'       => __( 'Border', 'logo-carousel-free' ),
				'subtitle'    => __( 'Set border for navigation.', 'logo-carousel-free' ),
				'all'         => true,
				'default'     => array(
					'all'         => '1',
					'style'       => 'solid',
					'color'       => '#aaaaaa',
					'hover_color' => '#16a08b',
				),
				'dependency'  => array(
					'lcp_nav_show',
					'!=',
					'hide',
				),
				'hover_color' => true,
			),
			array(
				'type'    => 'subheading',
				'content' => __( 'Pagination', 'logo-carousel-free' ),
			),
			array(
				'id'       => 'lcp_carousel_dots',
				'type'     => 'button_set',
				'title'    => __( 'Pagination', 'logo-carousel-free' ),
				'subtitle' => __( 'Show/hide pagination dots.', 'logo-carousel-free' ),
				'options'  => array(
					'show'           => __( 'Show', 'logo-carousel-free' ),
					'hide'           => __( 'Hide', 'logo-carousel-free' ),
					'hide_on_mobile' => __( 'Hide on Mobile', 'logo-carousel-free' ),
				),
				'default'  => 'show',
			),
			array(
				'id'         => 'lcp_carousel_dots_color',
				'type'       => 'color_group',
				'title'      => __( 'Color', 'logo-carousel-free' ),
				'subtitle'   => __( 'Set pagination dots color.', 'logo-carousel-free' ),
				'options'    => array(
					'color1' => __( 'Color', 'logo-carousel-free' ),
					'color2' => __( 'Active Color', 'logo-carousel-free' ),
				),
				'default'    => array(
					'color1' => '#dddddd',
					'color2' => '#16a08b',
				),
				'dependency' => array(
					'lcp_carousel_dots',
					'!=',
					'hide',
				),
			),
			array(
				'type'    => 'subheading',
				'content' => __( 'Miscellaneous', 'logo-carousel-free' ),
			),
			array(
				'id'         => 'lcp_carousel_swipe',
				'type'       => 'switcher',
				'title'      => __( 'Touch Swipe', 'logo-carousel-free' ),
				'subtitle'   => __( 'Enable/Disable touch swipe mode.', 'logo-carousel-free' ),
				'default'    => true,
				'text_on'    => __( 'Enabled', 'logo-carousel-free' ),
				'text_off'   => __( 'Disabled', 'logo-carousel-free' ),
				'text_width' => 95,
			),
			array(
				'id'         => 'lcp_carousel_draggable',
				'type'       => 'switcher',
				'title'      => __( 'Mouse Draggable', 'logo-carousel-free' ),
				'subtitle'   => __( 'Enable/Disable mouse draggable mode.', 'logo-carousel-free' ),
				'text_on'    => __( 'Enabled', 'logo-carousel-free' ),
				'text_off'   => __( 'Disabled', 'logo-carousel-free' ),
				'text_width' => 95,
				'default'    => true,
			),
			array(
				'id'         => 'lcp_free_mode',
				'type'       => 'switcher',
				'title'      => __( 'Free Mode', 'logo-carousel-free' ),
				'subtitle'   => __( 'Enable/Disable carousel free mode.', 'logo-carousel-free' ),
				'text_on'    => __( 'Enabled', 'logo-carousel-free' ),
				'text_off'   => __( 'Disabled', 'logo-carousel-free' ),
				'text_width' => 95,
				'default'    => false,
			),
		),
	)
);

// Typography.
SPLC::createSection(
	$prefix,
	array(
		'title'  => __( 'Typography', 'logo-carousel-free' ),
		'icon'   => 'fa fa-font',
		'fields' => array(
			array(
				'type'    => 'notice',
				'style'   => 'normal',
				'content' => __( 'To unlock the following Typography (950+ Google Fonts) options, <b><a href="https://logocarousel.com/pricing/?ref=1" target="_blank">Upgrade To Pro</a></b>!', 'logo-carousel-free' ),
			),
			array(
				'id'            => 'lcp_section_title_typography',
				'type'          => 'typography',
				'class'         => 'lcp_section_title_typography',
				'title'         => __( 'Section Title Font', 'logo-carousel-free' ),
				'subtitle'      => __( 'Set section title font properties.', 'logo-carousel-free' ),
				'default'       => array(
					'font-family'    => 'Ubuntu',
					'font-weight'    => 'regular',
					'type'           => 'google',
					'font-size'      => '24',
					'line-height'    => '32',
					'text-align'     => 'left',
					'text-transform' => 'none',
					'letter-spacing' => '',
					'color'          => '#222',
					'margin-bottom'  => '30',
				),
				'color'         => true, // Enable or disable preview box.
				'margin_bottom' => true,
				'preview'       => 'always', // Enable or disable preview box.
				'preview_text'  => 'The Section Title', // Replace preview text with any text you like.
			),
			array(
				'id'           => 'lcp_logo_title_typography',
				'type'         => 'typography',
				'title'        => __( 'Logo Title Font', 'logo-carousel-free' ),
				'subtitle'     => __( 'Set logo title font properties', 'logo-carousel-free' ),
				'default'      => array(
					'font-family'    => 'Ubuntu',
					'font-weight'    => 'regular',
					'type'           => 'google',
					'font-size'      => '14',
					'line-height'    => '21',
					'text-align'     => 'center',
					'text-transform' => 'none',
					'letter-spacing' => '',
					'color'          => '#2f2f2f',
				),
				'color'        => true, // Enable or disable preview box.
				'preview'      => 'always', // Enable or disable preview box.
				'preview_text' => 'The Logo Title', // Replace preview text with any text you like.
			),
			array(
				'id'           => 'lcp_logo_description_typography',
				'type'         => 'typography',
				'title'        => __( 'Logo Body/Description Font', 'logo-carousel-free' ),
				'subtitle'     => __( 'Set logo description font properties', 'logo-carousel-free' ),
				'default'      => array(
					'font-family'    => 'Ubuntu',
					'font-weight'    => 'regular',
					'type'           => 'google',
					'font-size'      => '14',
					'line-height'    => '21',
					'text-align'     => 'center',
					'text-transform' => 'none',
					'letter-spacing' => '',
					'color'          => '#555',
				),
				'color'        => true, // Enable or disable color field.
				'preview'      => 'always', // Enable or disable preview box.
				'preview_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
				// Replace preview text with any text you like.
			),
			array(
				'id'           => 'lcp_read_more_typography',
				'type'         => 'typography',
				'title'        => __( 'Read More Font', 'logo-carousel-free' ),
				'subtitle'     => __( 'Set description read more font properties', 'logo-carousel-free' ),
				'default'      => array(
					'font-family'    => 'Ubuntu',
					'font-weight'    => 'regular',
					'type'           => 'google',
					'font-size'      => '14',
					'line-height'    => '20',
					'text-align'     => 'left',
					'text-transform' => 'none',
					'letter-spacing' => '',
				),
				'preview'      => 'always', // Enable or disable preview box.
				'preview_text' => 'Learn More', // Replace preview text with any text you like.
			),
			array(
				'id'           => 'lcp_logo_popup_title_typography',
				'type'         => 'typography',
				'title'        => __( 'Popup Title Font', 'logo-carousel-free' ),
				'subtitle'     => __( 'Set logo popup title font properties', 'logo-carousel-free' ),
				'default'      => array(
					'font-family'    => 'Ubuntu',
					'font-weight'    => 'regular',
					'type'           => 'google',
					'font-size'      => '22',
					'line-height'    => '24',
					'text-align'     => 'left',
					'text-transform' => 'none',
					'letter-spacing' => '',
					'color'          => '#2f2f2f',
				),
				'color'        => true, // Enable or disable preview box.
				'preview'      => 'always', // Enable or disable preview box.
				'preview_text' => 'The Logo Title', // Replace preview text with any text you like.
			),
			array(
				'id'           => 'lcp_logo_popup_description_typography',
				'type'         => 'typography',
				'title'        => __( 'Popup Description Font', 'logo-carousel-free' ),
				'subtitle'     => __( 'Set logo popup description font properties', 'logo-carousel-free' ),
				'default'      => array(
					'font-family'    => 'Ubuntu',
					'font-weight'    => 'regular',
					'type'           => 'google',
					'font-size'      => '14',
					'line-height'    => '23',
					'text-align'     => 'left',
					'text-transform' => 'none',
					'letter-spacing' => '',
					'color'          => '#555',
				),
				'color'        => true, // Enable or disable color field.
				'preview'      => 'always', // Enable or disable preview box.
				'preview_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
				// Replace preview text with any text you like.
			),

		),
	)
);

$prefix = 'sp_logo_carousel_link_option';

// -----------------------------------------
// Logo Link Metabox Options               -
// -----------------------------------------
SPLC::createMetabox(
	$prefix,
	array(
		'title'     => __( 'Logo Link URL', 'logo-carousel-free' ),
		'post_type' => 'sp_logo_carousel',
		'context'   => 'normal',
		'priority'  => 'default',
	)
);

// Logo link.
SPLC::createSection(
	$prefix,
	array(
		'fields' => array(
			array(
				'id'         => 'lcp_logo_link',
				'type'       => 'text',
				'class'      => 'lcp_logo_link',
				'title'      => __( 'Custom URL', 'logo-carousel-free' ),
				'desc'       => __( ' To add a custom link URL for the logo, <a href="https://logocarousel.com/pricing/?ref=1" target="_blank">Upgrade To Pro!</a>', 'logo-carousel-free' ),
				'attributes' => array(
					'placeholder' => 'http://example.com',
					'disabled'    => 'disabled',
				),
			),
		),
	)
);

<?php
/**
 * Options config
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access pages directly.

// Setting prefix.
$prefix = '_sp_lcpro_options';

// Create options.
SPLC::createOptions(
	$prefix,
	array(
		'menu_title'       => __( 'Settings', 'logo-carousel-free' ),
		'menu_parent'      => 'edit.php?post_type=sp_logo_carousel',
		'menu_type'        => 'submenu', // menu, submenu, options, theme, etc.
		'menu_slug'        => 'lc_settings',
		'class'            => 'lcpro_setting_options',
		'ajax_save'        => true,
		'show_reset_all'   => false,
		'show_search'      => false,
		'show_all_options' => false,
		'show_footer'      => false,
		'show_bar_menu'    => false,
		'framework_title'  => __( 'Settings', 'logo-carousel-free' ),
	)
);


// Advanced Settings.
SPLC::createSection(
	$prefix,
	array(
		'id'     => 'advanced_settings',
		'title'  => __( 'Advanced Settings', 'logo-carousel-free' ),
		'icon'   => 'fa fa-cogs',
		'fields' => array(

			array(
				'id'      => 'lcpro_data_remove',
				'type'    => 'checkbox',
				'title'   => __( 'Clean-up Data on Deletion', 'logo-carousel-free' ),
				'help'    => __( 'Check this box if you would like Logo Carousel to completely remove all of its data when the plugin is deleted.', 'logo-carousel-free' ),
				'default' => false,
			),
			array(
				'id'      => 'lcpro_enqueue_css_heading',
				'type'    => 'subheading',
				'content' => __( 'CSS Enqueue or Dequeue', 'logo-carousel-free' ),
			),
			array(
				'id'         => 'lcpro_fontawesome_css',
				'type'       => 'switcher',
				'title'      => __( 'FontAwesome CSS', 'logo-carousel-free' ),
				'default'    => true,
				'text_on'    => __( 'Enqueue', 'logo-carousel-free' ),
				'text_off'   => __( 'Dequeue', 'logo-carousel-free' ),
				'text_width' => 95,
			),
			array(
				'id'         => 'lcpro_swiper_css',
				'type'       => 'switcher',
				'title'      => __( 'Swiper CSS', 'logo-carousel-free' ),
				'default'    => true,
				'text_on'    => __( 'Enqueue', 'logo-carousel-free' ),
				'text_off'   => __( 'Dequeue', 'logo-carousel-free' ),
				'text_width' => 95,
			),
			array(
				'id'      => 'lcpro_enqueue_js_heading',
				'type'    => 'subheading',
				'content' => __( 'JS Enqueue or Dequeue', 'logo-carousel-free' ),
			),
			array(
				'id'         => 'lcpro_swiper_js',
				'type'       => 'switcher',
				'title'      => __( 'Swiper JS', 'logo-carousel-free' ),
				'default'    => true,
				'text_on'    => __( 'Enqueue', 'logo-carousel-free' ),
				'text_off'   => __( 'Dequeue', 'logo-carousel-free' ),
				'text_width' => 95,
			),
		),
	)
);

// Custom CSS.
SPLC::createSection(
	$prefix,
	array(
		'id'     => 'custom_css_section',
		'title'  => __( 'Custom CSS', 'logo-carousel-free' ),
		'icon'   => 'fa fa-css3',
		'fields' => array(

			array(
				'id'       => 'lcpro_custom_css',
				'type'     => 'code_editor',
				'sanitize' => 'wp_strip_all_tags',
				'settings' => array(
					'theme' => 'mbo',
					'mode'  => 'css',
				),
				'title'    => __( 'Custom CSS', 'logo-carousel-free' ),
			),
		),
	)
);

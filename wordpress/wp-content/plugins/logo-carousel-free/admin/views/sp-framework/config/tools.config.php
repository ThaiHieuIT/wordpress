<?php
/**
 * Option tools config
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

//
// Set a unique slug-like ID.
//
$prefix = 'sp_lcp_tools';

//
// Create options.
//
SPLC::createOptions(
	$prefix,
	array(
		'menu_title'       => __( 'Tools', 'logo-carousel-free' ),
		'menu_slug'        => 'lcpro_tools',
		'menu_parent'      => 'edit.php?post_type=sp_logo_carousel',
		'menu_type'        => 'submenu',
		'ajax_save'        => false,
		'show_bar_menu'    => false,
		'save_defaults'    => false,
		'show_reset_all'   => false,
		'show_all_options' => false,
		'show_search'      => false,
		'show_footer'      => false,
		'show_buttons'     => false, // Custom show button option added for hide save button in tools page.
		'framework_title'  => __( 'Tools', 'logo-carousel-free' ),
		'framework_class'  => 'lcpro_setting_options lcpro_tools',
	)
);
SPLC::createSection(
	$prefix,
	array(
		'title'  => __( 'Export', 'logo-carousel-free' ),
		'fields' => array(
			array(
				'id'       => 'lcp_what_export',
				'type'     => 'radio',
				'class'    => 'lcp_what_export',
				'title'    => __( 'Choose What To Export', 'logo-carousel-free' ),
				'multiple' => false,
				'options'  => array(
					'all_logos'           => __( 'All Logos', 'logo-carousel-free' ),
					'all_shortcodes'      => __( 'All Logo Carousels (Shortcodes)', 'logo-carousel-free' ),
					'selected_shortcodes' => __( 'Selected Logo Carousels (Shortcodes)', 'logo-carousel-free' ),
				),
				'default'  => 'all_logos',
			),
			array(
				'id'          => 'lcp_post',
				'class'       => 'lcp_post_ids',
				'type'        => 'select',
				'title'       => ' ',
				'options'     => 'sp_lc_shortcodes',
				'chosen'      => true,
				'sortable'    => false,
				'multiple'    => true,
				'placeholder' => __( 'Choose shortcode(s)', 'logo-carousel-free' ),
				'query_args'  => array(
					'posts_per_page' => -1,
				),
				'dependency'  => array( 'lcp_what_export', '==', 'selected_shortcodes', true ),

			),
			array(
				'id'      => 'export',
				'class'   => 'lcp_export',
				'type'    => 'button_set',
				'title'   => ' ',
				'options' => array(
					'' => 'Export',
				),
			),
		),
	)
);
SPLC::createSection(
	$prefix,
	array(
		'title'  => __( 'Import', 'logo-carousel-free' ),
		'fields' => array(
			array(
				'class' => 'lcp_import',
				'type'  => 'custom_import',
				'title' => __( 'Import JSON File To Upload', 'logo-carousel-free' ),
			),
		),
	)
);

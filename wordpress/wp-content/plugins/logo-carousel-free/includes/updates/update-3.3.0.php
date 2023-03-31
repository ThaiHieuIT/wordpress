<?php
/**
 * Update version.
 *
 * @package logo-carousel-free
 */

update_option( 'logo_carousel_free_version', '3.3.0' );
update_option( 'logo_carousel_free_db_version', '3.3.0' );

/**
 * Update old to new typography.
 */
$args          = new WP_Query(
	array(
		'post_type'      => 'sp_lc_shortcodes',
		'post_status'    => 'any',
		'posts_per_page' => '300',
	)
);
$shortcode_ids = wp_list_pluck( $args->posts, 'ID' );

if ( count( $shortcode_ids ) > 0 ) {
	foreach ( $shortcode_ids as $shortcode_key => $shortcode_id ) {

		$logo_shortcode_data  = array();
		$column_number        = intval( get_post_meta( $shortcode_id, 'lc_number_of_column', true ) );
		$column_number_dt     = intval( get_post_meta( $shortcode_id, 'lc_number_of_column_dt', true ) );
		$column_number_smdt   = intval( get_post_meta( $shortcode_id, 'lc_number_of_column_smdt', true ) );
		$column_number_tablet = intval( get_post_meta( $shortcode_id, 'lc_number_of_column_tablet', true ) );
		$column_number_mobile = intval( get_post_meta( $shortcode_id, 'lc_number_of_column_mobile', true ) );
		$old_brand_color      = get_post_meta( $shortcode_id, 'lc_brand_color', true );
		$old_nav_arrow_color  = get_post_meta( $shortcode_id, 'lc_nav_arrow_color', true );
		$old_pagination_color = get_post_meta( $shortcode_id, 'lc_pagination_color', true );
		$old_logo_border      = get_post_meta( $shortcode_id, 'lc_logo_border', true );

		$logo_shortcode_data['lcp_number_of_columns']        = array(
			'lg_desktop'       => $column_number,
			'desktop'          => $column_number_dt,
			'tablet'           => $column_number_smdt,
			'mobile_landscape' => $column_number_tablet,
			'mobile'           => $column_number_mobile,
		);
		$old_show_navigation                                 = ( 'on' === get_post_meta( $shortcode_id, 'lc_show_navigation', true ) ) ? 'show' : 'hide';
		$old_show_pagination_dots                            = ( 'on' === get_post_meta( $shortcode_id, 'lc_show_pagination_dots', true ) ) ? 'show' : 'hide';
		$logo_shortcode_data['lcp_nav_show']                 = $old_show_navigation;
		$logo_shortcode_data['lcp_carousel_dots']            = $old_show_pagination_dots;
		$logo_shortcode_data['lcp_carousel_auto_play']       = ( 'on' === get_post_meta( $shortcode_id, 'lc_auto_play', true ) ) ? true : false;
		$logo_shortcode_data['lcp_carousel_pause_on_hover']  = ( 'on' === get_post_meta( $shortcode_id, 'lc_pause_on_hover', true ) ) ? true : false;
		$logo_shortcode_data['lcp_carousel_swipe']           = ( 'on' === get_post_meta( $shortcode_id, 'lc_touch_swipe', true ) ) ? true : false;
		$logo_shortcode_data['lcp_carousel_draggable']       = ( 'on' === get_post_meta( $shortcode_id, 'lc_mouse_draggable', true ) ) ? true : false;
		$logo_shortcode_data['lcp_rtl_mode']                 = ( 'on' === get_post_meta( $shortcode_id, 'lc_logo_rtl', true ) ) ? 'true' : 'false';
		$logo_shortcode_data['lcp_carousel_auto_play_speed'] = get_post_meta( $shortcode_id, 'lc_auto_play_speed', true );

		$logo_shortcode_data['lcp_carousel_scroll_speed'] = get_post_meta( $shortcode_id, 'lc_scroll_speed', true );

		$logo_shortcode_data['lcp_number_of_total_items'] = intval( get_post_meta( $shortcode_id, 'lc_number_of_total_logos', true ) );

		$logo_shortcode_data['lcp_nav_color']  = array(
			'color1' => $old_nav_arrow_color,
			'color2' => '#ffffff',
			'color3' => '#f0f0f0',
			'color4' => $old_brand_color,
		);
		$logo_shortcode_data['lcp_nav_border'] = array(
			'all'         => '0',
			'style'       => 'solid',
			'color'       => '#afafaf',
			'hover_color' => $old_brand_color,
		);
		$logo_border                           = '0';
		if ( 'on' === $old_logo_border ) {
			$logo_border = '1';
		}
		$logo_shortcode_data['lcp_logo_border']         = array(
			'all'         => $logo_border,
			'style'       => 'solid',
			'color'       => '#dddddd',
			'hover_color' => $old_brand_color,
		);
		$logo_shortcode_data['lcp_carousel_dots_color'] = array(
			'color1' => $old_pagination_color,
			'color2' => $old_brand_color,
		);
		$logo_shortcode_data['lcp_item_order_by']       = get_post_meta( $shortcode_id, 'lc_logos_order_by', true );
		$logo_shortcode_data['lcp_item_order']          = get_post_meta( $shortcode_id, 'lc_logos_order', true );

		update_post_meta( $shortcode_id, 'sp_lcp_shortcode_options', $logo_shortcode_data );
	}
}

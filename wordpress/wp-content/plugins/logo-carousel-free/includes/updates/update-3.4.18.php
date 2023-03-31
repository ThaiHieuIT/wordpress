<?php
/**
 * Update version.
 *
 * @package logo-carousel-free
 */

update_option( 'logo_carousel_free_version', '3.4.18' );
update_option( 'logo_carousel_free_db_version', '3.4.18' );

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

		$logo_shortcode_data = get_post_meta( $shortcode_id, 'sp_lcp_shortcode_options', true );

		if ( ! is_array( $logo_shortcode_data ) ) {
			continue;
		}

		$old_margin_between = isset( $logo_shortcode_data['lcp_logo_margin']['all'] ) ? (int) $logo_shortcode_data['lcp_logo_margin']['all'] : '12';
		if ( isset( $logo_shortcode_data['lcp_logo_margin']['all'] ) ) {
			$logo_shortcode_data['lcp_logo_margin']['vertical'] = $old_margin_between;
		}

		$section_title_margin_bottom = isset( $logo_shortcode_data['lcp_section_title_margin']['bottom'] ) ? $logo_shortcode_data['lcp_section_title_margin']['bottom'] : '30';

		if ( isset( $logo_shortcode_data['lcp_section_title_margin']['bottom'] ) ) {
			$logo_shortcode_data['lcp_section_title_typography']['margin-bottom'] = $section_title_margin_bottom;
		}

		if ( isset( $logo_shortcode_data['lcp_logo_shadow_type'] ) && 'off' === $logo_shortcode_data['lcp_logo_shadow_type'] ) {
			$logo_shortcode_data['lcp_logo_shadow_type'] = 'none';
		}

		update_post_meta( $shortcode_id, 'sp_lcp_shortcode_options', $logo_shortcode_data );
	}
}

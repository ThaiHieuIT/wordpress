<?php
/**
 * Uninstall.php for cleaning plugin database.
 *
 * Trigger the file when plugin is deleted.
 *
 * @see delete_option(), delete_post_meta_key()
 * @since 3.3.0
 * @package logo Carousel free
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

/**
 * Delete plugin data function.
 *
 * @return void
 */
function sp_lcp_delete_plugin_data() {

	// Delete plugin option settings.
	$option_name = '_sp_lcpro_options';
	delete_option( $option_name );
	delete_site_option( $option_name ); // For site options in Multisite.

	// Delete carousel post type.
	$carousel_posts = get_posts(
		array(
			'numberposts' => 10000,
			'post_type'   => array( 'sp_logo_carousel', 'sp_lc_shortcodes' ),
			'post_status' => 'any',
		)
	);
	foreach ( $carousel_posts as $post ) {
		wp_delete_post( $post->ID, true );
	}

	// Delete Carousel post meta.
	delete_post_meta_by_key( 'sp_lcp_shortcode_options' );
	delete_post_meta_by_key( 'sp_logo_carousel_link_option' );
}

	// Load lc file.
	require plugin_dir_path( __FILE__ ) . '/main.php';
	$sp_lc_plugin_settings = get_option( '_sp_lcpro_options' );
	$delate_plugin_data    = $sp_lc_plugin_settings['lcpro_data_remove'];

if ( $delate_plugin_data ) {
	sp_lcp_delete_plugin_data();
}

<?php
/**
 * Preloader.
 *
 * @package    logo-carousel-free
 * @subpackage logo-carousel-free/public
 */

if ( $preloader ) {
	$preloader_class = ' lcp-preloader';
	$preloader_image = SP_LC_URL . 'admin/assets/images/spinner.svg';
	if ( ! empty( $preloader_image ) ) {
		$output .= '<div id="lcp-preloader-' . esc_attr( $post_id ) . '" class="sp-logo-carousel-preloader"><img src="' . esc_url( $preloader_image ) . '" alt="loader-image"/></div>';
	}
}

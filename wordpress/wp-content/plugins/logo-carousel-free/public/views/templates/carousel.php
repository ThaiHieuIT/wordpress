<?php
/**
 * Carousel output wrapper.
 *
 * @package    logo-carousel-free
 * @subpackage logo-carousel-free/public
 */

$output .= "<div id='logo-carousel-free-$post_id' class=\"logo-carousel-free logo-carousel-free-area sp-lc-container\">";
// Preloader.
require SP_LC_PATH . 'public/views/templates/preloader.php';
// Section title.
require SP_LC_PATH . 'public/views/templates/section-title.php';
$output .= '<div id="sp-logo-carousel-id-' . esc_attr( $post_id ) . '" class="swiper-container sp-logo-carousel' . esc_attr( $preloader_class ) . '" dir="' . esc_attr( $rtl ) . '"  ' . $swiper_data_attr . '><div class="swiper-wrapper">';
require SP_LC_PATH . 'public/views/loop/single-item.php';
$output .= '</div>';
if ( 'true' === $dots || 'true' === $dots_mobile ) {
	$output .= '<div class="sp-lc-pagination swiper-pagination dots"></div>';
}
if ( 'true' === $nav || 'true' === $nav_mobile ) {
	$output .= '<div class="sp-lc-button-next"><i class="fa fa-angle-right"></i></div>';
	$output .= '<div class="sp-lc-button-prev"><i class="fa fa-angle-left"></i></div>';
}
$output .= '</div>';
$output .= '</div>';

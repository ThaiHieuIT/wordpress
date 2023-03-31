<?php
/**
 * Dynamic sytle.
 *
 * @package Logo Carousel free
 */

$section_title_margin_bottom = isset( $logo_data['lcp_section_title_typography']['margin-bottom'] ) ? $logo_data['lcp_section_title_typography']['margin-bottom'] : '30';
$nav_color_data              = isset( $logo_data['lcp_nav_color'] ) ? $logo_data['lcp_nav_color'] : '';
$nav_color                   = isset( $nav_color_data['color1'] ) ? $nav_color_data['color1'] : '#aaaaaa';
$nav_hover_color             = isset( $nav_color_data['color2'] ) ? $nav_color_data['color2'] : '#ffffff';
$nav_bg                      = isset( $nav_color_data['color3'] ) ? $nav_color_data['color3'] : '#f0f0f0';
$nav_hover_bg                = isset( $nav_color_data['color4'] ) ? $nav_color_data['color4'] : '#16a08b';
$nav_border                  = isset( $logo_data['lcp_nav_border'] ) ? $logo_data['lcp_nav_border'] : '';
$preloader                   = isset( $logo_data['lcp_preloader'] ) ? $logo_data['lcp_preloader'] : false;

$nav_border_width       = isset( $nav_border['all'] ) ? $nav_border['all'] : '1';
$nav_border_style       = isset( $nav_border['style'] ) ? $nav_border['style'] : 'solid';
$nav_border_color       = isset( $nav_border['color'] ) ? $nav_border['color'] : '#aaaaaa';
$nav_border_hover_color = isset( $nav_border['hover_color'] ) ? $nav_border['hover_color'] : '#16a08b';
$nav_border_width       = (int) $nav_border_width;

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

$dots_color_data         = isset( $logo_data['lcp_carousel_dots_color'] ) ? $logo_data['lcp_carousel_dots_color'] : '';
$dots_color              = isset( $dots_color_data['color1'] ) ? $dots_color_data['color1'] : '#dddddd';
$dots_active_color       = isset( $dots_color_data['color2'] ) ? $dots_color_data['color2'] : '#16a08b';
$logo_border             = isset( $logo_data['lcp_logo_border'] ) ? $logo_data['lcp_logo_border'] : '';
$logo_border_width       = isset( $logo_border['all'] ) ? $logo_border['all'] : 1;
$logo_border_style       = isset( $logo_border['style'] ) ? $logo_border['style'] : 'solid';
$logo_border_color       = isset( $logo_border['color'] ) ? $logo_border['color'] : '#ddd';
$logo_border_hover_color = isset( $logo_border['hover_color'] ) ? $logo_border['hover_color'] : '#ddd';

$dynamic_css .= 'div#logo-carousel-free-' . esc_attr( $post_id ) . '.logo-carousel-free .sp-lc-logo{
	border: ' . esc_attr( $logo_border_width ) . 'px ' . esc_attr( $logo_border_style ) . ' ' . esc_attr( $logo_border_color ) . ';
}';
$dynamic_css .= 'div#logo-carousel-free-' . esc_attr( $post_id ) . '.logo-carousel-free .sp-lc-logo:hover{
	border-color: ' . esc_attr( $logo_border_hover_color ) . ';
}';
if ( 'true' === $dots || 'true' === $dots_mobile ) {
	$dynamic_css .= '#logo-carousel-free-' . esc_attr( $post_id ) . '.sp-lc-container .sp-logo-carousel {
			padding-bottom: 46px;
		}
		#logo-carousel-free-' . esc_attr( $post_id ) . '.sp-lc-container .sp-lc-pagination .swiper-pagination-bullet {
			background-color: ' . esc_attr( $dots_color ) . ';
			margin: 0 4px;
		}
		#logo-carousel-free-' . esc_attr( $post_id ) . '.sp-lc-container .sp-lc-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active{background-color: ' . esc_attr( $dots_active_color ) . '; }
		';
}
if ( 'true' === $nav || 'true' === $nav_mobile ) {
	$dynamic_css .= '#logo-carousel-free-' . esc_attr( $post_id ) . '.sp-lc-container .sp-logo-carousel {
		padding-top: 46px;
	}
	#logo-carousel-free-' . esc_attr( $post_id ) . '.sp-lc-container .sp-lc-button-prev,
	#logo-carousel-free-' . esc_attr( $post_id ) . '.sp-lc-container .sp-lc-button-next {
		color: ' . esc_attr( $nav_color ) . ';
		background: ' . esc_attr( $nav_bg ) . ';
		border: ' . esc_attr( $nav_border_width ) . 'px ' . esc_attr( $nav_border_style ) . ' ' . esc_attr( $nav_border_color ) . ';
		line-height: ' . ( 30 - 2 * $nav_border_width ) . 'px;
	}
	#logo-carousel-free-' . esc_attr( $post_id ) . '.sp-lc-container .sp-lc-button-prev:hover,
	#logo-carousel-free-' . esc_attr( $post_id ) . '.sp-lc-container .sp-lc-button-next:hover{
		background-color: ' . esc_attr( $nav_hover_bg ) . ';
		color: ' . esc_attr( $nav_hover_color ) . ';
		border-color: ' . esc_attr( $nav_border_hover_color ) . ';
	}';
}
	$dynamic_css .= '@media only screen and (max-width: 576px) {';
if ( 'false' === $nav_mobile ) {
	$dynamic_css .= '#logo-carousel-free-' . esc_attr( $post_id ) . '.sp-lc-container .sp-lc-button-prev,
		#logo-carousel-free-' . esc_attr( $post_id ) . '.sp-lc-container .sp-lc-button-next {
			display: none;
		}';
	if ( 'false' === $dots_mobile ) {
		$dynamic_css .= '#logo-carousel-free-' . esc_attr( $post_id ) . '.sp-lc-container .sp-lc-pagination .swiper-pagination-bullet  {
			display: none;
		}';
	}
}
$dynamic_css .= '}';
if ( $preloader ) {
	$dynamic_css .= ' .logo-carousel-free-area#logo-carousel-free-' . esc_attr( $post_id ) . '{
		position: relative;
	}
	#lcp-preloader-' . esc_attr( $post_id ) . '{
		position: absolute;
		left: 0;
		top: 0;
		height: 100%;
		width: 100%;
		text-align: center;
		display: flex;
		align-items: center;
		justify-content: center;
		background: #fff;
		z-index: 9999;
	}';
}
$dynamic_css .= ' .logo-carousel-free-area#logo-carousel-free-' . esc_attr( $post_id ) . ' .sp-logo-carousel-section-title{
	margin-bottom: ' . esc_attr( $section_title_margin_bottom ) . 'px;
}';

// Carousel CSS before swiper init to fix layout shift issue.
$columns                = isset( $logo_data['lcp_number_of_columns'] ) ? $logo_data['lcp_number_of_columns'] : '';
$items                  = isset( $columns['lg_desktop'] ) && $columns['lg_desktop'] > 0 ? $columns['lg_desktop'] : 5;
$logo_margin            = isset( $logo_data['lcp_logo_margin']['all'] ) && $logo_data['lcp_logo_margin']['all'] >= -50 ? (int) $logo_data['lcp_logo_margin']['all'] : '12';
$carouse_rtl_mode       = isset( $logo_data['lcp_rtl_mode'] ) && 'true' === $logo_data['lcp_rtl_mode'] ? true : false;
$padding_left_right_css = $carouse_rtl_mode ? 'padding-left: ' . $logo_margin . 'px;' : 'padding-right: ' . $logo_margin . 'px;';
$dynamic_css           .= '@media screen and (min-width: 1200px ){';
$dynamic_css           .= '.logo-carousel-free-area#logo-carousel-free-' . esc_attr( $post_id ) . ' .sp-logo-carousel:not([class*="-initialized"]) > .swiper-wrapper {
		display: flex;
		width: calc( 100% + ' . $logo_margin . 'px );
	}
	.logo-carousel-free-area#logo-carousel-free-' . esc_attr( $post_id ) . ' .sp-logo-carousel:not([class*="-initialized"]) > .swiper-wrapper > .swiper-slide {
		width: ' . 100 / $items . '%;
		' . $padding_left_right_css . '
	}
}';

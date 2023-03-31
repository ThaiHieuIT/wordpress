<?php
/**
 * Single item from loop.
 *
 * @package    logo-carousel-free
 * @subpackage logo-carousel-free/public
 */

while ( $args->have_posts() ) :
	$args->the_post();
	$ids       = get_the_ID();
	$lcp_thumb = get_post_thumbnail_id();
	$image_url = wp_get_attachment_image_src( $lcp_thumb, $image_sizes );
	if ( ! $image_url ) {
		continue;
	}
	$the_image_title_attr = the_title_attribute( array( 'echo' => false ) );
	$image_title_attr     = $show_image_title_attr ? $the_image_title_attr : '';
	$logo_image_alt       = get_post_meta( $lcp_thumb, '_wp_attachment_image_alt', true );
	$logo_image_alt_tag   = ! empty( $logo_image_alt ) ? $logo_image_alt : get_the_title();
	$image                = has_post_thumbnail() && $show_image ? sprintf( '<img src="%1$s" title="%2$s" alt="%3$s" width="%4$s" height="%5$s" class="sp-lc-image skip-lazy">', esc_url( $image_url[0] ), esc_attr( $image_title_attr ), esc_attr( $logo_image_alt_tag ), esc_attr( $image_url[1] ), esc_attr( $image_url[2] ) ) : '';

	$output .= '<div class="swiper-slide"><div class="sp-lc-logo">' . $image . '</div></div>';
endwhile;
wp_reset_postdata();


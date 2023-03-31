<?php
/**
 * Section title.
 *
 * @package    logo-carousel-free
 * @subpackage logo-carousel-free/public
 */

if ( $section_title ) {
	$output .= '<h2 class="sp-logo-carousel-section-title">' . wp_kses_post( $main_section_title ) . '</h2>';
}

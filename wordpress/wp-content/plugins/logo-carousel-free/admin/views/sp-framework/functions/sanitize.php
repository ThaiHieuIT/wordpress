<?php
/**
 * Framework sanitize.
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! function_exists( 'splogocarousel_sanitize_replace_a_to_b' ) ) {
	/**
	 *
	 * Sanitize
	 * Replace letter a to letter b
	 *
	 * @param  mixed $value value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function splogocarousel_sanitize_replace_a_to_b( $value ) {
		return str_replace( 'a', 'b', $value );
	}
}
if ( ! function_exists( 'splogocarousel_sanitize_number_array_field' ) ) {
	/**
	 *
	 * Sanitize number
	 *
	 * @param  mixed $array value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function splogocarousel_sanitize_number_array_field( $array ) {

		foreach ( $array as $key => $value ) {
			if ( 'unit' === $key ) {
				$array[ $key ] = wp_filter_nohtml_kses( $value );
			} else {
				if ( ! empty( $value ) ) {
					$array[ $key ] = intval( $value );
				}
			}
		}
		return $array;
	}
}
if ( ! function_exists( 'splogocarousel_sanitize_number_field' ) ) {
	/**
	 *
	 * Sanitize number
	 *
	 * @param  mixed $value value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function splogocarousel_sanitize_number_field( $value ) {
		if ( ! empty( $value ) ) {
			return intval( $value );
		}
	}
}

if ( ! function_exists( 'splogocarousel_sanitize_title' ) ) {
	/**
	 *
	 * Sanitize title
	 *
	 * @param  mixed $value value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function splogocarousel_sanitize_title( $value ) {
		return sanitize_title( $value );
	}
}

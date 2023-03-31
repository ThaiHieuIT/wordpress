<?php
/**
 * Framework sanitize.
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! function_exists( 'splogocarousel_validate_email' ) ) {
	/**
	 *
	 * Email validate
	 *
	 * @param  email $value value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function splogocarousel_validate_email( $value ) {
		if ( ! filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
			return esc_html__( 'Please enter a valid email address.', 'splogocarousel' );
		}
	}
}


if ( ! function_exists( 'splogocarousel_validate_numeric' ) ) {
	/**
	 *
	 * Numeric validate
	 *
	 * @param  string $value value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function splogocarousel_validate_numeric( $value ) {
		if ( ! is_numeric( $value ) ) {
			return esc_html__( 'Please enter a valid number.', 'splogocarousel' );
		}
	}
}


if ( ! function_exists( 'splogocarousel_validate_required' ) ) {
	/**
	 *
	 * Required validate
	 *
	 * @param  string $value value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function splogocarousel_validate_required( $value ) {
		if ( empty( $value ) ) {
			return esc_html__( 'This field is required.', 'splogocarousel' );
		}
	}
}


if ( ! function_exists( 'splogocarousel_validate_url' ) ) {
	/**
	 *
	 * URL validate
	 *
	 * @param  url $value value.
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function splogocarousel_validate_url( $value ) {
		if ( ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
			return esc_html__( 'Please enter a valid URL.', 'splogocarousel' );
		}
	}
}

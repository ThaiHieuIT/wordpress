<?php
/**
 * Framework helper functionality of the plugin.
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! function_exists( 'splogocarousel_array_search' ) ) {


	/**
	 * Array search key & value
	 *
	 * @param  array $array Main array.
	 * @param  mixed $key key.
	 * @param  mixed $value value.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 * @return array
	 */
	function splogocarousel_array_search( $array, $key, $value ) {

		$results = array();

		if ( is_array( $array ) ) {
			if ( isset( $array[ $key ] ) && $array[ $key ] == $value ) {
				$results[] = $array;
			}

			foreach ( $array as $sub_array ) {
				$results = array_merge( $results, splogocarousel_array_search( $sub_array, $key, $value ) );
			}
		}

		return $results;

	}
}


if ( ! function_exists( 'splogocarousel_wp_editor_api' ) ) {
	/**
	 *
	 * Check for wp editor api
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function splogocarousel_wp_editor_api() {
		global $wp_version;
		return version_compare( $wp_version, '4.8', '>=' );
	}
}

<?php
/**
 *
 * Field: Custom_import
 *
 * @link       https://shapedplugin.com/
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.


if ( ! class_exists( 'SPLC_FREE_Field_custom_import' ) ) {
	/**
	 *
	 * Field: Custom_import
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPLC_FREE_Field_custom_import extends SPLC_FREE_Fields {

		/**
		 * The class constructor.
		 *
		 * @param array  $field The field type.
		 * @param string $value The values of the field.
		 * @param string $unique The unique ID for the field.
		 * @param string $where To where show the output CSS.
		 * @param string $parent The parent args.
		 */
		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}
		/**
		 * The render method.
		 *
		 * @return void
		 */
		public function render() {
			echo wp_kses_post( $this->field_before() );
			$lcp_logolink      = admin_url( 'edit.php?post_type=sp_logo_carousel' );
			$lcp_shortcodelink = admin_url( 'edit.php?post_type=sp_lc_shortcodes' );
				echo '<p><input type="file" id="import" accept=".json"></p>';
				echo '<p><button type="button" class="import">Import</button></p>';
				echo '<a id="lcp_shortcode_link_redirect" href="' . esc_url( $lcp_shortcodelink ) . '"></a>';
				echo '<a id="lcp_logo_link_redirect" href="' . esc_url( $lcp_logolink ) . '"></a>';
			echo wp_kses_post( $this->field_after() );
		}
	}
}

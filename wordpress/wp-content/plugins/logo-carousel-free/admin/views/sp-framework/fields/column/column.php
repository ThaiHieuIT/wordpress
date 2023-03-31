<?php
/**
 *
 * Field: backup
 *
 * @link       https://shapedplugin.com/
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! class_exists( 'SPLC_FREE_Field_column' ) ) {


	/**
	 *
	 * Field: column
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPLC_FREE_Field_column extends SPLC_FREE_Fields {

		/**
		 * Column field constructor.
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

			$args = wp_parse_args(
				$this->field,
				array(
					'lg_desktop_icon'              => '<i class="fa fa-television"></i>',
					'desktop_icon'                 => '<i class="fa fa-desktop"></i>',
					'tablet_icon'                  => '<i class="fa fa-tablet"></i>',
					'mobile_landscape_icon'        => '<i class="fa fa-mobile"></i>',
					'mobile_icon'                  => '<i class="fa fa-mobile"></i>',
					'all_icon'                     => '<i class="fa fa-arrows"></i>',
					'lg_desktop_placeholder'       => esc_html__( 'Large Desktop', 'logo-carousel-free' ),
					'desktop_placeholder'          => esc_html__( 'Desktop', 'logo-carousel-free' ),
					'tablet_placeholder'           => esc_html__( 'Tablet', 'logo-carousel-free' ),
					'mobile_landscape_placeholder' => esc_html__( 'Mobile Landscape', 'logo-carousel-free' ),
					'mobile_placeholder'           => esc_html__( 'Mobile', 'logo-carousel-free' ),
					'all_placeholder'              => esc_html__( 'all', 'logo-carousel-free' ),
					'lg_desktop'                   => true,
					'desktop'                      => true,
					'tablet'                       => true,
					'mobile_landscape'             => true,
					'mobile'                       => true,
					'min'                          => '0',
					'unit'                         => false,
					'all'                          => false,
					'units'                        => array( 'px', '%', 'em' ),
				)
			);

			$default_values = array(
				'lg_desktop'       => '5',
				'desktop'          => '4',
				'tablet'           => '3',
				'mobile_landscape' => '2',
				'mobile'           => '1',
				'min'              => '',
				'all'              => '',
				'unit'             => 'px',
			);

			// $value = wp_parse_args( $this->value, $default_values );
			$value   = wp_parse_args( $this->value, $default_values );
			$unit    = ( count( $args['units'] ) === 1 && ! empty( $args['unit'] ) ) ? $args['units'][0] : '';
			$is_unit = ( ! empty( $unit ) ) ? ' splogocarousel--is-unit' : '';

			echo wp_kses_post( $this->field_before() );

			echo '<div class="splogocarousel--inputs">';

			$min = ( isset( $args['min'] ) ) ? ' min="' . esc_attr( $args['min'] ) . '"' : '';
			if ( ! empty( $args['all'] ) ) {

				$placeholder = ( ! empty( $args['all_placeholder'] ) ) ? ' placeholder="' . esc_attr( $args['all_placeholder'] ) . '"' : '';

				echo '<div class="splogocarousel--input">';
				echo ( ! empty( $args['all_icon'] ) ) ? '<span class="splogocarousel--label splogocarousel--icon">' . $args['all_icon'] . '</span>' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[all]' ) ) . '" value="' . esc_attr( $value['all'] ) . '"' . $placeholder . $min . ' class="splogocarousel-number" />';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ( count( $args['units'] ) === 1 && ! empty( $args['unit'] ) ) ? '<span class="splogocarousel--label splogocarousel--unit">' . esc_html( $args['units'][0] ) . '</span>' : '';
				echo '</div>';
			} else {
				$properties = array();

				foreach ( array( 'lg_desktop', 'desktop', 'tablet', 'mobile_landscape', 'mobile' ) as $prop ) {
					if ( ! empty( $args[ $prop ] ) ) {
						$properties[] = $prop;
					}
				}

				$properties = ( array( 'tablet', 'mobile' ) === $properties ) ? array_reverse( $properties ) : $properties;

				foreach ( $properties as $property ) {

					$placeholder = ( ! empty( $args[ $property . '_placeholder' ] ) ) ? ' placeholder="' . esc_attr( $args[ $property . '_placeholder' ] ) . '"' : '';

					echo '<div class="splogocarousel--input">';
					echo ( ! empty( $args[ $property . '_icon' ] ) ) ? '<span class="splogocarousel--label splogocarousel--icon">' . $args[ $property . '_icon' ] . '</span>' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '<input type="number" name="' . esc_attr( $this->field_name( '[' . $property . ']' ) ) . '" value="' . esc_attr( $value[ $property ] ) . '"' . $placeholder . $min . ' class="splogocarousel-number" />';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo ( count( $args['units'] ) === 1 && ! empty( $args['unit'] ) ) ? '<span class="splogocarousel--label splogocarousel--unit">' . esc_html( $args['units'][0] ) . '</span>' : '';
					echo '</div>';

				}
			}

			if ( ! empty( $args['unit'] ) && count( $args['units'] ) > 1 ) {
				echo '<div class="splogocarousel--input">';

				echo '<select name="' . esc_attr( $this->field_name( '[unit]' ) ) . '">';
				foreach ( $args['units'] as $unit ) {
					$selected = ( $value['unit'] === $unit ) ? ' selected' : '';
					echo '<option value="' . esc_attr( $unit ) . '"' . esc_attr( $selected ) . '>' . esc_html( $unit ) . '</option>';
				}
				echo '</select>';
				echo '</div>';
			}

			echo '</div>';

			echo wp_kses_post( $this->field_after() );

		}

	}
}

<?php
/**
 *
 * Field: Border
 *
 * @link       https://shapedplugin.com/
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! class_exists( 'SPLC_FREE_Field_border' ) ) {
	/**
	 *
	 * Field: border
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPLC_FREE_Field_border extends SPLC_FREE_Fields {

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

			$args = wp_parse_args(
				$this->field,
				array(
					'top_icon'           => '<i class="fa fa-long-arrow-alt-up"></i>',
					'left_icon'          => '<i class="fa fa-long-arrow-alt-left"></i>',
					'bottom_icon'        => '<i class="fa fa-long-arrow-alt-down"></i>',
					'right_icon'         => '<i class="fa fa-long-arrow-alt-right"></i>',
					'all_icon'           => '<i class="fa fa-arrows-alt"></i>',
					'top_placeholder'    => esc_html__( 'top', 'logo-carousel-free' ),
					'right_placeholder'  => esc_html__( 'right', 'logo-carousel-free' ),
					'bottom_placeholder' => esc_html__( 'bottom', 'logo-carousel-free' ),
					'left_placeholder'   => esc_html__( 'left', 'logo-carousel-free' ),
					'all_placeholder'    => esc_html__( 'all', 'logo-carousel-free' ),
					'top'                => true,
					'left'               => true,
					'bottom'             => true,
					'right'              => true,
					'all'                => false,
					'color'              => true,
					'hover_color'        => false,
					'style'              => true,
					'unit'               => 'px',
				)
			);

			$default_value = array(
				'top'         => '',
				'right'       => '',
				'bottom'      => '',
				'left'        => '',
				'color'       => '',
				'style'       => 'solid',
				'all'         => '',
				'hover_color' => '',
			);

			$border_props = array(
				'solid'  => esc_html__( 'Solid', 'logo-carousel-free' ),
				'dashed' => esc_html__( 'Dashed', 'logo-carousel-free' ),
				'dotted' => esc_html__( 'Dotted', 'logo-carousel-free' ),
				'double' => esc_html__( 'Double', 'logo-carousel-free' ),
				'inset'  => esc_html__( 'Inset', 'logo-carousel-free' ),
				'outset' => esc_html__( 'Outset', 'logo-carousel-free' ),
				'groove' => esc_html__( 'Groove', 'logo-carousel-free' ),
				'ridge'  => esc_html__( 'ridge', 'logo-carousel-free' ),
				'none'   => esc_html__( 'None', 'logo-carousel-free' ),
			);

			$default_value = ( ! empty( $this->field['default'] ) ) ? wp_parse_args( $this->field['default'], $default_value ) : $default_value;

			$value = wp_parse_args( $this->value, $default_value );

			echo wp_kses_post( $this->field_before() );

			echo '<div class="splogocarousel--inputs" data-depend-id="' . esc_attr( $this->field['id'] ) . '">';

			if ( ! empty( $args['all'] ) ) {

				$placeholder = ( ! empty( $args['all_placeholder'] ) ) ? ' placeholder="' . esc_attr( $args['all_placeholder'] ) . '"' : '';

				echo '<div class="splogocarousel--input">';
				echo '<div class="splogocarousel--title">Width</div>';
				echo ( ! empty( $args['all_icon'] ) ) ? '<span class="splogocarousel--label splogocarousel--icon">' . wp_kses_post( $args['all_icon'] ) . '</span>' : '';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[all]' ) ) . '" value="' . esc_attr( $value['all'] ) . '"' . $placeholder . ' class="splogocarousel-input-number splogocarousel--is-unit" step="any" />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ( ! empty( $args['unit'] ) ) ? '<span class="splogocarousel--label splogocarousel--unit">' . esc_attr( $args['unit'] ) . '</span>' : '';
				echo '</div>';

			} else {

				$properties = array();

				foreach ( array( 'top', 'right', 'bottom', 'left' ) as $prop ) {
					if ( ! empty( $args[ $prop ] ) ) {
						$properties[] = $prop;
					}
				}

				$properties = ( array( 'right', 'left' ) === $properties ) ? array_reverse( $properties ) : $properties;

				foreach ( $properties as $property ) {

					$placeholder = ( ! empty( $args[ $property . '_placeholder' ] ) ) ? ' placeholder="' . esc_attr( $args[ $property . '_placeholder' ] ) . '"' : '';

					echo '<div class="splogocarousel--input">';
					echo ( ! empty( $args[ $property . '_icon' ] ) ) ? '<span class="splogocarousel--label splogocarousel--icon">' . wp_kses_post( $args[ $property . '_icon' ] ) . '</span>' : '';
					echo '<input type="number" name="' . esc_attr( $this->field_name( '[' . $property . ']' ) ) . '" value="' . esc_attr( $value[ $property ] ) . '"' . $placeholder . ' class="splogocarousel-input-number splogocarousel--is-unit" step="any" />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo ( ! empty( $args['unit'] ) ) ? '<span class="splogocarousel--label splogocarousel--unit">' . esc_attr( $args['unit'] ) . '</span>' : '';
					echo '</div>';

				}
			}

			if ( ! empty( $args['style'] ) ) {
				echo '<div class="splogocarousel--input">';
				echo '<div class="splogocarousel--title">Style</div>';
				echo '<select name="' . esc_attr( $this->field_name( '[style]' ) ) . '">';
				foreach ( $border_props as $border_prop_key => $border_prop_value ) {
					$selected = ( $value['style'] === $border_prop_key ) ? ' selected' : '';
					echo '<option value="' . esc_attr( $border_prop_key ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $border_prop_value ) . '</option>';
				}
				echo '</select>';
				echo '</div>';
			}

			echo '</div>';

			if ( ! empty( $args['color'] ) ) {
				$default_color_attr = ( ! empty( $default_value['color'] ) ) ? ' data-default-color="' . esc_attr( $default_value['color'] ) . '"' : '';
				echo '<div class="splogocarousel--color">';
				echo '<div class="splogocarousel--title">Color</div>';
				echo '<div class="splogocarousel-field-color">';
				echo '<input type="text" name="' . esc_attr( $this->field_name( '[color]' ) ) . '" value="' . esc_attr( $value['color'] ) . '" class="splogocarousel-color"' . $default_color_attr . ' />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '</div>';
				echo '</div>';
			}
			if ( ! empty( $args['hover_color'] ) ) {
				$default_color_attr = ( ! empty( $default_value['hover_color'] ) ) ? ' data-default-color="' . esc_attr( $default_value['hover_color'] ) . '"' : '';
				echo '<div class="splogocarousel--color">';
				echo '<div class="splogocarousel--title">Hover Color</div>';
				echo '<div class="splogocarousel-field-color">';
				echo '<input type="text" name="' . esc_attr( $this->field_name( '[hover_color]' ) ) . '" value="' . esc_attr( $value['hover_color'] ) . '" class="splogocarousel-color"' . $default_color_attr . ' />';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '</div>';
				echo '</div>';
			}
			echo wp_kses_post( $this->field_after() );
		}
	}
}

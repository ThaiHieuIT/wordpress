<?php
/**
 *
 * Field: Dimension Advanced
 *
 * @link       https://shapedplugin.com/
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

/**
 *
 * Field: Dimension Advanced.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'SPLC_FREE_Field_dimensions_advanced' ) ) {

	/**
	 * The Advanced Dimensions field class.
	 *
	 * @since 3.5
	 */
	class SPLC_FREE_Field_dimensions_advanced extends SPLC_FREE_Fields {


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
					'top_icon'           => '<i class="fa fa-long-arrow-up"></i>',
					'right_icon'         => '<i class="fa fa-long-arrow-right"></i>',
					'left_icon'          => '<i class="fa fa-long-arrow-left"></i>',
					'bottom_icon'        => '<i class="fa fa-long-arrow-down"></i>',
					'all_icon'           => '<i class="fa fa-arrows"></i>',
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
					'style'              => true,
					'styles'             => array( 'Soft-crop', 'Hard-crop' ),
					'unit'               => 'px',
					'min'                => '0',
				)
			);

			$default_value = array(
				'top'    => '',
				'right'  => '',
				'bottom' => '',
				'left'   => '',
				'color'  => '',
				'style'  => 'solid',
				'all'    => '',
				'min'    => '',
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

			$min = ( isset( $args['min'] ) ) ? ' min="' . esc_attr( $args['min'] ) . '"' : '';
			if ( ! empty( $args['all'] ) ) {

				$placeholder = ( ! empty( $args['all_placeholder'] ) ) ? ' placeholder="' . esc_attr( $args['all_placeholder'] ) . '"' : '';
				echo '<div class="splogocarousel--left splogocarousel--input">';
				echo ( ! empty( $args['all_icon'] ) ) ? '<span class="splogocarousel--label splogocarousel--label-icon">' . wp_kses_post( $args['all_icon'] ) . '</span>' : '';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[all]' ) ) . '" value="' . esc_attr( $value['all'] ) . '"' . $placeholder . $min . ' class="splogocarousel-number" />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ( ! empty( $args['unit'] ) ) ? '<span class="splogocarousel--label splogocarousel--label-unit">' . esc_html( $args['unit'] ) . '</span>' : '';
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

					echo '<div class="splogocarousel--left splogocarousel--input">';
					echo ( ! empty( $args[ $property . '_icon' ] ) ) ? '<span class="splogocarousel--label splogocarousel--label-icon">' . wp_kses_post( $args[ $property . '_icon' ] ) . '</span>' : '';
					echo '<input type="number" name="' . esc_attr( $this->field_name( '[' . $property . ']' ) ) . '" value="' . esc_attr( $value[ $property ] ) . '"' . $placeholder . $min . ' class="splogocarousel-number" />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo ( ! empty( $args['unit'] ) ) ? '<span class="splogocarousel--label splogocarousel--label-unit">' . esc_html( $args['unit'] ) . '</span>' : '';
					echo '</div>';

				}
			}

			if ( ! empty( $args['style'] ) ) {
				echo '<div class="splogocarousel--left splogocarousel--input">';
				echo '<select name="' . esc_attr( $this->field_name( '[style]' ) ) . '">';
				foreach ( $args['styles'] as $style_prop ) {
					$selected = ( $value['style'] === $style_prop ) ? ' selected' : '';
					echo '<option value="' . esc_attr( $style_prop ) . '"' . esc_attr( $selected ) . '>' . esc_html( $style_prop ) . '</option>';
				}
				echo '</select>';
				echo $args['unit'] ? '<span style=" background-color: #d4d4d4;padding: 2px 4px;font-size: 8px;border-radius: 2px;height: 11px;line-height: 12px;margin-top: 7px;opacity: .7;margin-left: 5px">PRO</span>' : '';
				echo '</div>';
			}

			if ( ! empty( $args['color'] ) ) {
				$default_color_attr = ( ! empty( $default_value['color'] ) ) ? ' data-default-color="' . esc_attr( $default_value['color'] ) . '"' : '';
				echo '<div class="splogocarousel--left splogocarousel-field-color">';
				echo '<input type="text" name="' . esc_attr( $this->field_name( '[color]' ) ) . '" value="' . esc_attr( $value['color'] ) . '" class="splogocarousel-color"' . $default_color_attr . ' />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '</div>';
			}

			echo '<div class="clear"></div>';

			echo wp_kses_post( $this->field_after() );

		}
	}
}

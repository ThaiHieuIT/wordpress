<?php
/**
 *
 * Field: Spacing
 *
 * @link       https://shapedplugin.com/
 *
 * @package    Logo_Carousel_Free
 * @subpackage Logo_Carousel_Free/sp-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! class_exists( 'SPLC_FREE_Field_spacing' ) ) {
	/**
	 *
	 * Field: spacing
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SPLC_FREE_Field_spacing extends SPLC_FREE_Fields {

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
					'top_icon'           => '<i class="fas fa-long-arrow-alt-up"></i>',
					'right_icon'         => '<i class="fas fa-long-arrow-alt-right"></i>',
					'bottom_icon'        => '<i class="fas fa-long-arrow-alt-down"></i>',
					'left_icon'          => '<i class="fas fa-long-arrow-alt-left"></i>',
					'all_icon'           => '<i class="fas fa-arrows-alt"></i>',
					'top_placeholder'    => esc_html__( 'top', 'splogocarousel' ),
					'right_placeholder'  => esc_html__( 'right', 'splogocarousel' ),
					'bottom_placeholder' => esc_html__( 'bottom', 'splogocarousel' ),
					'left_placeholder'   => esc_html__( 'left', 'splogocarousel' ),
					'all_placeholder'    => esc_html__( 'all', 'splogocarousel' ),
					'top'                => true,
					'left'               => true,
					'bottom'             => true,
					'right'              => true,
					'unit'               => true,
					'show_units'         => true,
					'all'                => false,
					'vertical'           => false,
					'show_title'         => false,
					'units'              => array( 'px', '%', 'em' ),
				)
			);

			$default_values = array(
				'top'      => '',
				'right'    => '',
				'bottom'   => '',
				'left'     => '',
				'all'      => '',
				'vertical' => '',
				'unit'     => 'px',
			);

			$value   = wp_parse_args( $this->value, $default_values );
			$unit    = ( count( $args['units'] ) === 1 && ! empty( $args['unit'] ) ) ? $args['units'][0] : '';
			$is_unit = ( ! empty( $unit ) ) ? ' splogocarousel--is-unit' : '';

			echo wp_kses_post( $this->field_before() );

			echo '<div class="splogocarousel--inputs" data-depend-id="' . esc_attr( $this->field['id'] ) . '">';

			if ( ! empty( $args['all'] ) ) {

				$placeholder = ( ! empty( $args['all_placeholder'] ) ) ? $args['all_placeholder'] : '';
				$show_title  = ( $args['show_title'] ) ? '<div class="splogocarousel--title">Gap</div>' : '';

				echo '<div class="splogocarousel--space">';
				echo wp_kses(
					$show_title,
					array(
						'div' => array(
							'class' => array(),
						),
					)
				);
				echo '<div class="splogocarousel--input">';
				echo ( ! empty( $args['all_icon'] ) ) ? '<span class="splogocarousel--label splogocarousel--icon">' . wp_kses_post( $args['all_icon'] ) . '</span>' : '';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[all]' ) ) . '" value="' . esc_attr( $value['all'] ) . '" placeholder="' . esc_attr( $placeholder ) . '" class="splogocarousel-input-number' . esc_attr( $is_unit ) . '" step="any" />';
				echo ( $unit ) ? '<span class="splogocarousel--label splogocarousel--unit">' . esc_attr( $args['units'][0] ) . '</span>' : '';
				echo '</div>';
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

					$placeholder = ( ! empty( $args[ $property . '_placeholder' ] ) ) ? $args[ $property . '_placeholder' ] : '';
					echo '<div class="splogocarousel--input">';
					echo ( ! empty( $args[ $property . '_icon' ] ) ) ? '<span class="splogocarousel--label splogocarousel--icon">' . wp_kses_post( $args[ $property . '_icon' ] ) . '</span>' : '';
					echo '<input type="number" name="' . esc_attr( $this->field_name( '[' . $property . ']' ) ) . '" value="' . esc_attr( $value[ $property ] ) . '" placeholder="' . esc_attr( $placeholder ) . '" class="splogocarousel-input-number' . esc_attr( $is_unit ) . '" step="any" />';
					echo ( $unit ) ? '<span class="splogocarousel--label splogocarousel--unit">' . esc_attr( $args['units'][0] ) . '</span>' : '';
					echo '</div>';
				}
			}

			if ( ! empty( $args['vertical'] ) ) {

				$placeholder = ( ! empty( $args['all_placeholder'] ) ) ? ' placeholder="' . esc_attr( $args['all_placeholder'] ) . '"' : '';

				echo '<div class="splogocarousel--space">';
				echo '<div class="splogocarousel--title">Vertical Gap</div>';
				echo '<div class="splogocarousel--input">';
				echo ( ! empty( $args['vertical_icon'] ) ) ? '<span class="splogocarousel--label splogocarousel--icon">' . $args['vertical_icon'] . '</span>' : '';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[vertical]' ) ) . '" value="' . esc_attr( $value['vertical'] ) . '"' . $placeholder . ' class="splogocarousel-input-number' . esc_attr( $is_unit ) . '" step="any" />';// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ( $unit ) ? '<span class="splogocarousel--label splogocarousel--unit">' . esc_attr( $args['units'][0] ) . '</span>' : '';
				echo '</div>';
				echo '</div>';

			}

			if ( ! empty( $args['unit'] ) && ! empty( $args['show_units'] ) && count( $args['units'] ) > 1 ) {
				echo '<div class="splogocarousel--input">';
				echo '<select name="' . esc_attr( $this->field_name( '[unit]' ) ) . '">';
				foreach ( $args['units'] as $unit ) {
					$selected = ( $value['unit'] === $unit ) ? ' selected' : '';
					echo '<option value="' . esc_attr( $unit ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $unit ) . '</option>';
				}
				echo '</select>';
				echo '</div>';
			}
			echo '</div>';
			echo wp_kses_post( $this->field_after() );

		}
	}
}

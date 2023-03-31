<?php
/**
 * Custom import export.
 *
 * @link http://shapedplugin.com
 * @since 2.0.0
 *
 * @package Logo_Carousel.
 * @subpackage Logo_Carousel_Free/includes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Custom import export.
 */
class Logo_Carousel_Import_Export {

	/**
	 * Export
	 *
	 * @param  mixed $shortcode_ids Export logo and carousel shortcode ids.
	 * @return object
	 */
	public function export( $shortcode_ids ) {
		$export = array();
		if ( ! empty( $shortcode_ids ) ) {
			$post_type  = 'all_logos' === $shortcode_ids ? 'sp_logo_carousel' : 'sp_lc_shortcodes';
			$post_in    = 'all_logos' === $shortcode_ids || 'all_shortcodes' === $shortcode_ids ? '' : $shortcode_ids;
			$args       = array(
				'post_type'        => $post_type,
				'post_status'      => array( 'inherit', 'publish' ),
				'orderby'          => 'modified',
				'suppress_filters' => 1, // wpml, ignore language filter.
				'posts_per_page'   => -1,
				'post__in'         => $post_in,
			);
			$shortcodes = get_posts( $args );
			if ( ! empty( $shortcodes ) ) {
				foreach ( $shortcodes as $shortcode ) {
						$shortcode_export = array(
							'title'       => $shortcode->post_title,
							'original_id' => $shortcode->ID,
							'meta'        => array(),
						);
						if ( 'all_logos' === $shortcode_ids ) {
							$shortcode_export['image']     = get_the_post_thumbnail_url( $shortcode->ID, 'single-post-thumbnail' );
							$shortcode_export['all_logos'] = 'all_logos';
						}
						foreach ( get_post_meta( $shortcode->ID ) as $metakey => $value ) {
							$shortcode_export['meta'][ $metakey ] = $value[0];
						}
						$export['shortcode'][] = $shortcode_export;

						unset( $shortcode_export );
				}
				$export['metadata'] = array(
					'version' => SP_LC_VERSION,
					'date'    => gmdate( 'Y/m/d' ),
				);
			}
			return $export;
		}
	}

	/**
	 * Export Accordion by ajax.
	 *
	 * @return void
	 */
	public function export_shortcodes() {
		$nonce = ( ! empty( $_POST['nonce'] ) ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'splogocarousel_options_nonce' ) ) {
			die();
		}
		$shortcode_ids = '';
		if ( isset( $_POST['lcp_ids'] ) ) {
			$shortcode_ids = is_array( $_POST['lcp_ids'] ) ? wp_unslash( array_map( 'absint', $_POST['lcp_ids'] ) ) : sanitize_text_field( wp_unslash( $_POST['lcp_ids'] ) );
		}

		$export = $this->export( $shortcode_ids );

		if ( is_wp_error( $export ) ) {
			wp_send_json_error(
				array(
					'message' => $export->get_error_message(),
				),
				400
			);
		}

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
            // @codingStandardsIgnoreLine
            echo wp_json_encode($export, JSON_PRETTY_PRINT);
			die;
		}

		wp_send_json( $export, 200 );
	}
	/**
	 * Insert an attachment from an URL address.
	 *
	 * @param  String $url remote url.
	 * @param  Int    $parent_post_id parent post id.
	 * @return Int    Attachment ID
	 */
	public function insert_attachment_from_url( $url, $parent_post_id = null ) {

		if ( ! class_exists( 'WP_Http' ) ) {
			include_once ABSPATH . WPINC . '/class-http.php';
		}
		$attachment_title = sanitize_file_name( pathinfo( $url, PATHINFO_FILENAME ) );
		// Does the attachment already exist ?
		if ( post_exists( $attachment_title, '', '', 'attachment' ) ) {
			$attachment = get_page_by_title( $attachment_title, OBJECT, 'attachment' );
			if ( ! empty( $attachment ) ) {
				$attachment_id = $attachment->ID;
				return $attachment_id;
			}
		}
		$http     = new WP_Http();
		$response = $http->request( $url );
		if ( is_wp_error( $response ) ) {
			return false;
		}
		$upload = wp_upload_bits( basename( $url ), null, $response['body'] );
		if ( ! empty( $upload['error'] ) ) {
			return false;
		}

		$file_path     = $upload['file'];
		$file_name     = basename( $file_path );
		$file_type     = wp_check_filetype( $file_name, null );
		$wp_upload_dir = wp_upload_dir();

		$post_info = array(
			'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
			'post_mime_type' => $file_type['type'],
			'post_title'     => $attachment_title,
			'post_content'   => '',
			'post_status'    => 'inherit',
		);

		// Create the attachment.
		$attach_id = wp_insert_attachment( $post_info, $file_path, $parent_post_id );

		// Include image.php.
		require_once ABSPATH . 'wp-admin/includes/image.php';

		// Define attachment metadata.
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

		// Assign metadata to attachment.
		wp_update_attachment_metadata( $attach_id, $attach_data );

		return $attach_id;

	}

	/**
	 * Import logo ans shortcode.
	 *
	 * @param  mixed $shortcodes Import logo and carousel shortcode array.
	 *
	 * @throws \Exception If get error.
	 * @return object
	 */
	public function import( $shortcodes ) {
		$errors        = array();
		$lcp_post_type = 'sp_logo_carousel';
		foreach ( $shortcodes as $index => $shortcode ) {
			$errors[ $index ] = array();
			$new_shortcode_id = 0;
			$lcp_post_type    = isset( $shortcode['all_logos'] ) ? 'sp_logo_carousel' : 'sp_lc_shortcodes';
			try {
				$new_shortcode_id = wp_insert_post(
					array(
						'post_title'  => isset( $shortcode['title'] ) ? $shortcode['title'] : '',
						'post_status' => 'publish',
						'post_type'   => $lcp_post_type,
					),
					true
				);
				if ( isset( $shortcode['all_logos'] ) ) {
					$url = isset( $shortcode['image'] ) && ! empty( $shortcode['image'] ) ? $shortcode['image'] : '';
					// Insert attachment id.
					$thumb_id                           = $this->insert_attachment_from_url( $url, $new_shortcode_id );
					$shortcode['meta']['_thumbnail_id'] = $thumb_id;
				}
				if ( is_wp_error( $new_shortcode_id ) ) {
					throw new \Exception( $new_shortcode_id->get_error_message() );
				}

				if ( isset( $shortcode['meta'] ) && is_array( $shortcode['meta'] ) ) {
					foreach ( $shortcode['meta'] as $key => $value ) {
						update_post_meta(
							$new_shortcode_id,
							$key,
							maybe_unserialize( str_replace( '{#ID#}', $new_shortcode_id, $value ) )
						);
					}
				}
			} catch ( \Exception $e ) {
				array_push( $errors[ $index ], $e->getMessage() );

				// If there was a failure somewhere, clean up.
				wp_trash_post( $new_shortcode_id );
			}

			// If no errors, remove the index.
			if ( ! count( $errors[ $index ] ) ) {
				unset( $errors[ $index ] );
			}

			// External modules manipulate data here.
			do_action( 'sp_logo_carousel_shortcode_imported', $new_shortcode_id );
		}

		$errors = reset( $errors );
		return isset( $errors[0] ) ? new \WP_Error( 'import_accordion_error', $errors[0] ) : $lcp_post_type;
	}

	/**
	 * Import logos/shortcodes by ajax.
	 *
	 * @return void
	 */
	public function import_shortcodes() {
		$nonce = ( ! empty( $_POST['nonce'] ) ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'splogocarousel_options_nonce' ) ) {
			die();
		}
		$data       = isset( $_POST['shortcode'] ) ? wp_kses_data( wp_unslash( $_POST['shortcode'] ) ) : '';
		$data       = json_decode( $data );
		$data       = json_decode( $data, true );
		$shortcodes = $data['shortcode'];
		if ( ! $data ) {
			wp_send_json_error(
				array(
					'message' => __( 'Nothing to import.', 'logo-carousel-free' ),
				),
				400
			);
		}

		$status = $this->import( $shortcodes );

		if ( is_wp_error( $status ) ) {
			wp_send_json_error(
				array(
					'message' => $status->get_error_message(),
				),
				400
			);
		}

		wp_send_json_success( $status, 200 );
	}
}

<?php
/**
 * Update version.
 *
 * @package logo-carousel-free
 */

update_option( 'logo_carousel_free_version', '3.3.1' );
update_option( 'logo_carousel_free_db_version', '3.3.1' );

$settings['lcpro_data_remove']     = false;
$settings['lcpro_fontawesome_css'] = true;
$settings['lcpro_swiper_css']      = true;
$settings['lcpro_swiper_js']       = true;
$settings['lcpro_custom_css']      = '';
update_option( '_sp_lcpro_options', $settings );

<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package devthemes
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'devthemes' ); ?></a>

	<header id="masthead" class="site-header">
		<div id="top-header">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="hotline">
							<span>Hotline : 0364890450</span>
							<span>Email : Trandevthemes731@gmail.com</span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="social">
							<span><a href="https://www.facebook.com/profile.php?id=100036713001628">
							<i class="fa-brands fa-facebook"></i>
							</a></span>
							<span><a href="#">
							<i class="fa-brands fa-facebook-messenger"></i>
							</a></span>
							<span><a href="#">
							<i class="fa-brands fa-instagram"></i>
							</a></span>
							<span><a href="#">
							<i class="fa-solid fa-magnifying-glass"></i>
							</a></span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="branding">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-6">
					<div class="site-branding">
							<?php
							the_custom_logo();
							if ( is_front_page() && is_home() ) :
								?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
								<?php
							else :
								?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php
							endif;
							$devthemes_description = get_bloginfo( 'description', 'display' );
							if ( $devthemes_description || is_customize_preview() ) :
								?>
								<p class="site-description"><?php echo $devthemes_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
							<?php endif; ?>
						</div><!-- .site-branding -->
					</div>
					<div class="col-md-8 col-6">
									<nav id="site-navigation" class="main-navigation">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'devthemes' ); ?></button>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
								)
							);
							?>
						</nav><!-- #site-navigation -->
					</div>
				</div>
			</div>
		</div>
		<!-- end brading -->

		

	</header><!-- #masthead -->
	<div class="container">
	<div class="row">

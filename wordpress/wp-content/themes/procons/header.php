<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package procons
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<title>Procons - Xây dựng dân dụng - Công Nghiệp</title>


	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'procons'); ?></a>

		<header id="masthead" class="site-header">
			<div id="branding">
				<div class="container">
					<div class="row">
						<div class="col-md-2 col-2">
							<div class="site-branding">
								<?php
								the_custom_logo();
								if (is_front_page() && is_home()) :
								?>
									<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
								<?php
								else :
								?>
									<p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
								<?php
								endif;
								$hieudev_description = get_bloginfo('description', 'display');
								if ($hieudev_description || is_customize_preview()) :
								?>
									<p class="site-description"><?php echo $hieudev_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																?></p>
								<?php endif; ?>
							</div><!-- .site-branding -->
						</div>
						<div class="col-md-8 col-3 menu-right">
							<nav id="site-navigation" class="main-navigation">
								<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e('Primary Menu', 'hieudev'); ?></button>
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
						<div class="col-md-2 col-7 search">
							<div class="box">
								<form name="search">
									<input type="text" class="input" name="txt" onmouseout="this.value = ''; this.blur();">
								</form>
								<i class="fas fa-search"></i>

							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
				window.onscroll = function() {
					scrollFunction()
				};

				function scrollFunction() {
					if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
						document.querySelector(".custom-logo").style.width = "80px";
						document.querySelector(".custom-logo").style.height = "80px";
						document.querySelector(".search").style.height = "80px";
						document.querySelector(".menu-right").style.height = "80px";
						document.getElementById("branding").style.boxShadow = "0 0 25px 5px";
						document.querySelector("#branding").style.height = "80px";
					} else {
						document.querySelector(".custom-logo").style.width = "150px";
						document.querySelector(".custom-logo").style.height = "155px";
						document.querySelector(".search").style.height = "155px";
						document.querySelector(".menu-right").style.height = "155px";
						document.querySelector(".sticky-element-active").style.height = "155px";
						document.querySelector("#branding").style.height = "155px";
						document.getElementById("branding").style.boxShadow = "0 0 10px 0.5px";
					}
				}
			</script>
		</header><!-- #masthead -->
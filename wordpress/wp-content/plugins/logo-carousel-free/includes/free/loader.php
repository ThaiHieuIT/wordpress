<?php
/**
 * The Free Loader Class
 *
 * @package logo-carousel-free
 * @since 3.0
 */

/**
 * The Free Loader Class
 *
 * @package logo-carousel-free
 * @since 3.0
 */
class SPLC_Free_Loader {

	/**
	 * Free Loader constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 80 );
		require_once SP_LC_PATH . 'admin/views/scripts.php';
		require_once SP_LC_PATH . 'public/views/shortcoderender.php';
	}

	/**
	 * Admin Menu
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_submenu_page(
			'edit.php?post_type=sp_logo_carousel',
			__( 'Logo Carousel Help', 'logo-carousel-free' ),
			__( 'Help', 'logo-carousel-free' ),
			'manage_options',
			'lc_help',
			array( $this, 'help_page_callback' )
		);
		$landing_page = 'https://logocarousel.com/pricing/?ref=1';
		add_submenu_page(
			'edit.php?post_type=sp_logo_carousel',
			__( 'Logo Carousel Pro', 'logo-carousel-free' ),
			'<span class="sp-go-pro-icon"></span>Go Pro',
			'manage_options',
			$landing_page
		);

	}

	/**
	 * Help Page Callback
	 */
	public function help_page_callback() {
		wp_enqueue_style( 'sp-lc-admin-help', SP_LC_URL . 'admin/assets/css/help-page.min.css', array(), SP_LC_VERSION );
		$add_shortcode_link = admin_url( 'post-new.php?post_type=sp_logo_carousel' );
		?>

		<div class="sp-logo-carousel-help-page">
				<!-- Header section start -->
				<section class="sp-lc-help header">
					<div class="header-area">
						<div class="container">
							<div class="header-logo">
								<img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/lc-logo.svg'; ?>" alt="">
								<span><?php echo esc_html( SP_LC_VERSION ); ?></span>
							</div>
							<div class="header-content">
								<p>Thank you for installing Logo Carousel plugin! This video will help you get started with the plugin.</p>
							</div>
						</div>
					</div>
					<div class="video-area">
						<iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLoUb-7uG-5jN7hMCpV5dtKLqAMsk_NmZc" frameborder="0" allowfullscreen=""></iframe>
					</div>
					<div class="content-area">
						<div class="container">
							<div class="content-button">
								<a href="<?php echo esc_url( $add_shortcode_link ); ?>">Start Adding Logos</a>
								<a href="https://docs.shapedplugin.com/docs/logo-carousel/introduction/" target="_blank">Read Documentation</a>
							</div>
						</div>
					</div>
				</section>
				<!-- Header section end -->

				<!-- Upgrade section start -->
				<section class="sp-lc-help upgrade">
					<div class="upgrade-area">
					<div class="upgrade-img">
					<img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/lc-icon1.svg'; ?>" alt="">
					</div>
						<h2>Upgrade To Unleash the Power of Logo Carousel</h2>
						<p>Professional looking Logo Carousel, Grid, Isotope Filter, List, Inline layouts. Add title, description, links and tooltips to the logos and Get the most out of Logo Carousel by upgrading to unlock all of its powerful features like:</p>
					</div>
					<div class="upgrade-info">
						<div class="container">
							<div class="row">
								<div class="col-lg-6">
									<ul class="upgrade-list">
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Display a list of clients, sponsors, partners, affiliates, supporters, suppliers, brands logo images on your WordPress site.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">
										5 Logo Layout Presets (Carousel, Grid, Isotope Filter, List, and Inline view)</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">200+ Advanced Styling and Layout Customization Options.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Drag & Drop Custom logo ordering.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Display Group (Category) and Specific Logo.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Logo Internal & External Logo links.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Category-wise Logo Filtering (Isotope Layout).</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt=""> Live Category Filter (Opacity).</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Logo Effects on Hover. (Grayscale, zoom in & out, blur, opacity, etc.)</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Multiple Rows in the Carousel.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Carousel Mode. (Standard, Ticker, Center).</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Supports both Vertical and Horizontal directions.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Set Logo Title Positions (Top, bottom, middle, on hover, etc.)</li>
									</ul>
								</div>
								<div class="col-lg-6">
									<ul class="upgrade-list">
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">25+ Logo Carousel Controls.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Logo Display with Tooltips, Title, Description, and CTA button(Read more).</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Tooltips Settings. (Show/hide, Position, Width, Effects, Background, etc.)</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Popup View for Logo Detail.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Logo Background, Hover, Border, Radius, BoxShadow Highlight, etc.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Set Logo margin between logos and inner padding.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Select logo vertical alignment type (Top, middle & bottom).</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">840+ Google Fonts (Advanced Typography).</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Advanced Plugin Settings.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Multisite, Multilingual, RTL, Accessibility ready.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Page Builders & Countless Theme Compatibility.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt="">Top-notch Support and Frequently Updates.</li>
										<li><img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/checkmark.svg'; ?>" alt=""><span>Not Happy? 100% No Questions Asked <a href="//shapedplugin.com/refund-policy/" target="_blank">Refund Policy!</a></span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="container">
						<div class="upgrade-pro">
							<div class="pro-content">
								<div class="pro-icon">
									<img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/lc-icon.svg'; ?>" alt="">
								</div>
								<div class="pro-text">
									<h2>Upgrade To Logo Carousel Pro</h2>
									<p>Start creating beautiful logo showcases in minutes!</p>
								</div>
							</div>
							<div class="pro-btn">
								<a href="https://logocarousel.com/pricing/?ref=1" target="_blank">Upgrade To Pro Now</a>
							</div>
						</div>
					</div>
				</section>
				<!-- Upgrade section end -->

				<!-- Testimonial section start -->
				<section class="sp-lc-help testimonial">
					<div class="row">
						<div class="col-lg-6">
							<div class="testimonial-area">
								<div class="testimonial-content">
									<p>Thank you for your help with with plugin, installed for a client and had a few issues. Unlike other plugins in the WP world, support was quick to respond and easy to access. And on top of that the plugin works great! Pro version – needed a way to display some logos in a ticker style with no pauses in two rows...</p>
								</div>
								<div class="testimonial-info">
									<div class="img">
										<img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/Mark-Kolodziej-min.png'; ?>" alt="">
									</div>
									<div class="info">
										<h3>Mark Kolodziej</h3>
										<p>Freelance Developer</p>
										<div class="star">
										<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="testimonial-area">
								<div class="testimonial-content">
									<p>This is an excellent logo carousel WordPress plugin! The plugin is simple, intuitive, easy to use, polished and continues to improve. I am also impressed with the code quality! Top notch support too. I raised a support ticket and within days a new version of the plugin was released with a fix. Well done.</p>
								</div>
								<div class="testimonial-info">
									<div class="img">
										<img src="<?php echo esc_url( SP_LC_URL ) . 'admin/assets/css/images/Daniel-Powney-min.png'; ?>" alt="">
									</div>
									<div class="info">
										<h3>Daniel Powney</h3>
										<p>Sr. Solution Architect, Salesforce</p>
										<div class="star">
										<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<!-- Testimonial section end -->
		</div>
		<?php
	}

}

new SPLC_Free_Loader();

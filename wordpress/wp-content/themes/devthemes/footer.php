<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Huy-Dev
 */

?>
</div>
</div>
<!-- <footer id="colophon" class="site-footer">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="site-info">
					<a href="<?php echo esc_url(__('https://wordpress.org/', 'devthemes')); ?>">
						<?php
						/* translators: %s: CMS name, i.e. WordPress. */
						printf(esc_html__('Proudly powered by %s', 'devthemes'), 'WordPress');
						?>
					</a>
					<span class="sep"> | </span>
					<?php
					/* translators: 1: Theme name, 2: Theme author. */
					printf(esc_html__('Theme: %1$s by %2$s.', 'devthemes'), 'devthemes', '<a href="https://webgool.com">Man</a>');
					?>
				</div><!-- .site-info -->
</div>
</div>
</div>

</footer> -->
<!-- Footer -->
<footer class="bg-dark text-center text-white">
	<!-- Grid container -->
	<div class="container p-4">
		<!-- Section: Social media -->
		<section class="mb-4">
			<!-- Facebook -->
			<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>

			<!-- Twitter -->
			<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>

			<!-- Google -->
			<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>

			<!-- Instagram -->
			<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>

			<!-- Linkedin -->
			<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>

			<!-- Github -->
			<a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
		</section>
		<!-- Section: Social media -->

		<!-- Section: Form -->
		<section class="">
			<form action="">
				<!--Grid row-->
				<div class="row d-flex justify-content-center">
					<!--Grid column-->
					<div class="col-auto">
						<p class="pt-2">
							<strong>Đăng ký nhận bản tin của chúng tôi</strong>
						</p>
					</div>
					<!--Grid column-->

					<!--Grid column-->
					<div class="col-md-5 col-12">
						<!-- Email input -->
						<div class="form-outline form-white mb-4">
							<input type="email" id="form5Example21" class="form-control" />
							<label class="form-label" for="form5Example21">Email address</label>
						</div>
					</div>
					<!--Grid column-->

					<!--Grid column-->
					<div class="col-auto">
						<!-- Submit button -->
						<button type="submit" class="btn btn-outline-light mb-4">
							Subscribe
						</button>
					</div>
					<!--Grid column-->
				</div>
				<!--Grid row-->
			</form>
		</section>
		<!-- Section: Form -->

		<!-- Section: Text -->

		<!-- Section: Text -->

		<!-- Section: Links -->
		<section class="">
			<!--Grid row-->
			<div class="row">
				<!--Grid column 1 -->
				<div class="col-lg-3 col-md-6 mb-4 mb-md-0">
					<h5 class="text-uppercase">Socical</h5>

					<ul class="list-unstyled mb-0">
						<li>

							<a href="https://www.facebook.com/profile.php?id=100036713001628">
								<i class="fa-brands fa-facebook"></i>
						</li>
						<li>
							<a href="#">
								<i class="fa-brands fa-facebook-messenger"></i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fa-brands fa-instagram"></i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fa-solid fa-magnifying-glass"></i>
							</a>
						</li>
					</ul>
				</div>
				<!--Grid column-->

				<!--Grid column 2-->
				<!-- <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
					<h5 class="text-uppercase">Links</h5>

					<ul class="list-unstyled mb-0">
						<li>
							<a href="#!" class="text-white">Link 1</a>
						</li>
						<li>
							<a href="#!" class="text-white">Link 2</a>
						</li>
						<li>
							<a href="#!" class="text-white">Link 3</a>
						</li>
						<li>
							<a href="#!" class="text-white">Link 4</a>
						</li>
					</ul>
				</div> -->
				<!--Grid column-->

				<!--Grid column 3-->
				<!-- <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
					<h5 class="text-uppercase">Links</h5>

					<ul class="list-unstyled mb-0">
						<li>
							<a href="#!" class="text-white">Link 1</a>
						</li>
						<li>
							<a href="#!" class="text-white">Link 2</a>
						</li>
						<li>
							<a href="#!" class="text-white">Link 3</a>
						</li>
						<li>
							<a href="#!" class="text-white">Link 4</a>
						</li>
					</ul>
				</div> -->
				<!--Grid column-->

				<!--Grid column 4-->
				<!-- <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
					<h5 class="text-uppercase">Links</h5>

					<ul class="list-unstyled mb-0">
						<li>
							<a href="#!" class="text-white">Link 1</a>
						</li>
						<li>
							<a href="#!" class="text-white">Link 2</a>
						</li>
						<li>
							<a href="#!" class="text-white">Link 3</a>
						</li>
						<li>
							<a href="#!" class="text-white">Link 4</a>
						</li>
					</ul>
				</div> -->
				<!--Grid column-->
			</div>
			<!--Grid row-->
		</section>
		<!-- Section: Links -->
	</div>
	<!-- Grid container -->

	<!-- Copyright -->
	<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
		© 2023 Copyright:
		<a class="text-white" href="https://mdbootstrap.com/">Mẫn</a>
	</div>
	<!-- Copyright -->
</footer>
<!-- Footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>
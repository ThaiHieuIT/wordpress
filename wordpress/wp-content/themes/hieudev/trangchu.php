<?php

/**
 *Template Name: Trang Chu
 */

get_header();
?>
<div id="slider">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php
				echo do_shortcode('[smartslider3 slider="2"]');
				?>
			</div>
		</div>
	</div>
</div>
<div id="category">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="chuongtrinhdaotao">
					<h2>CHƯƠNG TRÌNH ĐÀO TẠO</h2>
					<div class="row">
						<?php
							$args = array(
								'category__in' => array(24),
								'posts_per_page' => 6,
							);
							$my_query = new WP_Query($args);
							if ($my_query->have_posts()) {
								while ($my_query->have_posts()) {
									$my_query->the_post();
									echo '<div class="col-lg-4 col-md-6 col-sm-6 box-ctdaotao">
									<div class="box-content">
									<div class="title-content">';
									echo get_the_title();
									echo '</div><div class="nd-content">';
									echo get_the_content();
									echo '</div><div class="nd-sub-content">';
									echo get_the_excerpt();
									echo '</div>';
									$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
									echo $featured_img_url;
									echo '<div class="submit-button">
									<button><a href=".echo get_the_permalink();.">Xem Chi Tiết</a></button>
									</div></div></div>';
								}
							}else {
							}
							wp_reset_postdata();
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="content">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="daotao">
					<h2 class="title">ĐÀO TẠO KỸ NĂNG</h2>
					<p class="sub-title">Trang bị cho học viên học lái xe oto hiểu và nắm rõ luật an toàn giao thông cũng như cách xử lý các tình huống khi tham gia giao thông</p>
					<div class="row">
						<!-- <?php $daotao = array('dao_tao_01', 'dao_tao_2', 'dao_tao_3', 'dao_tao_4') ?> -->
						<div class="col-lg-3 col-md-6 col-sm-6 ">
							<div class="box-daotao">
								<?php $values = get_field('dao_tao_01'); ?>
								<img src="<?php echo $values['anh_dai_dien']; ?>" alt="">
								<div class="box-daotao-content">
									<?php echo $values['noi_dung']; ?>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="box-daotao">
								<?php $values = get_field('dao_tao_2'); ?>
								<img src="<?php echo $values['anh_dai_dien']; ?>" alt="">
								<div class="box-daotao-content">
									<?php echo $values['noi_dung']; ?>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="box-daotao">
								<?php $values = get_field('dao_tao_3'); ?>
								<img src="<?php echo $values['anh_dai_dien']; ?>" alt="">
								<div class="box-daotao-content">
									<?php echo $values['noi_dung']; ?>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="box-daotao">
								<?php $values = get_field('dao_tao_4'); ?>
								<img src="<?php echo $values['anh_dai_dien']; ?>" alt="">
								<div class="box-daotao-content">
									<?php echo $values['noi_dung']; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();

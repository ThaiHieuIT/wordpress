<?php

/**
 *  Template Name: Trangchu
 */

get_header();
?>
<div id="slider">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<!-- Code slider -->
				<?php if (function_exists('wd_slider')) {
					wd_slider(2);
				} ?>
			</div>
		</div>
	</div>
</div>

<!-- Chương Trình -->
<div class="wrapper">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="chuongtrinhdaotao">
						<h2>Chương Trình Đào Tạo</h2>
						<div class="row">
							<?php
							$args = array(
								'category__in' => array(46),
								'posts_per_page' => 6,
							);
							$my_query = new WP_Query($args);
							if ($my_query->have_posts()) {
								while ($my_query->have_posts()) {
										$my_query->the_post();
										echo '<div class="col-md-4 box-ctdaotao">
										<div class="box-content">
										<div class="title-content">';
										echo get_the_title();
										echo '</div><div class="nd-content">';
										echo get_the_content();
										echo '</div><div class="nd-sub-content">';
										echo get_the_excerpt();
										echo '</div>';
										$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
										// echo $featured_img_url;
										echo '<div class="submit-button">
										<button><a href=".echo get_the_permalink();.">Xem Chi Tiet</a> </button>
										</div></div></div>';
									



									
									
								}
							} else {
							}
							echo '<div class="col-md-4"><div class="tpk_card">
                        <div class="front"><img src="https://mascohue.edu.vn/wp-content/uploads/2021/12/xe-masco.png"></div>
                                <div class="back">
                                    <div class="details">
                                        <h2>Nộp hồ sơ đăng ký học lái xe Online<br><span>Xem thông tin bên dưới!</span></h2>
                                        <div class="social-icons">
                                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                                            <a href="#"><i class="fab fa-twitter"></i></a>
                                            <a href="#"><i class="fab fa-google-plus-g"></i></a>
                                            <a href="#"><i class="fab fa-instagram"></i></a>
                                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                        </div>
                                    </div>
                          </div>
                    </div>	
                    </div>';
							wp_reset_postdata();



							?>

						</div>

					</div>


				</div>
			</div>
		</div>
	</div>
</div>

<!-- End Chương Trinh -->
<!-- Dao Tao Kỹ Năng -->
<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="daotao">
					<h2 class="title">Đào Tạo Kỹ Năng</h2>
					<p class="sub-title">Trang bị cho học viên học lái xe oto hiểu và nắm rõ luật an toàn giao thông cũng như cách xử lý các tình huống khi tham gia giao thông</p>
					<div class="row">
						<?php $daotao = array('dao_tao_01', 'dao_tao_2');  ?>


						<div class="col-md-3">
							<div class="box-daotao">
								<?php $values = get_field('dao_tao_01'); ?>
								<img src="<?php echo $values['anh_dai_dien']; ?>" alt="">
								<div class="box-daotao-content">
									<?php echo $values['noi_dung']; ?>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="box-daotao">
								<?php $values = get_field('dao_tao_2'); ?>
								<img src="<?php echo $values['anh_dai_dien']; ?>" alt="">
								<div class="box-daotao-content">
									<?php echo $values['noi_dung']; ?>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="box-daotao">
								<?php $values = get_field('dao_tao_3'); ?>
								<img src="<?php echo $values['anh_dai_dien']; ?>" alt="">
								<div class="box-daotao-content">
									<?php echo $values['noi_dung']; ?>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="box-daotao">
								<?php $values = get_field('dao_tao_4'); ?>
								<img class="fire" src="<?php echo $values['anh_dai_dien']; ?>" alt="">
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
<!-- End Dao Tao Ky Nang -->
<?php
get_footer();

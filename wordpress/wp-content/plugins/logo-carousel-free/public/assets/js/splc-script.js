jQuery(document).ready(function ($) {
	$('.sp-lc-container').each(function (index) {
		var splc_container = $(this),
			splc_container_id = splc_container.attr('id'),
			spLogoCarousel = $('#' + splc_container_id + ' .sp-logo-carousel'),
			spLogoCarouselData = spLogoCarousel.data('carousel');
			
		// Check the length of carousel settings and already initialized or not.
		if (spLogoCarousel.length > 0 && ! $('#' + splc_container_id + ' .sp-logo-carousel[class*="-initialized"]').length > 0 ) {
			// Carousel Swiper for Standard mode.
			var splcSwiper = new Swiper('#' + splc_container_id + ' .sp-logo-carousel', {
				speed: spLogoCarouselData.speed,
				slidesPerView: spLogoCarouselData.slidesPerView.mobile,
				spaceBetween: spLogoCarouselData.spaceBetween,
				loop: spLogoCarouselData.infinite,
				loopFillGroupWithBlank: true,
				simulateTouch: spLogoCarouselData.simulateTouch,
				allowTouchMove: spLogoCarouselData.allowTouchMove,
				freeMode: spLogoCarouselData.freeMode,
				pagination:
					spLogoCarouselData.pagination == true
						? {
							el: '#' + splc_container_id + ' .swiper-pagination',
							clickable: true,
							renderBullet: function (index, className) {
								return '<span class="' + className + '"></span>'
							}
						}
						: false,
				autoplay: {
					delay: spLogoCarouselData.autoplay_speed
				},
				navigation:
					spLogoCarouselData.navigation == true
						? {
							nextEl: '#' + splc_container_id + ' .sp-lc-button-next',
							prevEl: '#' + splc_container_id + ' .sp-lc-button-prev'
						}
						: false,
				breakpoints: {
					576: {
						slidesPerView: spLogoCarouselData.slidesPerView.mobile_landscape,
					},
					768: {
						slidesPerView: spLogoCarouselData.slidesPerView.tablet,
					},
					992: {
						slidesPerView: spLogoCarouselData.slidesPerView.desktop,
					},
					1200: {
						slidesPerView: spLogoCarouselData.slidesPerView.lg_desktop,
					},
				},
				fadeEffect: {
					crossFade: true
				},
				keyboard: {
					enabled: true
				}
			})
			if (spLogoCarouselData.autoplay === false) {
				splcSwiper.autoplay.stop()
			}
			if (spLogoCarouselData.stop_onHover && spLogoCarouselData.autoplay) {
				$(spLogoCarousel).on({
					mouseenter: function () {
						splcSwiper.autoplay.stop();
					},
					mouseleave: function () {
						splcSwiper.autoplay.start();
					}
				});
			}
			$(window).on("resize", function () {
				splcSwiper.update()
			})
			$(window).trigger("resize")
		}

	});
	jQuery('body').find('.sp-logo-carousel.lcp-preloader').each(function () {
		var logo_carousel_id = $(this).attr('id'),
			parents_class = jQuery('#' + logo_carousel_id).parent('.logo-carousel-free-area'),
			parents_siblings_id = parents_class.find('.sp-logo-carousel-preloader').attr('id');
		$(document).ready(function () {
			$('#' + parents_siblings_id).animate({ opacity: 0 }, 600).remove();
		})
	})
});

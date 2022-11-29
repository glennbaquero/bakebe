<template>
	<div class="hm-frm3__holder frm-cntnr py-5" id="promos">
		<div class="frm-bckgrnds bring--back" style="background-image: url('images/home/frm3.png')"></div>
		<div class="hm-frm3__inner w-90 mx-auto text-center">
			<p class="frm-title mt-8 mb-5 text-white animate-up">PROMOS AND DISCOUNTS</p>
		</div>

		<div class="hm-frm3__sliderHolder animate-up inlineBlock-parent w-90 mx-auto">
			<div class="hm-frm3__slider shadow" v-for="promo in promos">
				<div class="w-100 inlineBlock-parent">
					<div class="w-40 align-t">
						<div class="frm-bckgrnds" :style="{ backgroundImage: 'url('+promo.img_src+')' }"></div>
					</div
					><div class="w-60 align-t">
						<div class="vertical-parent">
							<div class="vertical-align">
								<div class="w-80 mx-auto">
									<h4 class="font-weight-bold text-orange mb-4">{{ promo.name }}</h4>
									<p class="mb-5 w-90 scroll-custom">
										<span v-html="promo.description"></span>
									</p>	

									<button class="btn btn-primary font-weight-bold rounded-btn" @click="bookNow(promo)">BOOK NOW</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- <img class="arrows arrow-left" src="/images/home/arrow-left.png" alt="">
		<img class="arrows arrow-right" src="/images/home/arrow-right.png" alt=""> -->
	</div>
</template>

<script>
	
	export default {
		props: {
			promos: Array
		},

		// mounted() {
		// 	this.init();
		// },

		methods: {
			// init() {
			// 	setTimeout(() => {

			// 		$('.hm-frm3__sliderHolder').slick({
		 //                slidesToShow: 1,
		 //                slidesToScroll: 1,
		 //                dots: false,
		 //                centerMode: true,
		 //                speed: 1500,
		 //                arrows:true,
		 //                prevArrow: $('.arrow-left'),
			// 			nextArrow: $('.arrow-right'),
		 //                focusOnSelect: true,
		 //                responsive: [{
		 //                    breakpoint: 1024,
		 //                    settings: {
		 //                        slidesToShow: 1,
		 //                        slidesToScroll: 1,
		 //                        dots: false,
		 //                        arrows: true,
		 //                        prevArrow: $('.arrow-left'),
			// 					nextArrow: $('.arrow-right'),
		 //                        centerMode: false
		 //                    }
		 //                }]
		 //            });

		 //            $('.slick-prev').html('<svg class="bi bi-chevron-right" width="32" height="32" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6.646 3.646a.5.5 0 01.708 0l6 6a.5.5 0 010 .708l-6 6a.5.5 0 01-.708-.708L12.293 10 6.646 4.354a.5.5 0 010-.708z" clip-rule="evenodd"/></svg>');
		 //            $('.slick-next').html('<i class="fas fa-chevron-right"></i>');	
			// 	}, 200)
			// },

			bookNow(promo) {
				sessionStorage.setItem('promo', JSON.stringify(promo));
				window.location.href="/booking";
			}
		}
	}
</script>
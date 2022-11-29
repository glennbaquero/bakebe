@extends('guest.master')

{{-- @section('meta:title', 'Login') --}}

@section('content')

<div class="hm-frm1__holder frm-cntnr gradient--toRight">
	<div class="hm-frm1__inner w-90 mx-auto inlineBlock-parent">
		<div class="w-50">
			
		</div
		><div class="w-50">
			<div class="vertical-parent">
				<div class="vertical-align">
					<div class="hm-frm1__content">
						<h1 class="hm-frm1__title mb-2 text-white">BakeBe Ph</h1>
						<h5 class="hm-frm1__content font-weight-bold mb-5 text-white">Co-Baking Space that teaches you to bake with an app!</h5>
						<a class="btn btn-primary rounded-btn font-weight-bold" href="#">BOOK NOW</a>
					</div>	
				</div>
			</div>
		</div>
	</div>

	<div class="frm-bckgrnds size--contain left--bg" style="background-image:url('./images/home/frm1.png');"></div>
	<div class="frm-bckgrnds size--contain right--bg" style="background-image: url('images/assets/rightcake.png')"></div>

	<svg class="bring--back" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fff" fill-opacity="1" d="M0,288L26.7,293.3C53.3,299,107,309,160,266.7C213.3,224,267,128,320,80C373.3,32,427,32,480,74.7C533.3,117,587,203,640,240C693.3,277,747,267,800,234.7C853.3,203,907,149,960,112C1013.3,75,1067,53,1120,58.7C1173.3,64,1227,96,1280,138.7C1333.3,181,1387,235,1413,261.3L1440,288L1440,320L1413.3,320C1386.7,320,1333,320,1280,320C1226.7,320,1173,320,1120,320C1066.7,320,1013,320,960,320C906.7,320,853,320,800,320C746.7,320,693,320,640,320C586.7,320,533,320,480,320C426.7,320,373,320,320,320C266.7,320,213,320,160,320C106.7,320,53,320,27,320L0,320Z"></path></svg>
</div>

<div class="hm-frm2__holder frm-cntnr pt-8 pb-10">
	<div class="hm-frm2__inner w-90 mx-auto">
		<div class="hm-frm2__content w-100 text-center">
			<p class="frm-title text-secondary mb-8">HOW TO RESERVE</p>

			<div class="w-100 inlineBlock-parent">
				<div class="w-25 hm-frm2__col align-t">
					<div class="hm-frm2__col--img mx-auto mb-3" style="background-image:url('./images/home/shop.png')"></div>

					<h6 class="font-weight-bold w-40 mx-auto mb-3">Choose a branch location</h6>

					<p class="w-80 mx-auto">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
				</div
				><div class="w-25 hm-frm2__col align-t">
					<div class="hm-frm2__col--img mx-auto mb-3" style="background-image:url('./images/home/laptop.png')"></div>

					<h6 class="font-weight-bold w-40 mx-auto mb-3">Choose a pastry to make</h6>

					<p class="w-80 mx-auto">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
				</div
				><div class="w-25 hm-frm2__col align-t">
					<div class="hm-frm2__col--img mx-auto mb-3" style="background-image:url('./images/home/calendar.png')"></div>

					<h6 class="font-weight-bold w-40 mx-auto mb-3">Schedule and reserve a spot</h6>

					<p class="w-80 mx-auto">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
				</div
				><div class="w-25 hm-frm2__col">
					<div class="hm-frm2__col--img mx-auto mb-3" style="background-image:url('./images/home/hand.png')"></div>

					<h6 class="font-weight-bold w-40 mx-auto mb-3">Pay and confirm your reservation</h6>

					<p class="w-80 mx-auto">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
				</div>
			</div>
		</div>
	</div>
	<div class="frm-bckgrnds size--contain left--bg" style="background-image: url('images/assets/rightcake.png')"></div>
</div>

<home-view>
</home-view>

<div class="hm-frm4__holder frm-cntnr py-10">
	<div class="hm-frm4__inner w-90 mx-auto inlineBlock-parent">
		<div class="w-50">
			<div class="vertical-parent">
				<div class="vertical-align">
					<div class="hm-frm4__content w-70 mx-auto">
						<p class="frm-title text-secondary">WE'RE EXCITED TO SEE YOU!</p>
					
						<div class="inlineBlock-parent mb-4">
							<i class="fas fa-map-marker-alt text-primary mr-2"></i>
							<a class="text-dark-gray" href="#" target="_blank">SM Aura, Taguig, Metro Manila, Philippines</a>
						</div>
						<div class="inlineBlock-parent">
							<i class="far fa-envelope text-primary mr-2"></i>
							<a class="text-dark-gray" href="#" target="_blank">info@bakebe.com</a>	
						</div>	
					</div>
				</div>
			</div>
		</div
		><div class="w-50">
			<div class="map--holder">
				<div class="shadow" id="map"></div>
			</div>
		</div>
	</div>

	<div class="frm-bckgrnds size--contain bring--back left--bg" style="background-image: url('images/assets/leftcake.png')"></div>
	<div class="frm-bckgrnds size--contain bring--back right--bg" style="background-image: url('images/assets/rightcake.png')"></div>
</div>

@endsection
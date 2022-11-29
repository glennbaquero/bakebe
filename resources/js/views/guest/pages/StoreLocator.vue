<template>
	<div class="hm-frm4__inner w-90 mx-auto inlineBlock-parent">
		<div class="w-50">
			<div class="vertical-parent">
				<div class="vertical-align">
					<div class="hm-frm4__content w-70 mx-auto animate-up">
						<p class="frm-title text-secondary">WE'RE EXCITED TO SEE YOU!</p>
						<template v-for="branch in branches">
							<div class="inlineBlock-parent">
								<i class="fas fa-map-marker-alt text-primary mr-2"></i>
								<a class="text-dark-gray" :href="location(branch)" target="_blank">{{ branch.name }}</a>
							</div>
							<div class="inlineBlock-parent mb-4">
								<i class="far fa-envelope text-primary mr-2"></i>
								<a class="text-dark-gray" :href="'mailto:'+branch.contact_email" target="_blank">{{ branch.contact_email }}</a>	
							</div>	
						</template>
					</div>
				</div>
			</div>
		</div
		><div class="w-50">
			<div class="map--holder slideLeft-delay">
				<div class="shadow" id="map"></div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {

		props: {
			branches: Array
		},

		mounted() {
			setTimeout(() => {
				this.init();
			}, 2000)
		},

		methods: {
			init() {
				var locations = [];

				_.each(this.branches, (branch) => {
					var name = branch.name;
					var latitude = parseFloat(branch.latitude);
					var longitude = parseFloat(branch.longitude);

					locations.push([name, latitude, longitude, 0]);
				});

				var mapLat = locations[0][1],
				    mapLng = locations[0][2];

				var mapOptions = {
				    zoom: 10,
				    center: new google.maps.LatLng(mapLat, mapLng),
				     styles: [{"featureType":"administrative","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","elementType":"all","stylers":[{"saturation":-100},{"lightness":"50"},{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"lightness":"30"}]},{"featureType":"road.local","elementType":"all","stylers":[{"lightness":"40"}]},{"featureType":"transit","elementType":"all","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]},{"featureType":"water","elementType":"labels","stylers":[{"lightness":-25},{"saturation":-100}]}]
				};

				var mapElement = document.getElementById('map');
				var map = new google.maps.Map(mapElement, mapOptions);
				var infowindow = new google.maps.InfoWindow({});

				var newMarker, i;

				for (i = 0; i < locations.length; i++) {
				  newMarker = new google.maps.Marker({
				    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
				    map: map,
				    title: 'BakeBe',
				    icon: 'images/home/pin.png',
				    animation: google.maps.Animation.DROP,
				  })

				  google.maps.event.addListener(
				    newMarker,
				    'click',
				    (function(newMarker, i) {
				      return function() {
				        infowindow.setContent(locations[i][0])
				        infowindow.open(map, newMarker)
				      }
				    })(newMarker, i)
				  )
				}
			},

			location(branch) {
				var lat = branch.latitude;
				var long = branch.longitude;

				var url = 'https://www.google.com/maps?q=';

				url += lat+','+long;

				return url;
			}
		}
	}
</script>
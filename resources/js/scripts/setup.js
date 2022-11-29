export const setup = {
	init() {
		let closeBtn = $('.user-profile-sidebar-close-btn');
		let sidebar = $('.user-profile-sidebar');
		$('.user-profile-sidebar-btn').on('click', () => {
			sidebar.addClass('active');
			closeBtn.addClass('active');
		});

		closeBtn.on('click', () => {
			sidebar.removeClass('active');
			closeBtn.removeClass('active');
		});

		var $window = $(window);
	      $window.scroll(function() {
	      	  
	      	  if($window.scrollTop() > 0) {
	              $('.hdr--holder, .mbl--hdr').addClass('bg-white').addClass('shadow');
	          	} else {
	              $('.hdr--holder, .mbl--hdr').removeClass('bg-white').removeClass('shadow');
	          	}
	      });


	    
            // var mapLat = 14.5476262,
            //     mapLng = 121.0523612;

            // var locations = [
            //   ['fairview', 14.5476262, 121.0523612, 0],
            // ];

            // var mapOptions = {
            //     zoom: 13,
            //     center: new google.maps.LatLng(mapLat, mapLng),
            //      styles: [{"featureType":"administrative","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","elementType":"all","stylers":[{"saturation":-100},{"lightness":"50"},{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"lightness":"30"}]},{"featureType":"road.local","elementType":"all","stylers":[{"lightness":"40"}]},{"featureType":"transit","elementType":"all","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]},{"featureType":"water","elementType":"labels","stylers":[{"lightness":-25},{"saturation":-100}]}]
            // };

            // var mapElement = document.getElementById('map');
            // var map = new google.maps.Map(mapElement, mapOptions);
            // // var marker = new google.maps.Marker({
            // //     position: new google.maps.LatLng(mapLat, mapLng),
            // //     map: map,
            // //     title: 'BakeBe',
            // //     icon: 'images/home/pin.png',
            // //     animation: google.maps.Animation.DROP,
            // // });
            // var infowindow = new google.maps.InfoWindow({});

            // var newMarker, i;

            // for (i = 0; i < locations.length; i++) {
            //   newMarker = new google.maps.Marker({
            //     position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            //     map: map,
            //     title: 'BakeBe',
            //     icon: 'images/home/pin.png',
            //     animation: google.maps.Animation.DROP,
            //   })

            //   google.maps.event.addListener(
            //     newMarker,
            //     'click',
            //     (function(newMarker, i) {
            //       return function() {
            //         infowindow.setContent(locations[i][0])
            //         infowindow.open(map, newMarker)
            //       }
            //     })(newMarker, i)
            //   )
            // }
            // offsetCenter(map.getCenter(),-200,0);

            function offsetCenter(latlng, offsetx, offsety) {

                var scale = Math.pow(2, map.getZoom());

                var worldCoordinateCenter = map.getProjection().fromLatLngToPoint(latlng);
                var pixelOffset = new google.maps.Point((offsetx/scale) || 0,(offsety/scale) ||0);

                var worldCoordinateNewCenter = new google.maps.Point(
                    worldCoordinateCenter.x - pixelOffset.x,
                    worldCoordinateCenter.y + pixelOffset.y
                );

                var newCenter = map.getProjection().fromPointToLatLng(worldCoordinateNewCenter);

                map.setCenter(newCenter);
            }

            // offsetCenter(map.getCenter(),-200,0);

            function initBt2() {
  var bt = document.querySelectorAll('#component-2')[0];
  var filter = document.querySelectorAll('#filter-goo-2 feGaussianBlur')[0];
  var particleCount = 12;
  var colors = ['#DE8AA0', '#8AAEDE', '#FFB300', '#60C7DA']

  bt.addEventListener('click', function() {
    var particles = [];
    var tl = new TimelineLite({onUpdate: function() {
      filter.setAttribute('x', 0);
    }});
    
    tl.to(bt.querySelectorAll('.button__bg'), 0.6, { scaleX: 1.05 });
    tl.to(bt.querySelectorAll('.button__bg'), 0.9, { scale: 1, ease: Elastic.easeOut.config(1.2, 0.4) }, 0.6);

    for (var i = 0; i < particleCount; i++) {
      particles.push(document.createElement('span'));
      bt.appendChild(particles[i]);

      particles[i].classList.add(i % 2 ? 'left' : 'right');
      
      var dir = i % 2 ? '-' : '+';
      var r = i % 2 ? getRandom(-1, 1)*i/2 : getRandom(-1, 1)*i;
      var size = i < 2 ? 1 : getRandom(0.4, 0.8);
      var tl = new TimelineLite({ onComplete: function(i) {
        particles[i].parentNode.removeChild(particles[i]);
        this.kill();
      }, onCompleteParams: [i] });

      tl.set(particles[i], { scale: size });
      tl.to(particles[i], 0.6, { x: dir + 20, scaleX: 3, ease: SlowMo.ease.config(0.1, 0.7, false) });
      tl.to(particles[i], 0.1, { scale: size, x: dir +'=25' }, '-=0.1');
      if(i >= 2) tl.set(particles[i], { backgroundColor: colors[Math.round(getRandom(0, 3))] });
      tl.to(particles[i], 0.6, { x: dir + getRandom(60, 100), y: r*10, scale: 0.1, ease: Power3.easeOut });
      tl.to(particles[i], 0.2, { opacity: 0, ease: Power3.easeOut }, '-=0.2');
    }
  });
}


      $(".howto").click(function() {
          $('html, body').animate({
              scrollTop: ($("#howto").offset().top - 130)
          }, 1000);
      });

      $(".promos").click(function() {
          $('html, body').animate({
              scrollTop: ($("#promos").offset().top - 130)
          }, 1000);
      });


      $(document).ready(function () {
          // Read the cookie and if it's defined scroll to id
          var scroll = $.cookie('scroll');
          if(scroll){
              scrollToID(scroll, 1000);
              $.removeCookie('scroll');
          }

          // Handle event onclick, setting the cookie when the href != #
          $('.colum').click(function (e) {
              e.preventDefault();
              var id = $(this).data('id');
              var href = $(this).attr('href');
              if(href === '#'){
                  scrollToID(id, 1000);
              } else{
                  $.cookie('scroll', id);
                  window.location.href = href;
              }
          });

          //scrollToID function
          function scrollToID(id, speed) {
              
              $('html, body').animate({
                scrollTop: ($('#' + id).offset().top -150)
            }, 1000);
          }
      });

      // Mobile Header

      $('.mbl--HamMenu').click(function() {
        $('.mbl-menu__holder').addClass('show');
      });

      $('.mbl--close, .close--menu').click(function() {
        $('.mbl-menu__holder').removeClass('show');
      });


        
	},
}
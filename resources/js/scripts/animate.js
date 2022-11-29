$(document).ready(function() {
    animate.init();
});

var animate = {

    init: function() {
        var setup = this.setup;
        setup.animateEvents();
    },

    setup: {

        animateEvents: function() {

            // Init ScrollMagic
            var controller = new ScrollMagic.Controller();

            $('.animate-up').each(function() {
                var tl = new TimelineMax()
                .fromTo(this, 1,
                    { y: "40px", opacity: "0", ease:Power0.easeIn },
                    { y: "0%", opacity: "1", ease:Power0.easeIn })

                var fadeScene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: .7,
                    reverse:true,
                    })
                    .setTween(tl)
                    .addTo(controller);
            });

            $('.animate-frm2').each(function() {
                var tl = new TimelineMax()
                .fromTo(this, 1,
                    { y: "40px", opacity: "0", ease:Power0.easeIn },
                    { y: "0%", opacity: "1", ease:Power0.easeIn })

                var fadeScene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: .9,
                    reverse:true,
                    })
                    .setTween(tl)
                    .addTo(controller);
            });


            $('.animate-up__delay').each(function() {
                var tl = new TimelineMax()
                .delay(1)
                .fromTo(this, 1,
                    { y: "40px", opacity: "0", ease:Power0.easeIn },
                    { y: "0%", opacity: "1", ease:Power0.easeIn })

                var fadeScene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: .7,
                    reverse:true,
                    })
                    .setTween(tl)
                    .addTo(controller);
            });


             $('.stagger-text').each(function() {
                var tl = new TimelineMax({delay:0, repeat:0, repeatDelay:0});
                tl.staggerFrom(".stagger-text__animated", 1.1, { y: '-30px', opacity: 0, ease: Power1.easeNone }, 0,)
                  .staggerTo(".stagger-text__animated", 1.1, { y: '0px', opacity: 1, ease: Power1.easeOut }, 0,)

                var fadeScene = new ScrollMagic.Scene({
                    triggerElement: '.stagger-animation',
                    triggerHook: .6,
                    reverse:true,
                })
                .setTween(tl)
                .addTo(controller);
            });

            $('.slideRight-delay').each(function() {
                var tl = new TimelineMax()
                .delay(1)
                .fromTo(this, 1,
                    { x: "-200px", opacity: 0, ease:Power0.easeIn },
                    { x: "0px", opacity: 1, ease:Power0.easeIn })

                var fadeScene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: .5,
                    reverse:false,
                    })
                    .setTween(tl)
                    .addTo(controller);
            });

            $('.slideLeft-delay').each(function() {
                var tl = new TimelineMax()
                .delay(1)
                .fromTo(this, 1,
                    { x: "200px", opacity: 0, ease:Power0.easeIn },
                    { x: "0px", opacity: 1, ease:Power0.easeIn })

                var fadeScene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: .5,
                    reverse:false,
                    })
                    .setTween(tl)
                    .addTo(controller);
            });

            

            // // Home Frame 2
            var controller = new ScrollMagic.Controller();

             $('.home-frm2__animation').each(function() {
             var tl = new TimelineMax({repeat:0, repeatDelay:0.5,});
             tl.staggerFrom(".hm-frm2__col", 1, {opacity:0}, 0.5,)
             .staggerTo(".hm-frm2__col", 1, {opacity:1}, 0.5,)

             var fadeScene = new ScrollMagic.Scene({
                 triggerElement: '.home-frm2__animation',
                 triggerHook: .7,
                 reverse:false,
             })
             .setTween(tl)
             .addTo(controller);
            });

        },        
    },
}
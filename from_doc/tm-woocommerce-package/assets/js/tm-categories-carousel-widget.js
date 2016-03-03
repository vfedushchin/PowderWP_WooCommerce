(function($){
    $('.swiper-container').each( function() {
        var swiper = null,
            uniqId = $(this).data('uniq-id'),
            slidesPerView = parseFloat( $(this).data('slides-per-view') ),
            slidesPerGroup = parseFloat( $(this).data('slides-per-group') ),
            slidesPerColumn = parseFloat( $(this).data('slides-per-column') ),
            spaceBetweenSlides = parseFloat( $(this).data('space-between-slides') ),
            durationSpeed = parseFloat( $(this).data('duration-speed') ),
            swiperLoop = $(this).data('swiper-loop'),
            freeMode = $(this).data('free-mode'),
            grabCursor = $(this).data('grab-cursor'),
            mouseWheel = $(this).data('mouse-wheel');

        var swiper = new Swiper( '#' + uniqId, {
                slidesPerView: slidesPerView,
                slidesPerGroup: slidesPerGroup,
                slidesPerColumn: slidesPerColumn,
                spaceBetween: spaceBetweenSlides,
                speed: durationSpeed,
                loop: swiperLoop,
                freeMode: freeMode,
                grabCursor: grabCursor,
                mousewheelControl: mouseWheel,
                paginationClickable: true,
                nextButton: '#' + uniqId + '-next',
                prevButton: '#' + uniqId + '-prev',
                pagination: '#' + uniqId + '-pagination',
                breakpoints: {
                    992: {
                        slidesPerView: Math.ceil( slidesPerView * 0.75 ),
                        spaceBetween: Math.ceil( spaceBetweenSlides * 0.75 )
                    },
                    768: {
                        slidesPerView: Math.ceil( slidesPerView * 0.5 ),
                        spaceBetween: Math.ceil( spaceBetweenSlides * 0.5 )
                    },
                }
            }
        );
    });
    $('.tm-categories-carousel-widget-sale-end-date[data-countdown]').each(function() {
        var $this = $(this), finalDate = $(this).data('countdown'), format = $(this).data('format');
        $this.countdown(finalDate, function(event) {
            $this.html(event.strftime(format));
        });
    });
})(jQuery);
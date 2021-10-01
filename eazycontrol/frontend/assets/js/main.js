function initWOW() {
    let wow = new WOW(
        {
            boxClass:     'wow',      // default
            animateClass: 'animated', // default
            offset:       0,          // default
            mobile:       true,       // default
            live:         true        // default
        }
    )
    wow.init();
}

let swiper = [];
function initSwiper() {
    $('.-swiper .swiper').each(function (index) {

        let swiperConfig = {
            slidesPerView: 'auto',
            spaceBetween: 0,
            grabCursor: true,
            watchOverflow: true,
            loop: true,
            navigation: {
                nextEl: $(this).find(".swiper-button-next"),
                prevEl: $(this).find(".swiper-button-prev"),
            },
        }

        if($(this).data('swiper-delay')) {
            swiperConfig.autoplay = {delay: $(this).data('swiper-delay')}
        }

        if($(this).data('centered-slides')) {
            swiperConfig.centeredSlides = true
        }

        swiper[index] = new Swiper($(this).find('.swiper-container'), swiperConfig);

    });
}

$(document).ready(function () {
    initWOW();
    initSwiper();
});
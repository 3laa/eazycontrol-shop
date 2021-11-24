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

function initMagnific() {
    $('.-magnific').magnificPopup({
        callbacks: {
            elementParse: function(item) {
                if($(item.el).hasClass('-iframe')) {
                    item.type = 'iframe';
                } else {
                    item.type = 'image';
                }
            }
        }
    });

    $('.-magnific-gallery').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a.-magnific-link', // the selector for gallery item
            gallery: {
                enabled:true
            },
            callbacks: {
                elementParse: function(item) {
                    if($(item.el).hasClass('-iframe')) {
                        item.type = 'iframe';
                    } else {
                        item.type = 'image';
                    }
                }
            }
        });
    });
}

function iniHeadroom()
{
    const headroom  = new Headroom(document.querySelector("body"));
    headroom.init();
}

function initAside()
{
    $(document).on('click', '[data-aside]', function (event) {
        event.preventDefault();
        $('#' + $(this).data('aside')).toggleClass('-open');
        $('body').toggleClass('noscroll');
    })

    $(document).on('click', 'aside.aside .-close', function (event) {
        event.preventDefault();
        $(this).parents('aside.aside').removeClass('-open')
        $('body').removeClass('noscroll');
    })
}

function iniToTop()
{
    $(document).on('click', '.to-top', function () {
        $('html, body').stop().animate({ scrollTop: 0 }, 500)
    });
}

$(document).ready(function () {
    initWOW();
    iniToTop();
    initAside();
    initSwiper();
    iniHeadroom();
    initMagnific();
});

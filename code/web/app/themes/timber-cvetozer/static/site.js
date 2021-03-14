const mainCategorySliderSelect  = '.swiper-main-category-container';
const mainCategorySliderOptions = {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    autoplay: {
    delay: 5000,
    disableOnInteraction: false
    },
    slidesPerView: 'auto',
    // If we need pagination
    pagination: {
        el: '.swiper-pagination'
    }
};

const categorySwiper        = new Swiper(mainCategorySliderSelect, mainCategorySliderOptions);
const categorySliderElement = document.querySelector(mainCategorySliderSelect);

categorySliderElement.addEventListener('mouseenter', function () {
categorySwiper.autoplay.stop();
});

categorySliderElement.addEventListener('mouseleave', function () {
categorySwiper.autoplay.start();
});
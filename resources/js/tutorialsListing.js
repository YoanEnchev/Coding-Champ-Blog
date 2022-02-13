let tutorialsListing = {
    'init': () => {

        const categoriesNavigationBtns = $('#categories-navigation button');

        let tutorialsSwiper = new Swiper('.tutorials-swiper')
        .on( 'slideChange ', function() {
        
            // !!! Does not work without setTimeout due to some reason
            setTimeout(function() {
                let swiperIndex = parseInt($('.swiper-slide-active').attr('data-slide-index'));

                $(categoriesNavigationBtns.get(swiperIndex)).trigger('click');
            }, 100);
         });

        categoriesNavigationBtns.click(function() {
            let index = parseInt($(this).attr('data-slide-index'));
    
            tutorialsSwiper.slideTo(index);
        });
    }
}

export default tutorialsListing;
import React from 'react';
import { Swiper, SwiperSlide } from 'swiper/react';
import TutorialItem from './TutorialItem';

let swiperRef = null; 

class TutorialsSwiper extends React.Component {

  render() {
    
    // Activate after rendering.
    setTimeout(() => swiperRef.slideTo(this.props.activeIndex));

    let tutorialNumber = 0;

    return (
      <Swiper
        slidesPerView={1}
        onSwiper={(ref) => swiperRef = ref}
        onSlideChange={() => this.props.onActiveIndexUpdate(swiperRef.activeIndex)}
        >
        {this.props.categories.map((category, categoryIndex) => {

          return <SwiperSlide 
              className='row mx-0 px-3 tutorials-listing-container'
              key={categoryIndex} 
              >

            {category.tutorials.map((tutorial) => {
              tutorialNumber++;

              return <TutorialItem
                key={tutorialNumber}
                number={tutorialNumber}
                url={this.props.baseUrl.replace('tutorial-base-url', tutorial.url_name)} 
                name={tutorial.pretty_name} />
             })}

          </SwiperSlide> 
        })}
      </Swiper>
    );
  }
}

export default TutorialsSwiper;
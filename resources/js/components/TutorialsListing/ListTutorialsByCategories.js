import CategoryNavigation from "./CategoryNavigation";
import TutorialsSwiper from "./TutorialsSwiper";
import React from 'react';

class ListTutorialsByCategories extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            activeIndex: 0
        }
    }

    render() {
        return (
            <div>
                <CategoryNavigation categories={fromPHP.categories} activeIndex={this.state.activeIndex} onActiveIndexUpdate={this.updateActiveState.bind(this)} />
    
                <TutorialsSwiper baseUrl={fromPHP.tutorialBaseUrl} categories={fromPHP.categories} activeIndex={this.state.activeIndex} onActiveIndexUpdate={this.updateActiveState.bind(this)} />
            </div>
        );
    }

    updateActiveState(index) {
        //console.log('ListTutorialsByCategories.updateActiveState ', index);
        this.setState({activeIndex: index});
    }
}

export default ListTutorialsByCategories;
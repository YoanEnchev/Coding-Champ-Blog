import React from 'react';

class CategoryNavigation extends React.Component {

    render() {

        return (
          <div className="btn-group categories-btns d-block mx-auto mt-5 mb-4" role="group" aria-label="Basic example">
              {this.props.categories.map((cat, index) => {

                    let btnClasses = "btn";
                    if(index === this.props.activeIndex) btnClasses += " active";

                    return <button type="button" className={btnClasses} onClick={() => this.props.onActiveIndexUpdate(index)} key={index}>{cat.pretty_name}</button>;
              })}
          </div>
      );
    }
}

export default CategoryNavigation;
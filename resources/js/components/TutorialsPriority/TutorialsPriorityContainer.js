import React from 'react';
import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'
const ErrorSwal = withReactContent(Swal)

class TutorialsPriorityContainer extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            tutorials: [],
            techEntityId: this.props.techEntities[0].id,
            categoryId: this.props.categories[0].id
        }
    }

    render() {

        return (
            <div>
                <div className="form-group">
                    <label htmlFor="tech-entities-select">Tech Entity</label>
                    <select id="tech-entities-select" className="form-control" onChange={this.onTechEntityChange.bind(this)}>
                        { this.props.techEntities.map( techEntity => <option value={techEntity.id} key={techEntity.id}>{techEntity.pretty_name}</option> )}
                    </select>
                </div>
                <div className="form-group mb-4">
                    <label htmlFor="categories-select">Categories</label>
                    <select id="categories-select" className="form-control" onChange={this.onCategoryChange.bind(this)}>
                        { this.props.categories.map(category => <option value={category.id} key={category.id}>{category.pretty_name}</option> )}
                    </select>
                </div>
                <table className="table tutorials-priority">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {this.state.tutorials.map((tutorial, index) => {
                            
                            let actionButtons = [];

                            if(index > 0) {
                                // Move down button is supported.
                                actionButtons.push(this.renderSwapPriorityButton(
                                    tutorial, this.state.tutorials[index - 1], true
                                ));
                            }

                            if(index < this.state.tutorials.length - 1) {
                                // Move up button is supported.
                                actionButtons.push(this.renderSwapPriorityButton(
                                    tutorial, this.state.tutorials[index + 1], false
                                ));
                            }
                            
                            return (<tr key={index}>
                                    <td>{tutorial.pretty_name}</td>
                                    <td>
                                        {actionButtons}
                                    </td>
                                </tr>) 
                        })}
                    </tbody>
                </table>
            </div>
        );
    }

    // moveUp is false for down pointing arrow.
    renderSwapPriorityButton(tutorial1, tutorial2, moveUp) {
        
        let url = this.props.baseSwapUrl
            .replace('tutorial-1', tutorial1.id)
            .replace('tutorial-2', tutorial2.id)

        let direction = moveUp ? 'up' : 'down';
        let formClasses = 'd-inline-block ';
        if(moveUp) formClasses += 'mr-3';

        return (
            <form className={formClasses} action={url} method="POST" key={url} onSubmit={this.swapTutorials.bind(this)}>
                <button className={`btn btn-dark move-${direction}`}>
                    <i className={`fas fa-angle-${direction}`}></i>
                </button>
            </form>
        );
    }

    onTechEntityChange(e) {
        
        this.setState({techEntityId: e.target.value}, this.updateTutorialsList);
    }

    onCategoryChange(e) {
        
        this.setState({categoryId: e.target.value}, this.updateTutorialsList);
    }

    componentDidMount() {
        this.updateTutorialsList();
    }

    updateTutorialsList() {

        fetch(this.props.extractTutorialsBaseUrl
                .replace('tech-entity', this.state.techEntityId)
                .replace('category', this.state.categoryId)
        )
        .then(response => response.json())
        .then((tutorials) => {

            this.setState({
                tutorials
            })
        })
        .catch(() => {
            return ErrorSwal.fire(<p>Failed loading tutorials.</p>)
        })
    }

    swapTutorials(e) {
        
        e.preventDefault();
        let actionUrl = e.target.action;

        fetch(actionUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                _token: fromPHP.csrfToken
            })
        })
        .then(() => {
            // In future it could be rewritten by changing the state itself locally. 
            this.updateTutorialsList();
        })
        .catch(() => {
            return ErrorSwal.fire(<p>Failed switching priority.</p>)
        })

    }
}

export default TutorialsPriorityContainer
function TutorialItem(props) {
    return (
        <a className="col-12 col-sm-6 col-md-4 tutorial-list-item px-0 mb-3"
            href={props.url}>
            <div className="mx-2">
                <div className="d-flex align-items-center justify-content-center">
                    <h3 className="text-white text-center px-3 pt-5 tutorial-name">
                        {props.name}
                    </h3>
                </div>
                <span className="tutorial-number">{props.number}</span>
            </div>
        </a>
    );
}

export default TutorialItem;
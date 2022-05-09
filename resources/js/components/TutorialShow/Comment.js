import React from 'react';
import PostCommentForm from './PostCommentForm';
import State from './State';

class Comment extends React.Component {

    render() {

        return (
            <div className="comment mt-4">
                <div className="content-wrapper ">
                    <h4 className="d-inline-block username mb-3">{ this.props.username }</h4>
                    <span className="float-right">{ this.props.date }</span>
                    <br />
                    <p>{this.props.text}</p>

                    <a className="reply d-inline-block mt-3" onClick={ () => this.props.onReplyClick(this.props.id) }>Reply</a>
                </div>

                <div className="subcomments">
                    {this.props.subcomments.map((comment, index) => {
                        return (<Comment key={index} 
                                date={comment.date} 
                                username={comment.user.username}
                                text={comment.text}
                                subcomments={comment.subcomments || []}
                                id={comment.id}
                                onReplyClick={this.props.onReplyClick.bind(this)}
                            />
                            )
                    } )}

                    { this.mustShowPostCommentForm() ? <PostCommentForm
                        addCommentUrl={fromPHP.addCommentUrl}
                        parentId={this.props.id} /> : '' }
                </div>
            </div>
        )
    }

    mustShowPostCommentForm() {
        return State.openReplyForCommentId == this.props.id;
    }
}

export default Comment;
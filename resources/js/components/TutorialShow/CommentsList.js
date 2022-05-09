import React from 'react';
import Comment from './Comment';
import PostCommentForm from './PostCommentForm';
import State from './State';
import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'
const AuthSwal = withReactContent(Swal)

class CommentsList extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            showReplyForCommentId: 0 // 0 means that reply box is not opened for any comment.
        }
    }

    render() {
        return  <div>
            {this.props.comments.map((comment, index) => <Comment key={index} 
                date={comment.date} 
                username={comment.user.username}
                text={comment.text}
                id={comment.id}
                subcomments={comment.subcomments || []}
                onReplyClick={this.onReplyClick.bind(this)}
            /> )
            }
            { (fromPHP.isLoggedIn === 'yes') ? <PostCommentForm addCommentUrl={fromPHP.addCommentUrl} /> : '' }
        </div>
    }

    onReplyClick(commentID) {

        if(fromPHP.isLoggedIn === 'no') {
            AuthSwal.fire('Sign in to comment.');
            return;
        }


        // Triggers update so reply box is hidden for every comment except the one that was clicked lastly.
        this.setState({showReplyForCommentId: commentID});
        
        // Accessed inside comment class.
        // A cleaner solution than passing more properties recursivelty.
        State.openReplyForCommentId = commentID;
    }
}

export default CommentsList;
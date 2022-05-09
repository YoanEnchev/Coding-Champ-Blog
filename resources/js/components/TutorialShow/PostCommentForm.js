import React from 'react';

function PostCommentForm(props) {
    
    return <form method="POST" action={props.addCommentUrl} className="mt-3">
        <div className="form-group">
            <label className="w-100">
                <textarea className="form-control" rows="5" placeholder="Add a comment" maxLength="500" name="text"></textarea>
            </label>
        </div>
        <button type="submit" className="btn comment-btn text-white">Post Comment</button>
        {props.parentId ? <input type="hidden" name="parent_id" value={props.parentId} /> : ''}
    
        <input type="hidden" name="_token" value={fromPHP.csrfToken} />
    </form>
}

export default PostCommentForm;
<div class="comment mt-4 text-justify float-left w-100">
    
    <div class="content-wrapper shadow ">
        <h4 class="d-inline-block">{{ $comment->user->username }}</h4>
        <span class="float-right">{{ $comment->created_at_formatted }}</span>
        <br>
        <p>{{$comment->text}}</p>

        <a class="reply d-inline-block mt-3">Reply</a>
    </div>
   
    <div class="subcomments">
        @foreach($comment->subcomments as $loopComment)
            @include('comments.item', ['comment' => $loopComment])
        @endforeach
    </div>
</div>
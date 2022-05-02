<div class="comment mt-4 text-justify float-left">
    <h4>Jhon Doe</h4>
    <span>- 20 October, 2018</span>
    <br>
    <p>{{$comment->text}}</p>
   
    <div class="subcomments">
        @foreach($comment->subcomments as $loopComment)
            @include('comments.item', ['comment' => $loopComment])
        @endforeach
    </div>
</div>
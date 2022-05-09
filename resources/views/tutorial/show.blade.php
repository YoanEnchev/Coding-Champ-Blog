@extends('layouts.main', [
    'pageID' => 'tutorials-show',
    'title' => $title,
    'description' => $tutorial->description,
    'isArticle' => true
])
    
@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="tutorial-content col-md-9">
                <h1 class="text-center h3 mb-4 mt-4">{{$title}}</h1>
                <div class="tutorial-content">
                    {!! $tutorial->content !!}
                </div>

                <p class="h2 mt-5 mb-4">Tags</p>
                <div class="tags-list">
                    @foreach($tags as $tag)
                        <a href="{{ route('tags.show', ['techEntityUrl' => $techEntity->url_name, 'tagUrlName' => $tag->url_name]) }}" class="tag"> {{$tag->pretty_name}} </a>
                    @endforeach
                </div>

                <p class="h2 mt-5 mb-0">Comments</p>
                <div class="comments-list" id="comments-list">
                </div>
                <div class="add-comment-container mt-3">                    
                    @if(!Auth::check())
                        <a class="btn w-100 sign-in-to-comment text-white" href="{{ route('login') }}">Sign in to comment</a>
                    @endif
                </div>
            </div>
            <aside class="col-md-3 hidden-sm">
                <h2 class="h6 mt-4">Languages</h2>
                <ul class="nav nav-pills nav-stacked languages-list mt-3">
                    @foreach($techEntities as $loopTechEntity)
                        <li class="{{$loopTechEntity->id === $techEntity->id ? 'active' : ''}}">
                            <a href="{{ route('tutorials.index', ['techEntityUrl' => $loopTechEntity->url_name]) }}">{{$loopTechEntity->pretty_name}}</a>
                        </li>
                    @endforeach
                </ul>

                  <h2 class="h6 mt-4">Tutorials</h2>
                  <ul class="nav nav-pills nav-stacked tutorials-list mt-3">
                    @foreach($tutorials as $loopTutorial)
                        <li class="{{$loopTutorial->id === $tutorial->id ? 'active' : ''}}">
                            <a href="{{route('tutorials.show', [
                                'techEntityUrl' => $techEntity->url_name,
                                'tutorialUrl' => $loopTutorial->url_name
                            ])}}">{{$loopTutorial->pretty_name}}</a>
                        </li>
                    @endforeach
                  </ul>
            </aside>
        </div>
    </div>
@endsection

@section('js-vars')
    var fromPHP = {
        cmMode: "{{$techEntity->cm_mode}}",
        comments: @json($comments),
        addCommentUrl: "{{ route('comment.store', compact('tutorial')) }}",
        csrfToken: '{{ csrf_token() }}',
        isLoggedIn: '{{Auth::check() ? 'yes' : 'no'}}'
    };
@endsection
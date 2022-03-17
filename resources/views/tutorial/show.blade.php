@extends('layouts.main', [
    'title' => $title,
    'description' => $tutorial->description,
    'tutorialIsOpened' => true
])
    
@section('content')
    <div class="container">
        <div class="row">
            <div class="opened-tutorial col-md-9">
                <h1 class="text-center h3 mb-4 mt-4">{{$title}}</h1>
                {!! $tutorial->content !!}
            </div>
            <aside class="col-md-3 hidden-sm">
                <div class="app-stores">
                    <p>Practice with tests, puzzles and battles with our mobile app!</p>
                    <a href="https://play.google.com/store/apps/details?id=com.crazycoding">
                        <img src="../../imgs/google-play-badge.png" alt="Coding Champ">
                    </a>
                </div>

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
        cmMode: "{{$techEntity->cm_mode}}"
    };
@endsection
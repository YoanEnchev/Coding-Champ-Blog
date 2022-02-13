@extends('layouts.main')
    
@section('content')
    <div class="container">
        <div class="row">
            <div class="opened-tutorial col-md-9">
                <h1 class="text-center h3 mb-4 mt-4">{{$tutorialName}}</h1>
                {!! $content !!}
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
                    @foreach(config('techEntities_link_url_pretty_name') as $url => $name)
                        <li class="{{$techEntityUrl === $url ? 'active' : ''}}">
                            <a href="{{ route('tutorials.index', ['techEntityUrl' => $url]) }}">{{$name}}</a>
                        </li>
                    @endforeach
                </ul>

                  <h2 class="h6 mt-4">Tutorials</h2>
                  <ul class="nav nav-pills nav-stacked tutorials-list mt-3">
                    @foreach($tutorials as $tutorial)
                        <li class="{{$tutorialName === $tutorial->pretty_name ? 'active' : ''}}">
                            <a href="{{route('tutorials.show', [
                                'techEntityUrl' => $tutorial->techEntityUrlName,
                                'tutorialUrl' => $tutorial->url_name
                            ])}}">{{$tutorial->pretty_name}}</a>
                        </li>
                    @endforeach
                  </ul>
            </aside>
        </div>
    </div>
@endsection

@section('js-vars')
    var fromPHP = {
        cmMode: "{{$cmMode}}"
    };
@endsection
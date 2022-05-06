@extends('layouts.main', [
    'pageID' => 'tutorials-index'
])

@section('content')
    <div>
        <div class="mx-4 tutorials-listing-page mx-auto my-4">
            <div id="list-tutorials-by-categories"></div>
        </div>
    </div>
@endsection

@section('js-vars')
    var fromPHP = {
        techEntityUrl: "{{$techEntity->url_name}}",
        tutorialBaseUrl: "{{route('tutorials.show', [
            'techEntityUrl' => $techEntity->url_name,
            'tutorialUrl' => 'tutorial-base-url'
        ])}}",
        categories: @json($categories)
    };
@endsection
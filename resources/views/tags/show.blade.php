@extends('layouts.main')

@section('content')
    <div class="container">
        <p class="h4 mt-4 mb-5 text-center">{{$techEntity->pretty_name}} tutorials with tag {{$tag->pretty_name}}.</p>
        
        <div class="row mx-3 tutorials-listing-container">
            @foreach ($tutorials as $tutorial)
                <a class="col-12 col-sm-6 col-md-4 tutorial-list-item px-0 mb-3"
                    href="{{route('tutorials.show', [
                        'techEntityUrl' => $techEntity->url_name,
                        'tutorialUrl' => $tutorial->url_name
                    ])}}">
                    <div class="mx-2">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="text-white text-center px-3 pt-5 tutorial-name">
                                {{$tutorial->pretty_name}}
                            </h3>
                        </div>
                    
                        <span class="tutorial-number">{{ $loop->index + 1 }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
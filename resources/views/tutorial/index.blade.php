@extends('layouts.main')

@section('content')
    <div>
        <div class="mx-4 tutorials-listing-page mx-auto my-4">

            <div class="btn-group categories-btns d-block mx-auto mt-5 mb-4" role="group" aria-label="Basic example" id="categories-navigation">
                <button type="button" class="btn active" data-slide-index="0">Basic</button>
                <button type="button" class="btn" data-slide-index="1">Advanced</button>
                <button type="button" class="btn" data-slide-index="2">OOP</button>
            </div>

            <div class="swiper-container tutorials-swiper">
                <div class="swiper-wrapper">
                    <?php $tutorialNum = 1; ?>
                    @foreach($categories as $categoryData)
                        <div class="swiper-slide" data-slide-index="{{ $loop->index }}">
                            <div class="row mx-3">
                                @foreach($categoryData as $category => $tutorial)
                                    <a class="col-12 col-sm-6 col-md-4 tutorial-list-item px-0 mb-3"
                                        href="{{route('tutorials.show', [
                                            'techEntityUrl' => $tutorial->tech_entity_url_name,
                                            'tutorialUrl' => $tutorial->url_name
                                        ])}}">
                                        <div class="mx-2">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <h3 class="text-white text-center px-3 pt-5 tutorial-name">
                                                    {{$tutorial->pretty_name}}
                                                </h3>
                                            </div>
                                        
                                            <span class="tutorial-number">{{ $tutorialNum }}</span>
                                        </div>
                                    </a>
                                    <?php $tutorialNum++; ?>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.main')

@section('content')
<section class="clean-block clean-hero" style="background-image: url( {{url('imgs/home/desk.jpg')}} ); color: rgba(9, 162, 255, 0.85);">
    <div class="text">
        <h2>Coding Blog</h2>
        <p>Learn programming through simple tutorials and code examples.</p>
    </div>
</section>
    <section class="features-clean">
        <div class="container">
            <div class="intro">
                <h2 class="text-center mt-3">Learn Multiple Languages</h2>
                <p class="text-center">Extend and apply your knowledge in many of the most popular programming languages.</p>
            </div>
            <ul class="row pl-0 language-list mt-3">
                @foreach($techEntities as $techEntity)
                    <li class="col-12 col-sm-6 col-md-4 mb-3">
                        <div class="d-flex align-items-center justify-content-center tech-entity-container">
                            <a class="text-white py-3 h3 w-100 h-100" href="{{ route('tutorials.index', ['techEntityUrl' => $techEntity->url_name]) }}">
                                {{ $techEntity->pretty_name }}
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
    <header class="header-blue explore">
        <div class="container hero" style="margin: 0 !important;display: contents;">
            <div class="row" style="margin-right: 0px;margin-left: 0px;max-width: 1200px;margin: 0 auto;">
                <div class="col text-center" style="width: 100%;">
                    <h2 style="text-align: center;margin-top: 12px;font-size: 29px;font-weight: bold;letter-spacing: 0.7px;margin-bottom: 64px;margin-top: 64px;color: white;">Explore Coding Champ</h2>
                    <div class="phone-mockup-wrappers">
                        <div class="phone-mockup" style="background-position: center;background-size: cover;text-align: left;float: left;"><img class="device" src="{{url('imgs/phone.svg')}}" alt="puzzles">
                            <div class="screen" style="background: url('{{url('imgs/puzzle.jpg')}}');background-position: center;background-size: cover;"></div>
                        </div>
                        <div class="phone-mockup" style="background-position: center;background-size: cover;margin-left: 0;position: relative;"><img class="device" src="{{url('imgs/phone.svg')}}" alt="tests">
                            <div class="screen" style="background: url('{{url('imgs/battle.jpg')}}');background-position: center;background-size: cover;"></div>
                        </div>
                    </div>
                    <div class="text-block" style="display: inline-block;margin-left: 2rem;height: initial;vertical-align: middle;">
                        <p style="display: inline-block;max-width: 400px;text-align: left;margin-bottom: 0;font-weight: 400;">Programming needs to be fun and with many challenges. Keeping it simple and teaching you the practical stuff is the best way to keep you motivated and lead you to the path of becoming the best developer.<br><br>Ready to become a Coding Champ? Download it now!<br></p><a class="google-play-btn text-left" href="https://play.google.com/store/apps/details?id=com.crazycoding" style="display: block;margin-top: 2em;"><img src="{{url('imgs/google-play-badge.png')}}" style="max-width: 290px;" alt="Google Play"></a>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection
@extends('layouts.main')

@section('content')
    <header class="header-blue pb-0">
        <div class="container hero mt-0">
            <div class="row">
                <div class="col motto-column">
                    <div>
                        <h1>Coding Champ</h1>
                        <p style="font-weight: 400;">Learn programming via challenges for any language!<br></p><a class="google-play-btn" href="https://play.google.com/store/apps/details?id=com.crazycoding"><img src="{{url('imgs/google-play-badge.png')}}" alt="Google Play" style="max-width: 290px;"></a>
                    </div>
                </div>
                <div class="col offset-lg-1 offset-xl-0 d-lg-block phone-holder text-center col-12 col-lg-5">
                    <div class="phone-mockup my-5"><img class="device" src="{{url('imgs/phone.svg')}}" alt="programming-languages">
                        <div class="screen" style="background: url('{{url('imgs/programming-languages.jpg')}}')"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="features-clean">
        <div class="container">
            <div class="intro">
                <h2 class="text-center">Features</h2>
                <p class="text-center">Lots of features to make your learning exciting and effective.</p>
            </div>
            <div class="row features">
                <div class="col-sm-6 col-lg-4 item"><i class="fa fa-file-alt icon"></i>
                    <h3 class="name">Tests</h3>
                    <p class="description">Questions to tests your knowledge, improve your understanding and prepare you for interviews.</p>
                </div>
                <div class="col-sm-6 col-lg-4 item"><i class="fa fa-puzzle-piece icon"></i>
                    <h3 class="name">Puzzles</h3>
                    <p class="description">Improve your&nbsp;analyzation skills of various programming topics and boost your code readability.</p>
                </div>
                <div class="col-sm-6 col-lg-4 item"><i class="fa fa-rocket icon"></i>
                    <h3 class="name">Quiz Battles</h3>
                    <p class="description">Make your learning more exciting via battles. The more you learn, the more likely you're to win!</p>
                </div>
                <div class="col-sm-6 col-lg-4 item"><i class="fa fa-book icon"></i>
                    <h3 class="name">Tutorials</h3>
                    <p class="description">Simplified tutorials, suitable for anyone, with many code examples to apply the knowledge.</p>
                </div>
                <div class="col-sm-6 col-lg-4 item"><i class="fa fa-graduation-cap icon"></i>
                    <h3 class="name">Exams</h3>
                    <p class="description">Еvaluate&nbsp;your knowledge with a grade for programming category and language.</p>
                </div>
                <div class="col-sm-6 col-lg-4 item"><i class="fas fa-award icon"></i>
                    <h3 class="name">Ranks</h3>
                    <p class="description">Climb up ranks and reach the top by completing programming challenges.</p>
                </div>
            </div>
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
                        <p style="display: inline-block;max-width: 400px;text-align: left;margin-bottom: 0;font-weight: 400;">Programming needs to be fun and with many challenges. Keeping it simple and teaching you the practical stuff is the best way to keep you motivated and lead you to the path of becoming the best developer.<br><br>Ready to become a coding champ? Download it now!<br></p><a class="google-play-btn text-left" href="https://play.google.com/store/apps/details?id=com.crazycoding" style="display: block;margin-top: 2em;"><img src="{{url('imgs/google-play-badge.png')}}" style="max-width: 290px;" alt="Google Play"></a>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection
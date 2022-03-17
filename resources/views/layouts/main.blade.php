<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO -->
    <title>{{ $title ?? '' }}</title>
    <meta name="google-site-verification" content="kOFJ1fnPdoCJ7gr0YLi7tAnylFpWCXopp8OS2mQ5tjw" />
    
    <meta name="description" 
    content="{{isset($description) ? $description : ''}}">
    <meta property="og:description" content="{{isset($description) ? $description : ''}}">

    @if(isset($keywords))
        <meta name="keywords" content="{{$keywords}}">
    @endif
    
    <meta property="og:site_name" content="Coding Champ">
    <meta property="og:title" content="{{isset($title) ? $title : ''}}">

    <meta property="og:url" content="{{url()->current()}}">
    
    @if(isset($tutorialIsOpened) && $tutorialIsOpened)
        {{--If tutorial is opened--}}
        <meta property="og:type" content="article">
    @endif

    <link rel="apple-touch-icon" sizes="180x180" href="{{url('favicon.ico')}}">
    <link rel="icon" type="image/x-icon" sizes="32x32" href="{{url('favicon-32x32.ico')}}">
    <link rel="icon" type="image/x-icon" sizes="16x16" href="{{url('favicon-16x16.ico')}}">
    <link rel="shortcut icon" href="{{url('favicon.ico')}}">

    <link rel="manifest" href="{{url('manifest.json')}}">
    
    {{--
    <link rel="mask-icon" href="https://tutorialzine.com/safari-pinned-tab.svg" color="#1da7da">
    --}}
    
    <meta name="apple-mobile-web-app-title" content="Coding Champ">
    <meta name="application-name" content="Coding Champ">

    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.10.1/sweetalert2.min.css" integrity="sha512-zEmgzrofH7rifnTAgSqWXGWF8rux/+gbtEQ1OJYYW57J1eEQDjppSv7oByOdvSJfo0H39LxmCyQTLOYFOa8wig==" crossorigin="anonymous" />
    
    @if(isset($cmMode))
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/codemirror.min.css" integrity="sha512-xIf9AdJauwKIVtrVRZ0i4nHP61Ogx9fSRAkCLecmE2dL/U8ioWpDvFCAy4dcfecN72HHB9+7FfQj3aiO68aaaw==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/scroll/simplescrollbars.min.css" integrity="sha512-2y3NTsei81d5emn5nwrdflyI5EGULwKXRZ0BCbO55cjgQ8x62X4ydH/jbnzrKnxArstf79F9n6z1j2MtVmJ8YA==" crossorigin="anonymous" />
    @endif
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.5.0/css/all.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body {{isset($noScroll) ? 'style=overflow-y:hidden' : ''}}>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">Coding Champ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/') }}">Home
              <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="tutorialsDropdownLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Tutorials
              </a>
              <div class="dropdown-menu" aria-labelledby="tutorialsDropdownLink">
                  @foreach($techEntities as $techEntity)
                    <a class="dropdown-item" href="{{ route('tutorials.index', ['techEntityUrl' => $techEntity->url_name]) }}">{{$techEntity->pretty_name}}</a>
                  @endforeach
              </div>
            </li>
            @if(Auth::user())
      
              @if(Auth::user()->is_admin)
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Admin Panel
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="{{ route('admin.generate.mobile-app-data-file', ['use_explanation' => true]) }}">Generate Data File For MA (With Explanation)</a>
                      <a class="dropdown-item" href="{{ route('admin.generate.mobile-app-data-file', ['use_explanation' => false]) }}">Generate Data File For MA (No Explanation)</a>
      
                      <a class="dropdown-item" href="{{ route('admin.tutorial.index', ['techEntity' => \App\TechEntity::first()]) }}">Tutorials Editing</a>
                      <a class="dropdown-item" href="{{ route('admin.generate.sitemap')}}">Update sitemap.xml</a>

                      <a class="dropdown-item" href="{{ route('admin.user-battles.index')}}">Robot Battles</a>
                      
                      <a class="dropdown-item" href="{{ route('admin.project.index', ['techEntity' => \App\TechEntity::first()]) }}">Projects</a>
                      <a class="dropdown-item" href="{{ route('admin.challenge.index', ['techEntity' => \App\TechEntity::first()]) }}">Challenges</a>
                      
                      <a class="dropdown-item" href="{{ route('admin.generate.list-ids') }}">List User Ids</a>
                  </div>
                </li>
              @endif
              <li class="nav-item">
                  <form action="{{ route('logout') }}" method="POST">
                      {{ csrf_field() }}
                      <button class="nav-link btn btn-link font-weight-normal font-size-md" type="submit">LogOut</button>
                    </form>
                </li>
            @endif
          </ul>
        </div>
      </nav>
  @include('partials.messages')
    @yield('content')
    <footer class="footer-basic p-2">
        <p class="copyright mt-0">
          Coding Champ © {{date("Y")}}
          <a href="{{route('privacy-policy')}}">Privacy Policy</a>
          <a href="{{route('terms-and-conditions')}}">Terms And Conditions</a>
        </p>
    </footer>
</div>
</body>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.10.1/sweetalert2.min.js" integrity="sha512-geFV99KIlNElg1jwzHE6caxE2tLBEw5l+e2cTRPJz273bbiQqpEuqvQzGAmJTdMfUJjoSDXkaUInwjiIz1HfqA==" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    {{--CM mode:--}}

    @if(isset($cmMode))
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/codemirror.min.js" integrity="sha512-zuvaVNiXwWY7U7HEdXsoTislTEElpKLELFoyQw0Bg7zfGhC4vG8eAhCxIQAvHmprW7dFhTq5zshUko4K3B4mSA==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/scroll/simplescrollbars.min.js" integrity="sha512-64cpf7lwBf0oDuXWU1z8J6dUTn6JVU3eEXzOJJ1FWYEnStF3E9FGKoCqiTiLKspyK2vhOm5VuYATv2oY7OdcAQ==" crossorigin="anonymous"></script>

    
        @if($cmMode === "text/javascript")
            <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/mode/javascript/javascript.min.js" integrity="sha512-EKqHN1wvffwb5Hx+y5JeXPGNDKKxxW1Es4hexkgSf+QkQwEDNs6bp4KKCRNVLUbRPGkrDQ7yEVwvDg1tq7n1fA==" crossorigin="anonymous"></script>
        @else
            <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/mode/clike/clike.min.js" integrity="sha512-ipYOW38nHWkd5HgeKxdGd+7zft6CTWXXBtXxfmrJm+xOgcYTnV2RnHtfrtXDwjlxRRLL+e163/V8A/H9g8G+JQ==" crossorigin="anonymous"></script>    

            @if($cmMode === "text/x-php")
                <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/mode/php/php.min.js" integrity="sha512-jyLP33GKBy8PM3/KVNMuBWqMlTFvFTJhzbX2KW/JEmZs5mLmn51EYrTEUQNjbIIHOGeZ+ntIMnh5H/yAzh/EKA==" crossorigin="anonymous"></script>
            @elseif($cmMode === "text/x-python")
                <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/mode/python/python.min.js" integrity="sha512-wWnd0mjQTkxcs4nTZyu9TqfeDbXghPYwndBrvzjmyAgNKX4rJ5xPirrescJZkVtrWHIb9//dMABkORz6FSJfYA==" crossorigin="anonymous"></script>
            @endif
        @endif
     @endif
    {{--/CM mode:--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

    <script>
        @yield('js-vars')
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</html>

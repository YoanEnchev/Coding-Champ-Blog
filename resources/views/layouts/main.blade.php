<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO -->
    <title>{{ $title ?? '' }}</title>

    <meta name="description" 
    content="{{isset($description) ? $description : ''}}">
    <meta property="og:description" content="{{isset($description) ? $description : ''}}">

    @if(isset($keywords))
        <meta name="keywords" content="{{$keywords}}">
    @endif
    
    <meta property="og:site_name" content="Coding Blog">
    <meta property="og:title" content="{{isset($title) ? $title : ''}}">

    <meta property="og:url" content="{{url()->current()}}">
    
    @if(isset($isArticle) && $isArticle)
        {{--If tutorial is opened--}}
        <meta property="og:type" content="article">
    @endif

    <link rel="apple-touch-icon" sizes="180x180" href="{{url('favicon.ico')}}">
    <link rel="icon" type="image/x-icon" sizes="32x32" href="{{url('favicon-32x32.ico')}}">
    <link rel="icon" type="image/x-icon" sizes="16x16" href="{{url('favicon-16x16.ico')}}">
    <link rel="shortcut icon" href="{{url('favicon.ico')}}">

    <link rel="manifest" href="{{url('manifest.json')}}">
    
    <meta name="apple-mobile-web-app-title" content="Coding Blog">
    <meta name="application-name" content="Coding Blog">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.5.0/css/all.css">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body @if(isset($pageID)) id="{{$pageID}}" @endif>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('home') }}">Coding Blog</a>
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
              <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Admin Panel
              </a>
              <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('admin.tutorial.index', ['techEntity' => \App\Models\TechEntity::first()]) }}">Tutorials Editing</a>
                  <a class="dropdown-item" href="{{ route('admin.tech-entity.index') }}">Tech Entities</a>
                  <a class="dropdown-item" href="{{ route('admin.category.index') }}">Categories</a>
              </div>
            </li>
          @endif
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                <button class="nav-link btn btn-link font-weight-normal font-size-md" type="submit">LogOut</button>
            </form>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Sign up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Sign in</a>
          </li>
        @endif
      </ul>
    </div>
  </nav>
  @include('partials.messages')
  @yield('content')

</body>
    <script>
        @yield('js-vars')
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</html>

@extends('layouts.main')

@section('content')
<h1 class="h2 mt-5 text-center" style="margin-bottom: 2rem">Programming Languages</h1>

<ul class="nav nav-pills nav-stacked languages-list mt-3 row mx-3">
    @foreach(config('techEntities_link_url_pretty_name') as $url => $name)
        <li class="col-12 col-sm-6 col-md-4 mb-3">
            <div class="d-flex align-items-center justify-content-center tech-entity-container">
                <a class="text-white py-3 h3" href="{{ route('tutorials.index', ['techEntityUrl' => $url]) }}">{{$name}}</a>
            </div>
        </li>
    @endforeach
</ul>
@endsection
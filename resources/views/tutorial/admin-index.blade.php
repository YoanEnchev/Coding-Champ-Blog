@extends('layouts.main', [
    'pageID' => 'admin-tutorials'
])

@section('content')
    <div class="container">
        <div class="dropdown mb-3">
            <button class="btn btn-primary dropdown-toggle mt-2" type="button" id="tech-entity-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{$selectedTechEntity->pretty_name}}
            </button>
            <div class="dropdown-menu" aria-labelledby="tech-entity-dropdown">
                @foreach ($techEntities as $techEntity)
                    <a class="dropdown-item {{$selectedTechEntity->id === $techEntity->id ? 'active': ''}}" 
                        href="{{ route('admin.tutorial.index', compact('techEntity')) }}">
                        {{ $techEntity->pretty_name }}
                    </a>
                @endforeach
            </div>
            <div class="float-right">
                <a class="btn btn-success mt-2" role="button" href="{{route('admin.tutorial.create')}}">Insert Tutorial</a>
                <a class="btn btn-success mt-2 ml-4" role="button" href="{{route('admin.tutorial.priority-listing')}}">Priority Listing</a>
            </div>
        </div>
        
        <?php $counter = 1; ?>
        @foreach($categories as $category)
            <h2>{{$category->pretty_name}}</h2>
    
            <ul class="list-group tutorials-listing mt-4 mb-5">
                @foreach($category->tutorials as $tutorial)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge badge-primary badge-pill">{{ $counter }}</span>
                            <span>{{$tutorial->pretty_name}}</span>
                        </div>
                        <div>
                            @if($tutorial->description)
                                <span class="badge badge-info badge-pill mr-0">Has Description</span>
                            @endif

                            @if($tutorial->keywords)
                                <span class="badge badge-success badge-pill mr-3">Has Keywords</span>
                            @endif
                            
                            <a href="{{route('tutorials.show', [
                                'techEntityUrl' => $selectedTechEntity->url_name,
                                'tutorialUrl' => $tutorial->url_name
                            ])}}" role="button" class="btn btn-primary">View</a>
                            <a href="{{route('admin.tutorial.edit', compact('tutorial'))}}" role="button" class="btn btn-dark">Edit</a>
                            
                            <form method="POST" action="{{route('admin.tutorial.destroy',  compact('tutorial'))}}" class="d-inline-block">
                                <button class="btn btn-danger" type="submit">Delete</button>
                                {{csrf_field()}}
                                {{ method_field('delete') }}
                            </form>
                        </div>
                    </li>
                    <?php $counter++; ?>
                @endforeach
            </ul>
        @endforeach
    </div>    
@endsection
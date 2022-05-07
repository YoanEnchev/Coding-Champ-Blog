@extends('layouts.main')

@section('content')
<ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <span>{{ $tutorial->pretty_name }}</span>
            <span class="badge badge-primary badge-pill">{{ $category->pretty_name }}</span>
        </div>
        <span class="badge badge-dark badge-pill">{{ $techEntity->pretty_name }}</span>
    </li>
</ul>

<form method="POST" action="{{route('admin.tutorial.update', compact('tutorial'))}}" class="mx-4 mt-5 mb-3">
    <div class="form-group">
        <label for="category">Category</label>
        <select class="form-control" id="category" name="category_id">
            @foreach($categories as $categoryLoop)
                <option value="{{$categoryLoop->id}}" @if($category->id === $categoryLoop->id) selected @endif>{{$categoryLoop->pretty_name}}</option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group">
        <label for="pretty-name">Pretty Name</label>
        <input type="text" class="form-control" id="pretty-name" value="{{ $tutorial->pretty_name }}" name="pretty_name">
    </div>
    <div class="form-group">
        <label for="url-name">Url Name</label>
        <input type="text" class="form-control" id="url-name" value="{{ $tutorial->url_name }}" name="url_name">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" id="description" value="{{ $tutorial->description }}" name="description">
    </div>
    <div class="form-group">
        <label for="keywords">Keywords</label>
        <input type="text" class="form-control" id="keywords" value="{{ $tutorial->keywords }}" name="keywords">
    </div>
    <div class="form-group">
        <label for="tags">Tags</label>
        <input type="text" class="form-control" id="tags" value="{{$tagsText}}" name="tags_text">
    </div>



    <button type="submit" class="btn btn-primary">Edit</button>

    {{ method_field('PUT') }}
    {{ csrf_field() }}
</form>
@endsection
@extends('layouts.main')

@section('content')
    <div class="container">
        <h2 class="mb-3">Create Tutorial</h2>

        <form method="POST" action="{{route('admin.tutorial.store')}}">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="tech-entity">Tech Entity</label>
                <select class="form-control" id="tech-entity" name="tech_entity_id">
                    @foreach($techEntities as $techEntity)
                        <option value="{{$techEntity->id}}">{{$techEntity->pretty_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category_id">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->pretty_name}}</option>
                    @endforeach
                </select>
            </div>


            <button type="submit" class="btn btn-primary">Create</button>
            {{csrf_field()}}
        </form>

    </div>
@endsection
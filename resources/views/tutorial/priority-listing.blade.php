@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="form-group">
            <label for="tech-entities-select">Tech Entity</label>
            <select id="tech-entities-select" class="form-control" id="tech-entity" name="tech_entity_id">
                @foreach ($techEntities as $techEntity)
                    <option value="{{$techEntity->id}}">{{ $techEntity->pretty_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-4">
            <label for="categories-select">Categories</label>
            <select id="categories-select" class="form-control" id="tech-entity" name="category_id">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{ $category->pretty_name }}</option>
                @endforeach
            </select>
        </div>
        <table class="table tutorials-priority">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div> 

    <div class="d-none">
        <div id="swap-with-above">
            <form class="d-inline-block mr-3" action="set-in-js" method="POST">
                <button class="btn btn-dark move-up">
                    <i class="fas fa-angle-up"></i>
                </button>
                {{ csrf_field() }}

            </form>
        </div>
        <div id="swap-with-below">
            <form class="d-inline-block" action="set-in-js" method="POST">
                <button class="btn btn-dark move-down">
                    <i class="fas fa-angle-down"></i>
                </button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection

@section('js-vars')
    var fromPHP = {
        tutorialsBaseUrl: '{{route('admin.tutorial.in-techEntity.category', [
            'techEntity' => '',
            'category' => ''
        ])}}',
        swapBaseUrl: '{{route('admin.tutorial.swap-priorities', [
            'tutorial1' => '',
            'tutorial2' => ''
        ])}}'
    };
@endsection
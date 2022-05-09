@extends('layouts.main', [
    'title' => 'Create Tech Entity'
])

@section('content')

    <div class="container">
        @include('tech-entities.create-edit-form', [
            'url' => route('admin.tech-entity.store'),
            'btnText' => 'Create',
            'isEdit' => false
        ])
    </div>
@endsection
@extends('layouts.main', [
    'title' => 'Edit Tech Entity'
])

@section('content')

    <div class="container">
        @include('tech-entities.create-edit-form', [
            'url' => route('admin.tech-entity.update', compact('techEntity')),
            'btnText' => 'Edit',
            'isEdit' => true
        ])
    </div>
@endsection
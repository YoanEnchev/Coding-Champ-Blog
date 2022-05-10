@extends('layouts.main', [
    'title' => 'Create Category'
])

@section('content')

    <div class="container">
        @include('categories.partials.create-edit-form', [
            'url' => route('admin.category.store'),
            'btnText' => 'Create',
            'isEdit' => false
        ])
    </div>
@endsection
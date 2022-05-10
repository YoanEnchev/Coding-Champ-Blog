@extends('layouts.main', [
    'title' => 'Edit Category'
])

@section('content')

    <div class="container">
        @include('categories.partials.create-edit-form', [
            'url' => route('admin.category.update', compact('category')),
            'btnText' => 'Edit',
            'isEdit' => true
        ])
    </div>
@endsection
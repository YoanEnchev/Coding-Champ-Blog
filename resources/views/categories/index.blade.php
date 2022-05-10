@extends('layouts.main', [
    'title' => 'Categories'
])

@section('content')

    <div class="container">
        <h1 class="h2 mt-5 text-center mb-3">Categories</h1>
        <a class="btn btn-success mb-3" role="button" href="{{route('admin.category.create')}}">Create Category</a>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->pretty_name }}</td>
                        <td>
                            <a class="btn btn-dark" href="{{ route('admin.category.edit',  compact('category')) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.category.destroy',  compact('category')) }}" class="d-inline-block">
                                <button class="btn btn-danger" type="submit">Delete</button>
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                            </form>
                        </td>
                    </tr>
                @endforeach
             </tbody>
        </table>
    </div>
@endsection
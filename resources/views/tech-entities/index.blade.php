@extends('layouts.main', [
    'title' => 'Tech Entities'
])

@section('content')

    <div class="container">
        <h1 class="h2 mt-5 text-center mb-3">Tech Entities</h1>
        <a class="btn btn-success mb-3" role="button" href="{{route('admin.tech-entity.create')}}">Create Tech Entity</a>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach($techEntities as $techEntity)
                    <tr>
                        <td>{{ $techEntity->pretty_name }}</td>
                        <td>
                            <a class="btn btn-dark" href="{{ route('admin.tech-entity.edit',  compact('techEntity')) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.tech-entity.destroy',  compact('techEntity')) }}" class="d-inline-block">
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
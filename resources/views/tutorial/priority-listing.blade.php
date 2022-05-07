@extends('layouts.main', [
    'pageID' => 'tutorials-priority-listing'
])

@section('content')
    <div class="container">
        
        <div id="tutorials-priority-container">

        </div>
    </div> 
@endsection

@section('js-vars')
    var fromPHP = {
        techEntities: @json($techEntities),
        categories: @json($categories),
        extractTutorialsBaseUrl: '{{route('admin.tutorial.in-techEntity.category', [
            'techEntity' => 'tech-entity',
            'category' => 'category'
        ])}}',
        swapBaseUrl: '{{route('admin.tutorial.swap-priorities', [
            'tutorial1' => 'tutorial-1',
            'tutorial2' => 'tutorial-2'
        ])}}',
        csrfToken: '{{ csrf_token() }}'
    };
@endsection
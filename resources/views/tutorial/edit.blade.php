@extends('layouts.main')

@section('content')
<ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <span>{{$tutorial->pretty_name}}</span>
            <span class="badge badge-primary badge-pill">{{$category}}</span>
        </div>
        <span class="badge badge-dark badge-pill">{{ $techEntity->pretty_name }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <span>Questions count:</span>
            <span class="badge badge-primary badge-pill">{{ $questionsCount }}</span>
        </div>
        <button class="btn btn-primary" data-toggle="modal" data-target="#create-question-modal">Add Question</button>
    </li>

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <span>Puzzles count:</span>
            <span class="badge badge-dark badge-pill">{{ $puzzlesCount }}</span>
        </div>
        <button class="btn btn-dark" data-toggle="modal" data-target="#create-puzzle-modal">Add Puzzle</button>
    </li>
</ul>

<form method="POST" action="{{route('admin.tutorial.update', compact('tutorial'))}}" class="mx-4 mt-5 mb-3">
    <div class="form-group">
        <label for="pretty-name">Pretty Name</label>
        <input type="text" class="form-control" id="pretty-name" value="{{$tutorial->pretty_name}}" name="pretty_name">
    </div>
    <div class="form-group">
        <label for="url-name">Url Name</label>
        <input type="text" class="form-control" id="url-name" value="{{$tutorial->url_name}}" name="url_name">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" id="description" value="{{$tutorial->description}}" name="description">
    </div>
    <div class="form-group">
        <label for="keywords">Keywords</label>
        <input type="text" class="form-control" id="keywords" value="{{$tutorial->keywords}}" name="keywords">
    </div>



    <button type="submit" class="btn btn-primary">Edit Names</button>

    {{ method_field('PUT') }}
    {{csrf_field()}}
</form>

<h2 class="mb-4 mt-4 text-center">Questions:</h2>
<div class="swiper-container swiper-container-questions">
    <section class="opened-test mx-0 swiper-wrapper">
        <!-- Filled With Tests Questions only one of which is shown. -->
        @foreach($questions as $question)
            <div class="wrapper question-container swiper-slide mx-3 px-2">
                <div class="row questions-navigation mt-2 mx-2">
                    <div class="col p-2">
                        <p class="h4 text-center question-nav"
                            >Question {{ ($loop->index) + 1 }} of {{$questionsCount}}
                        </p>
                    </div>
                </div>
            
                <div class="row question-row mt-3 mx-2">
                    <div class="col">
                        <p class="h3 p-2 question-text text-center">
                            {{$question->text ?? "What's the result of the code snippet?"}}</p>
                    </div>
                </div>
            
                <div class="row code-area mx-2">
                    <textarea class="question-code-fragment">{{$question->code}}</textarea>
                </div>
            
                <div class="answers-listing row mx-2">
                    @foreach($question->all_answers as $answer)
                        <div class="answer col-12 d-flex justify-content-center align-items-center px-0"
                        @if($answer === $question->correct_answer) style="background: greenyellow"@endif>
                            <p class="my-0 px-2 py-1">{{$answer}}</p>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <button class="text-white ml-2 edit-question-btn px-3 mr-2"
                        data-toggle="modal" data-target="#edit-question-form-{{$question->id}}"> 
                            Edit
                    </button>
                    <div>
                        <form method="POST" action="{{ route('admin.question.destroy', compact('question')) }}"
                         data-text="You're going to delete the question."
                        data-response-text="Question deleted successfully.">
                            <button class="d-flex px-3 py-2 text-white mr-2 delete-question-btn px-3 ajax-confirm-btn">
                                Delete
                            </button>
                            {{ method_field('DELETE') }}
                            {{csrf_field()}}
                        </form>
                    </div>
                    <button class="btn explanation-btn d-inline-block text-white px-3 mr-2"
                    data-toggle="modal" data-target="#explanation-{{$question->id}}">
                        Explanation
                    </button>
                </div>
            </div>
        @endforeach
        <div class="wrapper"></div>
    </section>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>


<h2 class="mb-2 mt-4 text-center">Puzzles:</h2>
<div class="swiper-container swiper-container-puzzles">
    <section class="opened-puzzle mx-2 mt-2 mb-4 puzzles-listing swiper-wrapper" style="">
        @foreach($puzzles as $puzzle)
            <div class="wrapper puzzle-container swiper-slide mx-2 px-2">
                <div class="p-3 text-center title text-white h5 mb-4 mt-2 mx-2">{{$puzzle->text ?? 'Fill the missing words.'}}</div>
            <textarea class="mt-4 text-white puzzle-code">{{$puzzle->code}}</textarea>
            
                <div class="card shadow mt-4 mx-2">
                    <div class="card-header text-white" data-toggle="collapse" data-target="#puzzle-output-{{$puzzle->fake_id}}" aria-expanded="true">
                        <h2 class="text-left h4 mb-0">
                            <i class="fas fa-angle-up mr-3 rotate-180"></i>
                            <span class="category-name text-white">Output</span>
                        </h2>
                    </div>
                    <div class="card-body border-0 collapse show p-0" id="puzzle-output-{{$puzzle->fake_id}}">
                    <textarea class="puzzle-output">{{$puzzle->output}}</textarea>
                    </div>
                </div>
                <div class="p-3 words-to-fill-container mx-2">
                    @foreach (array_keys($puzzlesWordsCategories) as $category)
                        @if(count($puzzle->$category) > 0)
                            <div class="category-block mb-2">
                                @foreach($puzzle->$category as $word)
                                    <div class="word d-inline-block">{{$word}}</div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="row mx-2 mt-3">
                    <div class="col-6 pl-0 pr-2">
                        <button class="btn w-100 undo-btn text-white">
                            <i class="fas fa-undo-alt mr-2"></i> Undo
                        </button>
                    </div>
                    <div class="col-6 pl-2 pr-0">
                        <button class="btn w-100 redo-btn text-white">
                            <i class="fas fa-redo-alt mr-2"></i> Redo
                        </button>
                    </div>
                    <div class="col-6 mt-2 pl-0 pr-2 mt-3 mb-2">
                        <button class="btn w-100 send-btn text-white">Send</button>
                    </div>
                    <div class="col-6 mt-2 pl-2 pr-0 mt-3 mb-2">
                        <button class="btn w-100 reset-btn text-white">Reset</button>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <button class="text-white ml-2 edit-puzzle-btn px-3 border-0"
                        data-toggle="modal" data-target="#edit-puzzle-form-{{$puzzle->id}}"> 
                            Edit Puzzle
                    </button>
                    <div>
                        <form method="POST" action="{{ route('admin.puzzle.destroy', compact('puzzle')) }}"
                         data-text="You're going to delete the puzzle."
                        data-response-text="Puzzle deleted successfully.">
                            <button class="d-flex px-0 py-2 text-white mr-2 delete-puzzle-btn px-3 ajax-confirm-btn border-0">
                                Delete Puzzle
                            </button>
                            {{ method_field('DELETE') }}
                            {{csrf_field()}}
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
        
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<!-- Modals -->
@include('tutorial.partials.questions-form', [
    'puzzlesWordsCategories' => $puzzlesWordsCategories,
    'id' => 'create-question-modal',
    'title' => 'Create Question',
    'formUrl' => route('admin.question.store', compact('tutorial')),
    'isEdit' => false,
])

@foreach($questions as $question)
    @include('tutorial.partials.questions-form', [
        'id' => 'edit-question-form-' . $question->id,
        'title' => 'Edit Question',
        'formUrl' => route('admin.question.update', compact('question')),
        'text' => $question->text,
        'code' => $question->code,
        'answers' => $question->all_answers,
        'correctAnswer' => $question->correct_answer,
        'explanation' => $question->explanation,
        'isEdit' => true
    ])

<div class="modal fade questions-form-modal" id="explanation-{{$question->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h2 class="swal2-title text-center" id="swal2-title">Explanation</h2>
                <div class="mx-auto explanation-content">
                    {!!$question->explanation!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@include('tutorial.partials.puzzle-form', [
    'id' => 'create-puzzle-modal',
    'title' => 'Create Puzzle',
    'formUrl' => route('admin.puzzle.store', compact('tutorial')),
    'isEdit' => false
])

@foreach($puzzles as $puzzle)
    @include('tutorial.partials.puzzle-form', [
        'id' => 'edit-puzzle-form-' . $puzzle->id,
        'title' => 'Edit Puzzle',
        'formUrl' => route('admin.puzzle.update', compact('puzzle')),
        'isEdit' => true,
        'text' => $puzzle->text,
        'code' => $puzzle->code,
        'output' => $puzzle->output,
        'missingWords' => [
            'operators' => $puzzle->operators,
            'values' => $puzzle->values,
            'variables_constants' => $puzzle->variables_constants,
            'others' => $puzzle->others,
        ],
        'correctPatterns' => $puzzle->correct_patterns,
        'explanation' => $puzzle->explanation
    ])
@endforeach
<!-- /Modals -->
@endsection

@section('js-vars')
    var fromPHP = {
        techEntity: @json($techEntity),
        puzzles: @json($puzzles)
    };
@endsection
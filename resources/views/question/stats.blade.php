@extends('layouts.app')

@section('title', '答題狀況')

@section('content')
    <h1>答題狀況</h1>
    @foreach($questions as $question)
        <div class="card card-outline-primary">
            <h3 class="card-header">
                #{{ $question->order }}
                <span class="float-sm-right">
                    作答人數：{{ $questionAnswerRecordCount[$question->id] or 0}}
                </span>
            </h3>
            <div class="card-block">
                {{ $question->content }}
            </div>
            <div class="card-block">
                @foreach($question->choices as $choice)
                    <div class="row">
                        <div class="col-sm-6">{{ $choice->content }}</div>
                        <div class="col-sm-1">{{ $choiceAnswerRecordCount[$choice->id] or 0 }}</div>
                        <div class="col-sm-5">
                            <progress class="progress progress-info"
                                      value="{{ $choiceAnswerRecordCount[$choice->id] or 0 }}"
                                      max="{{ $questionAnswerRecordCount[$question->id] or 0}}">
                            </progress>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection

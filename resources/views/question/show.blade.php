@extends('layouts.app')

@section('title', '檢視問題')

@section('content')
    <h1>檢視問題</h1>
    <question api="{{ route('question.index') }}" choice_api="{{ route('choice.index') }}" question_id="{{ $question->id }}"></question>
    <div class="text-xs-center">
        <a href="{{ route('question.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>返回
        </a>
    </div>
@endsection

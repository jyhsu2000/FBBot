@extends('layouts.app')

@section('title', '檢視問題')

@section('content')
    <h1>檢視問題</h1>
    <question api="{{ route('question.index') }}"
              choice_api="{{ route('choice.index') }}"
              question_id="{{ $question->id }}"></question>
    <div class="text-xs-center">
        <a href="{{ route('question.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
        </a>
        {!! Form::open(['route' => ['question.destroy', $question], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除此題目嗎？');"]) !!}
        <button type="submit" class="btn btn-danger">
            <i class="fa fa-times" aria-hidden="true"></i> 刪除
        </button>
        {!! Form::close() !!}
    </div>
@endsection

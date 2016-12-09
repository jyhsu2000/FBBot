@extends('layouts.app')

@section('title', '題目管理')

@section('content')
    <h1>題目管理</h1>
    <div>
        <form action="{{ route('question.store') }}" method="post">
            {{ Form::token() }}
            <input type="submit" value="新增題目" class="btn btn-primary"/>
        </form>
    </div>
    <question-list api="{{ route('question.index') }}"></question-list>
@endsection

@extends('layouts.app')

@section('title', '問題管理')

@section('content')
    <h1>問題管理</h1>
    <div>
        <form action="{{ route('question.store') }}" method="post">
            {{ Form::token() }}
            <input type="submit" value="新增問題" class="btn btn-primary"/>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Order</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>{{ $question->order }}</td>
                    <td>
                        {{ $question->content }}<br/>
                        <ul>
                            @foreach($question->choices as $choice)
                                @if($choice->is_correct)
                                    <li class="text-primary">{{ $choice->content }}</li>
                                @else
                                    <li>{{ $choice->content }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('question.show', $question) }}" class="btn btn-primary">
                            <i class="fa fa-search" aria-hidden="true"></i> 檢視/編輯
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('title', '自動回覆')

@section('content')
    <h1>自動回覆</h1>
    <auto-reply-panel api="{{ route('autoReply.index') }}"></auto-reply-panel>
@endsection

@section('js')
@endsection

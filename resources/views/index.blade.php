@extends('layouts.app')

@section('title', '首頁')

@section('css')
    <style>
        .jumbotron {
            text-align: center;
            word-break: break-all;
            background: rgba(100, 100, 100, .6);
            margin-top: 10vh;
            padding-top: 40px;
            border-radius: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="jumbotron">
        <h1 class="display-1">{{ config('app.name') }}</h1>
        <h2 class="display-3">資訊安全宣導週</h2>
        <h3 class="display-4">資安大挑戰</h3>
        <a href="http://m.me/fcu.test" class="btn btn-primary btn-lg" style="margin-top: 30px;"
           title="Let's GO!!">GO!</a><br/>
        ↑按下按鈕開始挑戰↑
        <div>
            <img src="{{ asset('img/tutorial.png') }}" alt="簡易說明" class="img-thumbnail">
        </div>
    </div>
@endsection

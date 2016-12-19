@extends('layouts.app')

@section('title', '首頁')

@section('css')
    <style>
        .jumbotron {
            word-break: break-all;
            background: rgba(131, 131, 131, 0.6);
            border-radius: 20px;
            min-height: 80vh;
        }
    </style>
@endsection
@section('content')
    <div class="jumbotron" style="padding-top: 15vh;">
        <div class="float-lg-left" style="margin-bottom: 5vh;">
            <h1 class="display-3">資訊安全宣導週</h1>
            <h1 class="display-4">資安大挑戰</h1>
            <div style="margin-top: 30px;">
                <a href="http://m.me/fcu.test" class="btn btn-primary btn-lg" title="Let's GO!!"
                   style="font-size: 2.5rem;">GO!</a>
                <span style="font-size: 2rem;" class="align-middle"><i class="fa fa-arrow-left" aria-hidden="true"></i>開始挑戰</span>
            </div>
        </div>
        <div class="text-xs-center">
            <img src="{{ asset('img/tutorial.png') }}" alt="簡易說明" class="img-thumbnail float-lg-right">
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', '玩家管理')

@section('content')
    <h1>玩家管理</h1>
    {{-- TODO: 改用DataTable --}}
    <div class="table-responsive">
        <table class="table table-bordered table-strip table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>NID</th>
                <th>App UID</th>
                <th>UID</th>
                <th>In Question</th>
                <th>Times</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($players as $player)
                <tr>
                    <td>{{ $player->id }}</td>
                    <td>{{ $player->nid }}</td>
                    <td>{{ $player->app_uid }}</td>
                    <td>{{ $player->uid }}</td>
                    <td>{{ $player->in_question }}</td>
                    <td>{{ $player->time }}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('title', '玩家資訊')

@section('content')
    <div class="card">
        <div class="card-header">
            玩家資訊
        </div>
        <div class="card-block" style="font-size: 1.5em">
            <div class="row">
                <div class="col-sm-2 text-sm-right"><span class="tag tag-primary">分享用網址</span></div>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="text" class="form-control" id="url"
                               value="{{ route('player.showByUuid', $player->uuid) }}" readonly/>
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" data-clipboard-target="#url" id="copyBtn">
                                <i class="fa fa-clipboard" aria-hidden="true"></i> Copy
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 text-sm-right"><span class="tag tag-primary">NID</span></div>
                <div class="col-sm-10">
                    @if($player->nid)
                        {{ substr_replace($player->nid, '▒', -1) }}
                    @else
                        尚未綁定
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 text-sm-right"><span class="tag tag-primary">完成次數</span></div>
                <div class="col-sm-10">{{ $player->time }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2 text-sm-right"><span class="tag tag-primary">抽獎</span></div>
                <div class="col-sm-10">
                    {{-- 抽獎資格判定 --}}
                    @if($player->qualification && $player->qualification->get_at)
                        <span class="text-primary">已抽獎 （{{ $player->qualification->get_at }}）</span>
                    @elseif($player->qualification)
                        @if($player->nid)
                            <span class="text-success">已取得抽獎資格，請至攤位參加抽獎</span>
                        @else
                            <span class="text-warning">已取得抽獎資格，完成NID綁定後即可抽獎</span>
                        @endif
                    @else
                        <span class="text-danger">未取得抽獎資格</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            挑戰記錄
        </div>
        @if(count($times)==0)
            <div class="card-block">
                無挑戰記錄
            </div>
        @else
            <div class="card-block">
                @foreach($times as $time)
                    <a href="{{ route('player.showByUuid', [$player->uuid, 't' => $time]) }}"
                       class="btn btn-secondary @if($time == $chooseTime) disabled @endif">
                        <i class="fa fa-list-ol" aria-hidden="true"></i> 第{{ $time+1 }}次
                    </a>
                @endforeach
            </div>
            <div class="card-block">
                答對題數：{{ $count['correct'] }}/{{ $count['total'] }}（{{ $count['percent'] }}%）
            </div>
        @endif
    </div>
    @foreach($answerRecords as $answerRecord)
        <div class="card card-outline-secondary">
            <div class="card-block">
                <span class="tag tag-primary">#{{ $answerRecord->choice->question->order }}</span>
                {{ $answerRecord->choice->question->content }}
                <br/>
                <br/>
                <ul class="list-group">
                    @foreach($answerRecord->choice->question->choices as $choice)
                        <li class="list-group-item
                        @if($answerRecord->choice->id == $choice->id)
                        @if($choice->is_correct)
                            list-group-item-success
                            @else
                            list-group-item-danger
                        @endif
                        @endif
                            ">
                            @if($choice->is_correct)
                                <i class="fa fa-check float-xs-right text-success" aria-hidden="true"></i>
                            @endif
                            {{ $choice->content }}
                        </li>
                    @endforeach
                </ul>
                <br/>
                @if($answerRecord->is_correct)
                    @if($answerRecord->choice->question->correct_message)
                        <blockquote class="blockquote">
                            {!! nl2br(htmlspecialchars($answerRecord->choice->question->correct_message)) !!}
                        </blockquote>
                    @endif
                @else
                    @if($answerRecord->choice->question->wrong_message)
                        <blockquote class="blockquote">
                            {!! nl2br(htmlspecialchars($answerRecord->choice->question->wrong_message)) !!}
                        </blockquote>
                    @endif
                @endif

            </div>
        </div>
    @endforeach
@endsection

@section('js')
    <script>
        $(function () {
            new Clipboard('#copyBtn');
        });
    </script>
@endsection

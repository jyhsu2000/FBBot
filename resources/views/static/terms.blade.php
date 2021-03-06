@extends('layouts.app')

@section('title', '服務條款')

@section('content')
    <div class="card">
        <div class="card-header">
            服務條款
        </div>
        <div class="card-block">
            <p>感謝您參加我們舉辦的系列活動（以下簡稱「活動」），「活動」是由逢甲大學資訊處、逢甲大學黑客社、逢甲大學資訊安全策進會共同舉辦。</p>
            <p>只要您參加了「活動」，即表示您同意本條款，故請詳閱本條款內容。</p>
            <h3>參加「活動」</h3>
            <p>您必須遵守「活動」中要求你的所有事項。</p>
            <p>
                請勿嘗試以任何方式破壞「活動」的進行，其包括攻擊「活動」伺服器、嘗試不合法的連結等等，您不得使用我們提供以外的介面或操作方法存取「活動」網站，如果你未遵守我們的條款或規定，我們可能會暫停或取消您參加「活動」資格。</p>
            <p>參加「活動」玩遊戲並不會將「活動」中所存取任何內容的智慧財產權授予給您。除非相關單位及原作者同意或法律允許，否則您不得使用「活動」中的內容。</p>
            <p>本條款並未授權您使用任何「活動」中出現的Logo，請勿移除、遮蓋或變造「活動」所顯示或隨附顯示的物件或標示。</p>
            <h3>對「活動」的責任</h3>
            <p>我們尊重每位玩家參與「活動」的權利，但若有任何因不可抗拒因素或外力干擾而造成的損失，我們恕不進行任何補償。</p>
            <p>我們非常重視每位玩家的隱私權，我們絕不任意散播參加者的資料，詳細請參考我們的{{ link_to_route('privacy', '隱私權政策') }}。
            </p>
            <h3>關於本條款</h3>
            <p>本條款可能隨時根據「活動」辦法或法律修改而有所異動，若有修改，我們會及時在本頁修正且公告。</p>
            <p>本條款之異動經公告後即刻生效，若您不同意這個異動，請您停止參加「活動」。</p>
        </div>
    </div>
@endsection

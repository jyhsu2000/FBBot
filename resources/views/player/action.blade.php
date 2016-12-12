<a href="{{ route('player.showByUuid', $uuid) }}" class="btn btn-primary" title="玩家資訊" target="_blank">
    <i class="fa fa-user" aria-hidden="true"></i>
</a>
@if ($nid)
    <form action="{{ route('player.unbind', $id) }}" method="POST" onsubmit="return confirm('確定解除NID綁定？')"
          style="display: inline">
        <input type="hidden" name="_token" id="csrf-token" value="' . csrf_token() . '"/>
        <button type="submit" class="btn btn-danger" title="解除NID綁定">
            <i class="fa fa-chain-broken" aria-hidden="true"></i>
        </button>
    </form>
@endif

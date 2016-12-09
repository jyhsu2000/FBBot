<?php

namespace App\Http\Controllers;

use App\Player;
use App\Services\LogService;
use Illuminate\Http\Request;
use App\DataTables\PlayersDataTable;

class PlayerController extends Controller
{
    protected $logService;

    /**
     * Create the event listener.
     * @param LogService $logService
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PlayersDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(PlayersDataTable $dataTable)
    {
        return $dataTable->render('player.index');
    }

    public function unbind(Request $request, Player $player)
    {
        if (!$player->nid) {
            return back()->with('warning', '未綁定NID');
        }
        //寫入紀錄
        $user = auth()->user();
        $this->logService->info('[Player][Unbind] ' . $player->app_uid . ' 綁定之 ' . $player->nid . ' 已被解除' . PHP_EOL, [
            'player' => $player,
            'user'   => [
                'id'    => $user->id,
                'email' => $user->email,
                'name'  => $user->name,
            ],
            'ip'     => $request->getClientIp(),
        ]);
        //解除NID綁定
        $player->update([
            'nid' => null,
        ]);

        return back()->with('global', 'NID綁定已解除');
    }
}

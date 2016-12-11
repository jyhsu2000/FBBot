<?php

namespace App\Http\Controllers;

use Route;
use App\Choice;
use App\Player;
use App\Question;
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

    public function showByUuid(Request $request, $uuid)
    {
        $player = Player::where('uuid', $uuid)->first();
        if (!$player) {
            abort(404);
        }
        //第幾次挑戰的清單
        $times = array_unique($player->answerRecords->pluck('time')->toArray());
        sort($times);
        $answerRecords = [];
        if (count($times) <= 0) {
            //無挑戰記錄
            if ($request->has('t')) {
                //直接清除t參數
                return redirect()->route(Route::getCurrentRoute()->getName(), $player->uuid);
            }
        } else {
            //選擇的挑戰次數
            $chooseTime = $request->get('t', min($times));
            //若選擇無效
            if (!in_array($chooseTime, $times)) {
                //清除t參數
                return redirect()->route(Route::getCurrentRoute()->getName(), $player->uuid);
            }
            //該次挑戰的所有作答記錄
            $answerRecords = $player->answerRecords()->where('time', $chooseTime)->get();
            $answerRecords->load('choice.question.choices');
        }

        return view('player.show', compact(['player', 'times', 'chooseTime', 'answerRecords']));
    }
}

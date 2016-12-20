<?php

namespace App\Http\Controllers;

use App\Player;
use Carbon\Carbon;
use App\Qualification;
use Illuminate\Http\Request;
use App\DataTables\QualificationsDataTable;

class QualificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param QualificationsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(QualificationsDataTable $dataTable)
    {
        return $dataTable->render('qualification.index');
    }

    public function panel()
    {
        return view('qualification.panel');
    }

    public function find(Request $request)
    {
        //取得NID
        $nidInput = $request->get('nid');
        $nidInput = strtoupper($nidInput);
        if (!$nidInput && $nidInput !== '0') {
            return response()->json(['player' => null]);
        }
        $nid = $nidInput;
        //檢查是否多一位
        if (strlen($nid) == 9 || strlen($nid) == 7) {
            $nid = substr($nid, 0, -1);
        }
        //嘗試尋找玩家
        $player = Player::where('nid', $nidInput)->first() ?: Player::where('nid', $nid)->first();
        if (!$player) {
            return response()->json(['nid' => $nid, 'player' => null]);
        }
        $json = [
            'nid'    => $nid,
            'player' => [
                'nid'           => $player->nid,
                'qualification' => $player->qualification,
            ],
        ];

        //回傳結果
        return response()->json($json);
    }

    public function grant(Request $request)
    {
        //取得NID
        $nid = $request->get('nid');
        //嘗試尋找玩家
        $player = Player::where('nid', $nid)->first();
        if (!$player || !$player->qualification) {
            return response()->json([
                'success'      => false,
                'errorMessage' => '無抽獎資格',
            ]);
        }
        if ($player->qualification->get_at) {
            return response()->json([
                'success'      => false,
                'errorMessage' => '重複抽獎（' . $player->qualification->get_at . '）',
            ]);
        }
        $player->qualification->update(['get_at' => Carbon::now()]);

        return response()->json([
            'success' => true,
            'player'  => [
                'nid'           => $player->nid,
                'qualification' => $player->qualification,
            ],
        ]);
    }

    public function forceGrant(Request $request)
    {
        //取得NID
        $nid = $request->get('nid');
        //嘗試尋找玩家
        $player = Player::where('nid', $nid)->first();
        if (!$player) {
            //TODO 強制新增玩家
            return response()->json([
                'success'      => false,
                'errorMessage' => '無抽獎資格',
            ]);
        }
        if (!$player->qualification) {
            //TODO 強制新增抽獎資格
            return response()->json([
                'success'      => false,
                'errorMessage' => '無抽獎資格',
            ]);
        }
        if ($player->qualification->get_at) {
            return response()->json([
                'success'      => false,
                'errorMessage' => '重複抽獎（' . $player->qualification->get_at . '）',
            ]);
        }
        $player->qualification->update(['get_at' => Carbon::now()]);

        return response()->json([
            'success' => true,
            'player'  => [
                'nid'           => $player->nid,
                'qualification' => $player->qualification,
            ],
        ]);
    }
}

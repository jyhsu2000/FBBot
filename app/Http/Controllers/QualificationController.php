<?php

namespace App\Http\Controllers;

use App\Player;
use Carbon\Carbon;
use App\Qualification;
use Illuminate\Http\Request;
use App\DataTables\QualificationDataTable;

class QualificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param QualificationDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(QualificationDataTable $dataTable)
    {
        return $dataTable->render('qualification.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //TODO
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO
    }

    /**
     * Display the specified resource.
     *
     * @param Qualification $qualification
     * @return \Illuminate\Http\Response
     */
    public function show(Qualification $qualification)
    {
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Qualification $qualification
     * @return \Illuminate\Http\Response
     */
    public function edit(Qualification $qualification)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Qualification $qualification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qualification $qualification)
    {
        //TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Qualification $qualification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qualification $qualification)
    {
        //TODO
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
        if (!$nidInput) {
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
        ]);
    }
}

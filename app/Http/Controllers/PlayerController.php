<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Http\Request;
use App\DataTables\PlayersDataTable;

class PlayerController extends Controller
{
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
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player $player)
    {
        //TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        //TODO
    }
}

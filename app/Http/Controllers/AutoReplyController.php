<?php

namespace App\Http\Controllers;

use App\AutoReply;
use Illuminate\Http\Request;

class AutoReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auto-reply.index');
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
     * @param AutoReply $autoReply
     * @return \Illuminate\Http\Response
     */
    public function show(AutoReply $autoReply)
    {
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AutoReply $autoReply
     * @return \Illuminate\Http\Response
     */
    public function edit(AutoReply $autoReply)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param AutoReply $autoReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AutoReply $autoReply)
    {
        //TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AutoReply $autoReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(AutoReply $autoReply)
    {
        //TODO
    }
}

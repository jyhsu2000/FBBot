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
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ]);
        }
        //新增語錄
        $autoReply = AutoReply::create([
            'name'  => $request->get('name'),
            'order' => AutoReply::max('order') + 1,
        ]);
        //重新讀取
        $autoReply = $autoReply->fresh();
        $autoReply->load('keywords', 'autoReplyMessages');
        //回傳結果
        $json = [
            'success'   => true,
            'autoReply' => $autoReply->toArray(),
        ];

        return response()->json($json);
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ]);
        }
        //新增語錄
        $autoReply->update([
            'name' => $request->get('name'),
        ]);
        //回傳結果
        $json = [
            'success'   => true,
            'autoReply' => $autoReply->toArray(),
        ];

        return response()->json($json);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AutoReply $autoReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(AutoReply $autoReply)
    {
        $autoReply->delete();

        return response()->json(['success' => true]);
    }

    public function data()
    {
        $autoReply = AutoReply::with('keywords', 'autoReplyMessages')->orderBy('order')->orderBy('id')->get();

        return response()->json($autoReply);
    }

    public function sort(Request $request)
    {
        $idList = $request->get('idList');
        $counter = 1;
        foreach ($idList as $id) {
            $autoReply = AutoReply::find($id);
            if (!$autoReply) {
                continue;
            }
            $autoReply->update([
                'order' => $counter,
            ]);
            $counter++;
        }
        //回傳結果
        $json = [
            'success' => true,
            'idList'  => $idList,
        ];

        return response()->json($json);
    }
}

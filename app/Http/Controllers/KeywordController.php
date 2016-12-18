<?php

namespace App\Http\Controllers;

use App\Keyword;
use Illuminate\Http\Request;
use App\DataTables\KeywordsDataTable;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO
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
            'auto_reply_id' => 'required|exists:auto_replies,id',
            'keyword'       => 'required|unique:keywords|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ]);
        }
        //新增語錄
        $keyword = Keyword::create([
            'auto_reply_id' => $request->get('auto_reply_id'),
            'keyword'       => $request->get('keyword'),
        ]);
        //重新取得（避免無法取得counter欄位）
        $keyword = $keyword->fresh();
        //回傳結果
        $json = [
            'success' => true,
            'keyword' => $keyword->toArray(),
        ];

        return response()->json($json);
    }

    /**
     * Display the specified resource.
     *
     * @param Keyword $keyword
     * @return \Illuminate\Http\Response
     */
    public function show(Keyword $keyword)
    {
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Keyword $keyword
     * @return \Illuminate\Http\Response
     */
    public function edit(Keyword $keyword)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Keyword $keyword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Keyword $keyword)
    {
        //TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Keyword $keyword
     * @return \Illuminate\Http\Response
     */
    public function destroy(Keyword $keyword)
    {
        $keyword->delete();

        return response()->json(['success' => true]);
    }
}

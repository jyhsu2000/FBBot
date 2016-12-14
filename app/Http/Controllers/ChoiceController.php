<?php

namespace App\Http\Controllers;

use App\Choice;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //僅為了讓Vue傳遞網址而存在路由，非實際方法
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Choice $choice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Choice $choice)
    {
        $validator = \Validator::make($request->all(), [
            'content' => 'required|max:17',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ]);
        }
        //更新題目
        $choice->update([
            'content' => $request->get('content'),
        ]);
        //回傳結果
        $json = [
            'success' => true,
            'content' => $choice->content,
        ];

        return response()->json($json);
    }

    public function toggleCorrect(Request $request, Choice $choice)
    {
        $choice->update([
            'is_correct' => !$choice->is_correct,
        ]);

        //回傳結果
        $json = [
            'success'    => true,
            'is_correct' => $choice->is_correct,
        ];

        return response()->json($json);
    }

    public function sort(Request $request)
    {
        $idList = $request->get('idList');
        $counter = 1;
        foreach ($idList as $id) {
            $choice = Choice::find($id);
            if (!$choice) {
                continue;
            }
            $choice->update([
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

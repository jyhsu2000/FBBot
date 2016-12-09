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
        //TODO
    }

    /**
     * Display the specified resource.
     *
     * @param Choice $choice
     * @return \Illuminate\Http\Response
     */
    public function show(Choice $choice)
    {
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Choice $choice
     * @return \Illuminate\Http\Response
     */
    public function edit(Choice $choice)
    {
        //TODO
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
            'content' => 'required|unique:quotations|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ]);
        }
        //更新問題
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

    /**
     * Remove the specified resource from storage.
     *
     * @param Choice $choice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Choice $choice)
    {
        //TODO
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
        $counter = 0;
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

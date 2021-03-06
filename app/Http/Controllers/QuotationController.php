<?php

namespace App\Http\Controllers;

use App\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('quotation.index');
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
            'content' => 'required|unique:quotations|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ]);
        }
        //新增語錄
        $quotation = Quotation::create([
            'content' => $request->get('content'),
            'order'   => Quotation::max('order') + 1,
        ]);
        //重新取得語錄（避免無法取得counter欄位）
        $quotation = $quotation->fresh();
        //回傳結果
        $json = [
            'success'   => true,
            'quotation' => $quotation->toArray(),
        ];

        return response()->json($json);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Quotation $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        //刪除
        $quotation->delete();

        return response()->json(['success' => true]);
    }

    public function data()
    {
        $quotations = Quotation::orderBy('order')->orderBy('id')->get();

        return response()->json($quotations);
    }
}

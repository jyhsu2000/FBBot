<?php

namespace App\Http\Controllers;

use App\AutoReplyMessage;
use Illuminate\Http\Request;

class AutoReplyMessageController extends Controller
{
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
            'content'       => 'required|max:320',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ]);
        }
        //新增語錄
        $autoReplyMessage = AutoReplyMessage::create([
            'auto_reply_id' => $request->get('auto_reply_id'),
            'content'       => $request->get('content'),
        ]);
        //重新取得（避免無法取得counter欄位）
        $autoReplyMessage = $autoReplyMessage->fresh();
        //回傳結果
        $json = [
            'success'          => true,
            'autoReplyMessage' => $autoReplyMessage->toArray(),
        ];

        return response()->json($json);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AutoReplyMessage $autoReplyMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(AutoReplyMessage $autoReplyMessage)
    {
        $autoReplyMessage->delete();

        return response()->json(['success' => true]);
    }
}

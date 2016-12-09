<?php

namespace App\Http\Controllers;

use App\Choice;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::orderBy('order')->orderBy('id')->get();

        return view('question.index', compact('questions'));
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
        $question = Question::create([
            'content' => '題目敘述',
            'order'   => Question::max('order') + 1,
        ]);
        $choices = [];
        for ($i = 1; $i <= 3; $i++) {
            $choices[] = new Choice(['order' => $i, 'content' => '選項' . $i]);
        }
        $question->choices()->saveMany($choices);

        return redirect()->route('question.show', $question)->with('global', '題目已新增');
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return view('question.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
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
        $question->update([
            'content' => $request->get('content'),
        ]);
        //回傳結果
        $json = [
            'success' => true,
            'content' => $question->content,
        ];

        return response()->json($json);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('question.index')->with('global', '題目已刪除');
    }

    public function get(Question $question)
    {
        $question->load('choices');

        return response()->json($question->toArray());
    }
}

<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function create()
    {
        return view('question.create');
    }

    public function createpost(Request $request)
    {
        $question = new Question();
        $question->title = $request->input('title');
        $question->answer_1 = $request->input('answer_1');
        $question->answer_2 = $request->input('answer_2');
        $question->answer_3 = $request->input('answer_3');
        $question->answer_good = $request->input('answer_good');
        $question->save();
        return redirect()->route('home');
    }

    public function edit(Question $question)
    {
        return view('question.create', compact('question'));
    }

    public function editpost(Question $question, Request $request)
    {
        $question->title = $request->input('title');
        $question->answer_1 = $request->input('answer_1');
        $question->answer_2 = $request->input('answer_2');
        $question->answer_3 = $request->input('answer_3');
        $question->answer_good = $request->input('answer_good');
        $question->save();
        return redirect()->route('home');
    }

    public function delete(Question $question)
    {
        $question->delete();
        return redirect()->route('home');
    }
}

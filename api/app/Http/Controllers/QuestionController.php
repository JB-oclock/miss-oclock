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

    public function list()
    {
        $questions = Question::orderBy('id', 'desc')->get();
        return view('question.list', compact('questions'));
    }

    public function createpost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'answer_1' => 'required',
            'answer_2' => 'required',
            'answer_3' => 'required',
            'answer_good' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $question = new Question();
        $question->title = $request->input('title');
        $question->answer_1 = $request->input('answer_1');
        $question->answer_2 = $request->input('answer_2');
        $question->answer_3 = $request->input('answer_3');
        $question->answer_good = $request->input('answer_good');

        if($request->has('image')){
            $path = $request->image->store('question_images', 'public');
            $question->image = $path;
        }

        $question->save();
        return redirect()->back();
    }

    public function edit(Question $question)
    {
        return view('question.create', compact('question'));
    }

    public function editpost(Question $question, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'answer_1' => 'required',
            'answer_2' => 'required',
            'answer_3' => 'required',
            'answer_good' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $question->title = $request->input('title');
        $question->answer_1 = $request->input('answer_1');
        $question->answer_2 = $request->input('answer_2');
        $question->answer_3 = $request->input('answer_3');
        $question->answer_good = $request->input('answer_good');

        if($request->has('image')){
            $path = $request->image->store('question_images', 'public');
            $question->image = $path;
        }

        $question->save();
        return redirect()->back();
    }

    public function delete(Question $question)
    {
        $question->games()->detach();
        $question->answers()->delete();
        $question->delete();
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function answerQuestion(Request $request) {

        $player = $request->get('player');
        $game = $request->get('game');
        $userAnswer = $request->get('answer');
        $question = $request->get('question');

        if(!$userAnswer || !$question) {
            $errors = [
                'errors' => [
                    0 => 'Vous devez choisir une réponse !',
                ]
            ];
            return response()->json($errors, 422);
        }

        $question = Question::find($question);

        $correct = ($userAnswer == $question->answer_good);

        $answer = new Answer;
        $answer->game()->associate($game);
        $answer->player()->associate($player);
        $answer->question()->associate($question);
        $answer->answer = $userAnswer;
        $answer->correct_answer = $correct;


        try {
            $answer->save();

        } catch (Exception $e) {
            $errors = [
                'errors' => [
                    0 => 'Vous avez déjà répondu à cette question !',
                ]
            ];
            return response()->json($errors, 422);
        }

    }
}

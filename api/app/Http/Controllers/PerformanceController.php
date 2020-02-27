<?php

namespace App\Http\Controllers;

use App\PerfVote;
use App\Performance;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function answerPerformance(Request $request)
    {
        $player = $request->get('player');
        $game = $request->get('game');
        $userAnswer = $request->get('answer');
        $performance = $request->get('performance');

        if(!$userAnswer || !$performance) {
            $errors = [
                'errors' => [
                    0 => 'Vous devez choisir une réponse !',
                ]
            ];
            return response()->json($errors, 422);
        }

        $performance = Performance::find($performance);

        $correct = ($userAnswer == $performance->answer_good);

        $answer = new PerfVote;
        $answer->game()->associate($game);
        $answer->player()->associate($player);
        $answer->performer()->associate($game->performance_player);
        $answer->performance()->associate($performance);
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

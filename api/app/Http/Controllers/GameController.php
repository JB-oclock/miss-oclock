<?php

namespace App\Http\Controllers;

use \App\Game;
use App\Answer;
use Idplus\Mercure\Publify;
use Illuminate\Http\Request;
use Symfony\Component\Mercure\Update;

class GameController extends Controller
{

    public function show(Game $game) {
        return view('game.show', compact('game'));
    }

    public function reset(Game $game) {
        $game->step = 0;
        $game->question = 0;
        $game->answers()->delete();
        $game->players()->delete();
        $game->save();

        return back();
    }


    public function nextStep (Game $game, Publify $publisher){
        $game->step = $game->step +1;
        $game->save();

        $data = ['step' => $game->step];
        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/steps/'.$game->id.'.jsonld',
            json_encode($data)
        );
        $publisher($update);

        return back();
    }


    public function nextQuestion (Request $request, Game $game, Publify $publisher){
        $nbQuestions = $game->questions->count();
        if($game->question < $nbQuestions) {
            $game->question = $game->question +1;
            $game->save();
            
            $question = $game->questionWithOrder($game->question);
            
            $data = ['questions' => $question->cleanData()];
            $update = new Update(
                env('MERCURE_DOMAIN') . 'missoclock/questions/'.$game->id.'.jsonld',
                json_encode($data)
            );
            $publisher($update);
        }

        return back();
    }

    public function gameData(Request $request) {
        $game = $request->get('game');
        $player = $request->get('player');

        $gameData = [
            'gameId' => $game->id,
            'gameStep' => $game->step
        ];

        if($game->step == 1 && $game->question != 0) {
            $question = $game->questionWithOrder($game->question);
            $gameData['question'] = $question->cleanData();

            // Check if the player has already answered this question
            $answer = Answer::where('game_id', $game->id)
                        ->where('player_id', $player->id)
                        ->where('question_id', $question->id)
                        ->first();
            
            $gameData['question']['answered'] = !!$answer;
        }


        return response()->json($gameData);
    }
}

<?php

namespace App\Http\Controllers;

use \App\Game;
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
        }

        $question = $game->questionWithOrder($game->question);

        $data = ['questions' => $question->cleanData()];
        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/questions/'.$game->id.'.jsonld',
            json_encode($data)
        );
        $publisher($update);

        return back();
    }

    public function gameData(Request $request) {
        $game = $request->get('game');

        $gameData = [
            'gameId' => $game->id,
            'gameStep' => $game->step
        ];

        if($game->step == 1 && $game->question != 0) {
            $question = $game->questionWithOrder($game->question);
            // TODO : ajouter la gestion de l'attribut answered
            $gameData['question'] = $question->cleanData();
        }


        return response()->json($gameData);
    }
}

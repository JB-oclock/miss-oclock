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
}

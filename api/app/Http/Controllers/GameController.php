<?php

namespace App\Http\Controllers;

use \App\Game;
use Idplus\Mercure\Publify;
use Illuminate\Http\Request;
use Symfony\Component\Mercure\Update;

class GameController extends Controller
{
    public function nextStep (Game $game, Publify $publiser){
        $game->step = $game->step +1;
        $game->save();

        $data = ['step' => $game->step];
        $update = new Update(
            env('MERCURE_DOMAIN') . '/missoclock/steps/'.$game->id.'.jsonld',
            json_encode($data)
        );
        $publiser($update);
    }
}

<?php

namespace App\Http\Controllers;

use App\Vote;
use App\Player;
use Idplus\Mercure\Publify;
use Illuminate\Http\Request;
use Symfony\Component\Mercure\Update;

class VoteController extends Controller
{
    public function sendVote(Request $request, Publify $publisher)
    {
        $player = $request->get('player');
        $game = $request->get('game');
        $userAnswer = $request->get('answer');

        if(!$userAnswer) {
            $errors = [
                'errors' => [
                    0 => 'Vous devez choisir une personne pour qui voter !',
                ]
            ];
            return response()->json($errors, 422);
        }

        $voted = Player::find($userAnswer);


        $vote = new Vote;
        $vote->game()->associate($game);
        $vote->player()->associate($player);
        $vote->vote()->associate($voted);


        try {
            $vote->save();
            $update = new Update(
                env('MERCURE_DOMAIN') . 'missoclock/game/'.$game->id.'/final.jsonld',
                json_encode([
                    'vote' => $voted->name
                ])
            );
            $publisher($update);

        } catch (\Exception $e) {
            $errors = [
                'errors' => [
                    0 => 'Vous avez déjà répondu à cette question !',
                ]
            ];
            return response()->json($errors, 422);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Vote;
use App\Player;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function sendVote(Request $request)
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

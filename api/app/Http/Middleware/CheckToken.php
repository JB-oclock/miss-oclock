<?php

namespace App\Http\Middleware;

use Closure;
use App\Game;
use App\Player;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $header = $request->header('Authorization');

        if(!$header) {
            return response(['Token not provided'], 403);
        }

        $token = decrypt(str_replace('Bearer ','',  $header));

        if(!$token['game'] || !$token['player']){
            return response(['Wrong token'], 403);
        }

        $game = Game::find($token['game']);
        $player = Player::find($token['player']);

        if (!$game || !$player) {
            return response(['The token contains wrong data'], 403);
        }

        $request->attributes->add([
            'game' => $game,
            'player' => $player,
        ]);

        return $next($request);
    }
}

<?php

namespace App;

use App\Game;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function games() {
        return $this->belongsToMany('App\Game')->withPivot('winner', 'winner2');
    }

    public function winnerStep1(Game $game) {
        return $this->games()->where('id', $game->id)->wherePivot('winner', 1)->first();
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function voted()
    {
        return $this->hasMany('App\Vote', 'voted_player_id');
    }

    
}

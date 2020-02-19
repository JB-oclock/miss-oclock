<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function players() {
        return $this->belongsToMany('App\Player')->withPivot('step', 'winner', 'question');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    public function questions()
    {
        return $this->belongsToMany('App\Question');
    }

    public function performances()
    {
        return $this->belongsToMany('App\Performance');
    }

    public function questionWithOrder($order) {
        return $this->questions()->wherePivot('order', $order)->first();
    }

    public function lastQuestion() {
        return $this->questions()->orderBy('order', 'desc')->first();
    }

    public function getPlayersWithScore() {
        $players = []; 
    
        foreach($this->answers as $answer) {
            $player = $answer->player;
            if(!array_key_exists($player->name, $players)) {
                $players[$player->name] = $answer->correct_answer;
            } else {
                $players[$player->name] += $answer->correct_answer;
            }
        }
        arsort($players);

        return $players;
    }
}

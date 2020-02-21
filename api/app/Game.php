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

    public function getCorrectAnswers() {
        return $this->answers()->with('player')->where('correct_answer', 1)->get();
    }

    public function getStep1Winners() {
        
        $answers  = $this->getCorrectAnswers();
        $players = [];

        foreach($answers as $answer ) {
            $player = $answer->player;
            if(!array_key_exists($player->id, $players)) {
                $players[$player->id]['player'] = $player;
                $players[$player->id]['score'] = 1;
            } else {
                $players[$player->id]['score'] += $answer->correct_answer;
            }
        }
        usort($players, function ($a, $b){
            return $b['score'] - $a['score'];
        });


        return array_slice($players, 0, $this->winners);
    }


    public function getPlayersWithScore() {
        $players = []; 
    
        foreach($this->getCorrectAnswers() as $answer) {
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

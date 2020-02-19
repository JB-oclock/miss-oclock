<?php

namespace App;

use App\Game;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function games()
    {
        return $this->belongsToMany('App\Game');
    }

    public function cleanData(Game $game = NULL) {
        if($game) {
            $last = !!($game->lastQuestion()->id == $this->id);
        }
        $answers = [
            $this->answer_1,
            $this->answer_2,
            $this->answer_3,
            $this->answer_good,
        ];
        shuffle($answers);
        
        return [
            'questionId' => $this->id,
            'question' => $this->title,
            'answered' => false,
            'answers' => $answers,
            'last' => $last,
        ];
    }
}

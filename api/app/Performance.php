<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    public function votes()
    {
        return $this->hasMany('App\PerfVote');
    }

    public function games()
    {
        return $this->belongsToMany('App\Game');
    }
    public function performerData()
    {
        return [
            'title' => $this->answer_good,
        ];
    }

    public function voterData(Game $game = NULL) {
        $last = ($game) ? $game->lastPerformance() : false;
        $answers = [
            $this->answer_1,
            $this->answer_2,
            $this->answer_3,
            $this->answer_good,
        ];
        shuffle($answers);
        
        return [
            'performanceId' => $this->id,
            'performance' => $this->title,
            'answered' => false,
            'answers' => $answers,
            'last' => $last,
        ];
    }
}

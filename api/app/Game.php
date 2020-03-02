<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function players() {
        return $this->belongsToMany('App\Player')->withPivot('winner', 'winner2');
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
    public function performanceScore($player) 
    {
        return $this->hasMany('App\PerfVote')->where('performer_id', $player->id)->get()->sum('correct_answer');
    }
    public function numberOfPerfs($player)
    {
       return $this->perfVotes()->where('performer_id', $player->id)->distinct('performance_id')->count();
    }
    public function perfVotes()
    {
        return $this->hasMany('App\PerfVote');
    }

    public function questionWithOrder($order) {
        return $this->questions()->wherePivot('order', $order)->first();
    }

    public function lastQuestion() {
        return $this->questions()->orderBy('order', 'desc')->first();
    }

    public function lastPerformance() {
        return ($this->performances()->wherePivot('done', '0')->count() == 0);
    }

    public function getCorrectAnswers() {
        return $this->answers()->with('player')->where('correct_answer', 1)->get();
    }

    public function getCorrectPerfAnswers() {
        return $this->perfVotes()->with('player')->where('correct_answer', 1)->get();
    }

    public function getStep1Winners()
    {
        return $this->players()->wherePivot('winner', 1)->get();
    }
    
    public function getStep2Winners()
    {
        return $this->players()->wherePivot('winner2', 1)->get();
    }

    public function getStep3Props()
    {
        $winners = $this->getStep2Winners();
        $props = [];

        foreach($winners as $winner) {
            $props[] = [
                'id' => $winner->id,
                'name' => $winner->name
            ];
        }

        return $props;
    }

    public function getStep3Scores()
    {
        $scores = [];
        $playerVotes = $this->votes()->with('vote')->groupBy('voted_player_id')->get();
        foreach($playerVotes as $playerVote) {
            $player = $playerVote->vote;
            $votes = $player->voted()->where('game_id', $this->id)->count();
            $scores[] = [
                'player' => $player,
                'score' => $votes
            ];
        }

        return $scores;
    }

    public function getFinalWinner()
    {
        $votes = $this->getStep3Scores();
        usort($votes, function ($a, $b){
            return $b['score'] - $a['score'];
        });

        return $votes[0]['player'];

    }
    
    public function findStep1Winners() {
        
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

    
    public function findStep2Winners() {
        
        $answers  = $this->getCorrectPerfAnswers();
        $players = [];

        foreach($answers as $answer ) {
            $player = $answer->performer;
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


        return array_slice($players, 0, 2);
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

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerfVote extends Model
{
    public function player()
    {
        return $this->belongsTo('App\Player');
    }

    public function performer()
    {
        return $this->belongsTo('App\Player', 'performer_id');
    }

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function performance()
    {
        return $this->belongsTo('App\Performance');
    }

}

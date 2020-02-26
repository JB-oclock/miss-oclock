<?php

namespace App\Http\Controllers;

use \App\Game;
use App\Answer;
use App\Player;
use App\Performance;
use Idplus\Mercure\Publify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mercure\Update;

class GameController extends Controller
{

    public function show(Game $game) {
        $players = [];
        $question = '';
        $stepOver = true;
        $gameQuestion = ($game->question == 0)? 1 : $game->question;
        if($game->step == 1) {
            $players = $game->getPlayersWithScore();
            $question = $game->questionWithOrder($gameQuestion);
            $question = $question->CleanData($game);
            $stepOver = !!count($game->getStep1Winners());
        } else if ($game->step == 2) {
            $players = $game->getStep1Winners();
            $stepOver = !!count($game->getStep2Winners());

        }
        return view('game.show', compact('game', 'players', 'question', 'stepOver'));
    }

    public function reset(Game $game) {
        $game->step = 0;
        $game->question = 0;
        $game->performance_sent = 0;
        $game->performance_props_sent = 0;
        $game->performance_player = 0;
        $game->answers()->delete();
        $game->players()->delete();
        $game->save();

        return back();
    }

    public function resetPerfs(Game $game) {
        $game->performance_sent = 0;
        $game->performance_props_sent = 0;
        $game->performance_player = 0;
        $perfs = $game->performances;

        foreach ($perfs as $perf) {
            $perf->games()->updateExistingPivot($game, ['done' => 0]);
        }
        $game->save();

        return back();
    }


    public function nextStep (Game $game, Publify $publisher){
        $game->step = $game->step +1;
        $game->save();

        $data = ['step' => $game->step];
        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/steps/'.$game->id.'.jsonld',
            json_encode($data)
        );
        $publisher($update);

        return back();
    }


    public function nextQuestion (Request $request, Game $game, Publify $publisher){
        $nbQuestions = $game->questions->count();
        if($game->question < $nbQuestions) {
            $game->question = $game->question +1;
            $game->save();
            
            $question = $game->questionWithOrder($game->question);
            
            $question = $question->cleanData($game);


            $data = ['questions' => $question];
            $update = new Update(
                env('MERCURE_DOMAIN') . 'missoclock/questions/'.$game->id.'.jsonld',
                json_encode($data)
            );
            $publisher($update);
        }

        return back();
    }

    public function setStep1Winners(Game $game,  Publify $publisher) {
        $players = $game->findStep1Winners();
        foreach ($players as $player) {
            $player = $player['player'];
            $player->games()->updateExistingPivot($game->id, ['winner' => 1]);
        }

        $winners = [];

        foreach($players as $player) {
            $winners[] = $player['player']->name;
        }

        $data = ['winners' => $winners];
        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/questions/'.$game->id.'.jsonld',
            json_encode($data)
        );
        $publisher($update);


        return back();

    }

    public function sendPerformance(Game $game, Player $player, Publify $publisher)
    {
        $performance = $game->performances()->orderBy(DB::raw('RAND()'))->where('done', 0)->first();
        $game->performances()->updateExistingPivot($performance->id, ['done' => 1]);
        $game->performance_sent = $performance->id;
        $game->performance_player = $player->id;
        $game->save();

        $data = ['performance' => $performance->performerData()];
        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/performances/'.$game->id.'/performer/'.$player->id.'.jsonld',
            json_encode($data)
        );
        $publisher($update);
        
        return back();

    }

    public function gameData(Request $request) {
        $game = $request->get('game');
        $player = $request->get('player');
        $step1Winner = !!$player->winnerStep1($game);

        $gameData = [
            'gameId' => $game->id,
            'gameStep' => $game->step,
            'step_1_winner' => $step1Winner,
        ];

        if($game->step == 1 && $game->question != 0) {
            $question = $game->questionWithOrder($game->question);
            $gameData['question'] = $question->cleanData($game);

            // Check if the player has already answered this question
            $answer = Answer::where('game_id', $game->id)
                        ->where('player_id', $player->id)
                        ->where('question_id', $question->id)
                        ->first();
            
            $gameData['question']['answered'] = !!$answer;

            // Check if the winners have been set up 
            $winners = $game->getStep1Winners();
            $gameData['question']['ended'] = !!$winners;
        } 
        if($game->step == 2) {
            if($step1Winner && $game->performance_player == $player->id && $game->performance_sent) {
                $performance = Performance::find($game->performance_sent);
                $gameData['performance'] = $performance->performerData();
            }
        }


        return response()->json($gameData);
    }
}

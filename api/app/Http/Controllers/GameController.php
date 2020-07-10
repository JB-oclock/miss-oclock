<?php

namespace App\Http\Controllers;

use App\Vote;
use \App\Game;
use App\Answer;
use App\Player;
use App\PerfVote;
use App\Question;
use App\Performance;
use Idplus\Mercure\Publify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mercure\Update;

class GameController extends Controller
{

    public function show(Game $game) {
        $players = $performersData = [];
        $question = '';
        $stepOver = true;
        $perfsOver = false;
        $gameQuestion = ($game->question == 0)? 1 : $game->question;
        if($game->step == 0 ) {
            $players = $game->players;
        }
        else if($game->step == 1) {
            $players = $game->getPlayersWithScore();
            $question = $game->questionWithOrder($gameQuestion);
            $question = $question->cleanData($game);
            $stepOver = !!count($game->getStep1Winners());
        } else if ($game->step == 2) {
            $players = $game->getStep1Winners();
            $stepOver = !!count($game->getStep2Winners());
            $perfsOver = ($game->lastPerformance() && !$game->performance_sent);
            foreach($players as $player) {
                $performersData[$player->id]['score'] = $game->performanceScore($player);
                $performersData[$player->id]['nb_perfs'] = $game->numberOfPerfs($player);
            }
      
        } else if ($game->step == 3) {
            $players = $game->getStep3Scores();
            
        }
        
        return view('game.show', compact('game', 'players', 'question', 'stepOver', 'perfsOver', 'performersData'));
    }

    public function reset(Game $game) {
        $game->step = 0;
        $game->question = 0;
        $this->resetPerfs($game);
        $game->votes_started = 0;
        $game->winner = null;
        $game->answers()->delete();
        $game->perfVotes()->delete();
        $game->votes()->delete();
        $game->players()->delete();
        $game->save();

        return back();
    }

    public function resetPerfs(Game $game) {
        $game->performance_sent = 0;
        $game->performance_props_sent = 0;
        $game->performance_player = 0;
        $perfs = $game->performances;
        $game->perfVotes()->delete();

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

    public function displayAnswer(Game $game, Question $question,  Publify $publisher)
    {
        $data = ['endQuestion' => true];
        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/questions/'.$game->id.'.jsonld',
            json_encode($data)
        );
        $publisher($update);


        $data = ['answer' => $question->answer_good];
        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/answers/'.$game->id.'.jsonld',
            json_encode($data)
        );
        $publisher($update);

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

    public function setStep2Winners(Game $game,  Publify $publisher) {
        $winners = $game->findStep2Winners();
        $players = $game->getStep1Winners();
        $winnerIds = $winnerNames = [];
        foreach ($winners as $player) {
            $player = $player['player'];
            $player->games()->updateExistingPivot($game->id, ['winner2' => 1]);
            $winnerIds[] = $player->id;
            $winnerNames[] = $player->name;
        }
        foreach($players as $player) {
            $winner = in_array($player->id, $winnerIds);
            $data = ['winner' => $winner];
            $update = new Update(
                env('MERCURE_DOMAIN') . 'missoclock/performances/'.$game->id.'/performer/'.$player->id.'.jsonld',
                json_encode($data)
            );
            $publisher($update);
            
        }

        $data = [
            'ended' => true,
            'winners' => $winnerNames
        ];
        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/performances/'.$game->id.'/props.jsonld',
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

    public function sendPerformanceProps(Game $game, Publify $publisher)
    {
        $performance = Performance::find($game->performance_sent);
        $game->performance_props_sent = true;
        $game->save();

        $data = ['performance' => $performance->voterData()];
        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/performances/'.$game->id.'/props.jsonld',
            json_encode($data)
        );
        $publisher($update);
        
        return back();

    }

    public function validatePerformance(Game $game, Publify $publisher)
    {
       

       $data = [
           'performance' => [
               'title' => '',
               'answered' => true,
           ]
        ];
        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/performances/'.$game->id.'/props.jsonld',
            json_encode($data)
        );
        $publisher($update);

        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/performances/'.$game->id.'/performer/'. $game->performance_player .'.jsonld',
            json_encode($data)
        );
        $publisher($update);
        

        $game->performance_sent = 0;
        $game->performance_props_sent = 0;
        $game->performance_player = 0;
        $game->save();

        return back();
    }

    public function sendVotes(Game $game, Publify $publisher)
    {
        $game->votes_started = true;
        $game->save();

        $answers = $game->getStep3Props();

        $data = [
            'votes' => [
                'started' => true,
                'answers' => $answers,
            ]
        ];
        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/votes/'.$game->id.'.jsonld',
            json_encode($data)
        );
        $publisher($update);

        return back();
    }

    public function validateVotes(Game $game, Publify $publisher)
    {
        $winner = $game->findFinalWinner();
        $game->winner = $winner->id;
        $game->save();

        $data = [
            'winner' => $winner->name,
        ];
        $update = new Update(
            env('MERCURE_DOMAIN') . 'missoclock/votes/'.$game->id.'.jsonld',
            json_encode($data)
        );
        $publisher($update);
        

        return back();
    }

    /**
     * Get game data for a player
     *
     * @param Request $request
     * @return json
     */
    public function gameDataPlayer(Request $request) {
        $game = $request->get('game');
        $player = $request->get('player');
        
        $gameData = $this->gameData($game, $player);

        return response()->json($gameData);
    }

    /**
     * Get game data for the global view (without player related data)
     *
     * @param Request $request
     * @return json
     */
    public function gameDataGlobal(Request $request) {
        $game = Game::find($request->get('id'));
        $gameData = $this->gameData($game);

        return response()->json($gameData);
    }

    /**
     * Generic method getting all the current game data
     *
     * @param App\Game $game
     * @param boolean|App\Player $player
     * @return array $gameData
     */
    public function gameData($game, $player = false)
    {
        
        $gameData = [
            'gameId' => $game->id,
            'gameStep' => $game->step,
        ];


        if($player){
            // Check if the player is the winner of the two first steps
            $step1Winner = !!$player->winnerStep1($game);
            $step2Winner = !!$player->winnerStep2($game);
            $gameData['step_1_winner'] = $step1Winner;
            $gameData['step_2_winner'] = $step2Winner;
        }

        if($game->step == 1 && $game->question != 0) {

            $question = $game->questionWithOrder($game->question);
            $gameData['question'] = $question->cleanData($game);

            if($player) {

                // Check if the player has already answered this question
                $answer = Answer::where('game_id', $game->id)
                ->where('player_id', $player->id)
                ->where('question_id', $question->id)
                ->first();
                
                $gameData['question']['answered'] = !!$answer;
            } else {
                $gameData['question']['answer'] = $question->answer_good; 
            }
                
            // Check if the winners have been set up 
            $winners = $game->getStep1Winners();
            $gameData['question']['ended'] = !!count($winners);
        } 
        if($game->step == 2) {
            $performance = Performance::find($game->performance_sent);
            if($performance && $player) {
                if($step1Winner && $game->performance_player == $player->id && $game->performance_sent) {
                    $gameData['performance'] = $performance->performerData();
                } else if (!$step1Winner && $game->performance_props_sent) {
                    $gameData['performance'] = $performance->voterData($game);

                    // Check if the player has already answered this performance
                    $answer = PerfVote::where('game_id', $game->id)
                    ->where('player_id', $player->id)
                    ->where('performance_id', $performance->id)
                    ->first();
                    $gameData['performance']['answered'] = !!$answer;
                    
                }
            }
            // Check if the winners have been set up 
            $winners = $game->getStep2Winners();
            $gameData['performance']['ended'] = !!count($winners);
        }
        
        if($game->step == 3) {
            if($player) {

                $voteExists = Vote::where('game_id', $game->id)->where('player_id', $player->id)->first();
                $gameData['votes'] = [
                    'started' => !!$game->votes_started,
                    'answers' => $game->getStep3Props(), 
                    'answered' => !!$voteExists,
                ];
            }
            $gameData['step_3_winner'] = $game->getfinalWinnerName();
        }

        return $gameData;
    }
}

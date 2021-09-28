<?php

namespace App\Http\Controllers;

use App\PerfVote;
use App\Performance;
use Idplus\Mercure\Publify;
use Illuminate\Http\Request;
use Symfony\Component\Mercure\Update;

class PerformanceController extends Controller
{
    public function answerPerformance(Request $request, Publify $publisher)
    {
        $player = $request->get('player');
        $game = $request->get('game');
        $userAnswer = $request->get('answer');
        $performance = $request->get('performance');

        if(!$userAnswer || !$performance) {
            $errors = [
                'errors' => [
                    0 => 'Vous devez choisir une réponse !',
                ]
            ];
            return response()->json($errors, 422);
        }

        $performance = Performance::find($performance);

        $correct = ($userAnswer == $performance->answer_good);

        $answer = new PerfVote;
        $answer->game()->associate($game);
        $answer->player()->associate($player);
        $answer->performer()->associate($game->performance_player);
        $answer->performance()->associate($performance);
        $answer->answer = $userAnswer;
        $answer->correct_answer = $correct;


        try {
            $answer->save();

            $update = new Update(
                env('MERCURE_DOMAIN') . 'missoclock/game/'.$game->id.'/performances.jsonld',
                json_encode('')
            );
            $publisher($update);

        } catch (\Exception $e) {
            $errors = [
                'errors' => [
                    0 => 'Vous avez déjà répondu à cette question !',
                ]
            ];
            return response()->json($errors, 422);
        }
    }


    public function list()
    {
        $performances = Performance::orderBy('id', 'desc')->get();
        return view('performance.list', compact('performances'));
    }

    public function create()
    {
        return view('performance.create');
    }

    public function createpost(Request $request)
    {
        $performance = new Performance();
        $performance->title = $request->input('title');
        $performance->answer_1 = $request->input('answer_1');
        $performance->answer_2 = $request->input('answer_2');
        $performance->answer_3 = $request->input('answer_3');
        $performance->answer_good = $request->input('answer_good');
        $performance->save();
        return redirect()->back();
    }

    public function edit(Performance $performance)
    {
        return view('performance.create', compact('performance'));
    }

    public function editpost(Performance $performance, Request $request)
    {
        $performance->title = $request->input('title');
        $performance->answer_1 = $request->input('answer_1');
        $performance->answer_2 = $request->input('answer_2');
        $performance->answer_3 = $request->input('answer_3');
        $performance->answer_good = $request->input('answer_good');
        $performance->save();
        return redirect()->back();
    }

    public function delete(Performance $performance)
    {
        $performance->games()->detach();
        $performance->votes()->delete();
        $performance->delete();
        return redirect()->back();
    }
}

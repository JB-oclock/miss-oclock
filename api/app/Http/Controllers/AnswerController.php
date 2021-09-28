<?php

namespace App\Http\Controllers;

use Exception;
use App\Answer;
use App\Question;
use Idplus\Mercure\Publify;
use Illuminate\Http\Request;
use Symfony\Component\Mercure\Update;


class AnswerController extends Controller
{
    public function answerQuestion(Request $request, Publify $publisher) {

        $player = $request->get('player');
        $game = $request->get('game');
        $userAnswer = $request->get('answer');
        $question = $request->get('question');

        if(!$userAnswer || !$question) {
            $errors = [
                'errors' => [
                    0 => 'Vous devez choisir une réponse !',
                ]
            ];
            return response()->json($errors, 422);
        }

        $question = Question::find($question);

        $correct = ($userAnswer == $question->answer_good);

        $answer = new Answer;
        $answer->game()->associate($game);
        $answer->player()->associate($player);
        $answer->question()->associate($question);
        $answer->answer = $userAnswer;
        $answer->correct_answer = $correct;


        try {
            $answer->save();

            $data = [
                'player' => $player->name,
                'answer' => $correct
            ];

            $update = new Update(
                env('MERCURE_DOMAIN') . 'missoclock/game/'.$game->id.'/question/'.$question->id.'.jsonld',
                json_encode($data)
            );
            $publisher($update);

        } catch (Exception $e) {
            $errors = [
                'errors' => [
                    0 => 'Vous avez déjà répondu à cette question !',
                ]
            ];
            return response()->json($errors, 422);
        }

    }
}

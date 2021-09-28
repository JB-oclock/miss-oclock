@extends('layouts.app')

@section('content')
<div class="container-flex">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-start justify-content-between">
                    <span>Tableau de bord <br/>Code de jeu : {{ $game->code }}</span>
                    <a href="#" data-href="{{ route('reset-game', [$game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="reset" class="deletebtn btn btn-danger" data-title="tout le jeu">
                        Reset jeu
                    </a>
                  </div>
                  <div class="card-body">
                      <ul>
                          <li>ID: {{ $game->id }}</li>
                          <li>Step: {{ $game->step }}</li>
                      </ul>
                      <a class="btn btn-primary deletebtn  @if(!$stepOver || $game->step == 3)disabled @endif"  href="#" data-href="{{ route('next-step', ['game' => $game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="next-step" data-title="">
                        Étape suivante
                      </a>
                  </div>
              </div>
          </div>
            @if($game->step == 0)
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Participants : {{ count($players) }} </div>
                        <div class="card-body">
                            <ul class="list-group d-flex flex-row flex-wrap">
                                @php
                                @endphp
                                @forelse($players as $player)
                                    <li class="list-group-item w-50 border  p-2 px-3">{{$player->name}}</li>
                                @empty
                                    <li class="list-group-item">Pas encore de participants</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            @elseif($game->step == 1)
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Questions
                            @if($question['last'])
                            <a class="btn btn-primary float-right @if($stepOver)disabled @endif deletebtn"  href="#" data-href="{{ route('set-step1-winners', ['game' => $game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="valid-winners" data-title="">
                                Valider les vainqueurs
                            </a>
                            @else
                            <a class="btn btn-primary float-right mr-2 deletebtn"  href="#" data-href="{{ route('next-question', ['game' => $game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="next-question" data-title="">
                                Question suivante
                            </a>
                            @endif
                            <a class="btn btn-success float-right mr-2 deletebtn"  href="#" data-href="{{ route('display-answer', ['game' => $game->id, 'question' => $question['questionId']]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="display-answer" data-title="">
                                Afficher la réponse
                            </a>
                        </div>
                        <div class="card-body">
                            <p>
                                Question actuelle :  @if($question['last']) Dernière question ! @endif
                            </p>
                            ID : {{ $question['questionId'] }} <br>
                            Question : {{ $question['question'] }} <br>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h2 class="answers">Réponses : <span class="current">{{ count($answers) }}</span> / <span class="total">{{ count($game->players) }}</span></h2>
                        </div>
                        <div class="card-body">
                            <div class="row live-questions" data-mercure={{ env('MERCURE_DOMAIN') }} data-subscribe="{{ env('MERCURE_DOMAIN') . 'missoclock/game/'.$game->id.'/question/'.$question['questionId'].'.jsonld', }}">
                                @forelse($answers as $answer)
                                    <div class="col-lg-4 col-sm-12 border px-3 p-2 @if($answer->correct_answer) alert-success @endif">{{$answer->player->name}}</div>
                                @empty
                                    <div class="no-answer">Pas encore de réponses</div>
                                @endforelse

                            </div>

                        </div>


                    </div>
                    <div class="card">
                        <div class="card-header"><h2>Non répondu : </h2></div>
                        <div class="card-body">
                            <div class="row laters">
                                @forelse($playersWithoutAnswer as $later)
                                    <div class="col-lg-4 col-sm-12 border px-3 p-2" data-later="{{$later->name}}">{{$later->name}}</div>
                                @empty
                                    Tout le monde a répondu !
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h2>Score total :</h2>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @php
                                $i = 1
                                @endphp
                                @forelse($players as $name => $score)
                                    <li class="list-group-item @if($i <= $game->winners) list-group-item-success @endif">{{$name}} : {{$score}}</li>
                                    @php $i++ @endphp
                                @empty
                                    <li class="list-group-item">Pas encore de réponses</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            @elseif($game->step == 2)
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Performances
                            <a class="btn btn-danger float-right deletebtn"  href="#" data-href="{{ route('reset-perfs', [$game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="reset" data-title="cette étape">
                                Reset Perfs
                            </a>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @forelse($players as $key => $player)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold flex-fill">
                                            {{ $player->name }} :
                                        </span>
                                        @php
                                            $disabled = ($perfsOver ||  $performersData[$player->id]['nb_perfs'] == 2 || $game->performance_player != 0 && $game->performance_player != $player->id);
                                            $sendDisabled = ($disabled || $game->performance_sent);
                                            $propsDisabled = ($disabled || !$game->performance_sent || $game->performance_props_sent);
                                            $validationDisabled = ($disabled || (!$game->performance_sent || !$game->performance_props_sent));
                                        @endphp
                                        <div class="btn-group mr-2" role="group" aria-label="Basic example">
                                                <a href="{{ route('send-performance', ['game' => $game->id, 'player' => $player->id]) }}" class="btn btn-secondary @if($sendDisabled)disabled @endif">Envoyer perf.</a>
                                                <a href="{{ route('send-performance-props', ['game' => $game->id]) }}" class="btn btn-secondary @if($propsDisabled)disabled @endif">Envoyer propositions</a>
                                                <a href="{{ route('validate-performance', ['game' => $game->id]) }}" class="btn btn-secondary @if($validationDisabled) disabled @endif">Valider perf.</a>
                                        </div>
                                        <div class="mr-2">
                                            Perfs : <span class="badge badge-secondary ">{{ $performersData[$player->id]['nb_perfs'] }}</span>
                                        </div>
                                        <div class="mr-2">
                                            Score : <span class="badge badge-success ">{{ $performersData[$player->id]['score'] }}</span>
                                        </div>
                                    </li>
                                @empty

                                @endforelse
                            </ul>
                            @if($perfsOver)
                                <a class="btn btn-primary @if($stepOver)disabled @endif deletebtn"  href="#" data-href="{{ route('set-step2-winners', ['game' => $game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="valid-winners" data-title="">
                                    Valider les vainqueurs
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            @elseif($game->step == 3)
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Votes </div>
                    <div class="card-body">
                        <a class="btn btn-primary  @if($game->votes_started)disabled @endif" href="{{ route('send-votes', ['game' => $game->id]) }}" role="button">Activer la votation !</a>
                        <a class="btn btn-primary @if(!$game->votes_started)disabled @endif deletebtn"  href="#" data-href="{{ route('validate-votes', ['game' => $game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="valid-winners" data-title="">
                            Valider les résultats
                        </a>


                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @php
                            $i = 1
                            @endphp
                            @forelse($players as $player)
                                <li class="list-group-item">{{$player['player']->name}} : {{$player['score']}}</li>
                                @php $i++ @endphp
                            @empty
                                <li class="list-group-item">Pas encore de réponses</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
            @endif
        </div>
    </div>
</div>
@endsection
<template class="answer-template">
    <div class="col-lg-4 col-sm-12 border px-3 p-2"></div>
</template>

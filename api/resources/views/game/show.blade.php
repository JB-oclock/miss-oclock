@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tableau de bord <a class="btn btn-danger float-right" href="{{ route('reset-game', [$game->id]) }}">Reset jeu</a></div>
                    <div class="card-body">
                        <ul>
                            <li>ID: {{ $game->id }}</li>
                            <li>Step: {{ $game->step }}</li>
                        </ul>
                        <a class="btn btn-primary @if(!$stepOver || $game->step == 3)disabled @endif" href="{{ route('next-step', ['game' => $game->id]) }}" role="button">Étape suivante</a>
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
                            <a class="btn btn-primary float-right @if($stepOver)disabled @endif" href="{{ route('set-step1-winners', ['game' => $game->id]) }}" role="button">Valider les vainqueurs</a>
                            @else
                            <a class="btn btn-primary float-right" href="{{ route('next-question', ['game' => $game->id]) }}" role="button">Question suivante</a>
                            @endif
                            <a class="btn btn-success float-right mr-2" href="{{ route('display-answer', ['game' => $game->id, 'question' => $question['questionId']]) }}" role="button">Afficher la réponse</a>
                        </div>
                        <div class="card-body">
                            <p>
                                Question actuelle :  @if($question['last']) Dernière question ! @endif
                            </p>
                            ID : {{ $question['questionId'] }} <br>
                            Question : {{ $question['question'] }} <br>
                           
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <h2>Score :</h2>
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
                        <div class="card-header">Performances <a class="btn btn-danger float-right" href="{{ route('reset-perfs', [$game->id]) }}">Reset Perfs</a></div>
                        <div class="card-body">
                            <ul class="list-group">
                                @forelse($players as $key => $player)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold">
                                            {{ $player->name }} : 
                                        </span>
                                        @php
                                            $disabled = ($perfsOver ||  $performersData[$player->id]['nb_perfs'] == 2 || $game->performance_player != 0 && $game->performance_player != $player->id);
                                            $sendDisabled = ($disabled || $game->performance_sent);
                                            $propsDisabled = ($disabled || !$game->performance_sent || $game->performance_props_sent);
                                            $validationDisabled = ($disabled || (!$game->performance_sent || !$game->performance_props_sent));
                                        @endphp
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ route('send-performance', ['game' => $game->id, 'player' => $player->id]) }}" class="btn btn-secondary @if($sendDisabled)disabled @endif">Envoyer perf.</a>
                                                <a href="{{ route('send-performance-props', ['game' => $game->id]) }}" class="btn btn-secondary @if($propsDisabled)disabled @endif">Envoyer propositions</a>
                                                <a href="{{ route('validate-performance', ['game' => $game->id]) }}" class="btn btn-secondary @if($validationDisabled) disabled @endif">Valider perf.</a>
                                        </div>
                                        Perfs : <span class="badge badge-secondary ">{{ $performersData[$player->id]['nb_perfs'] }}</span>
                                        Score : <span class="badge badge-success ">{{ $performersData[$player->id]['score'] }}</span>
                                    </li>
                                @empty
                                    
                                @endforelse
                            </ul>
                            @if($perfsOver)
                                <a class="btn btn-primary @if($stepOver)disabled @endif" href="{{ route('set-step2-winners', ['game' => $game->id]) }}" role="button">Valider les vainqueurs</a>
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
                        <a class="btn btn-primary  @if(!$game->votes_started)disabled @endif" href="{{ route('validate-votes', ['game' => $game->id]) }}" role="button">Valider les résultats</a>
                        <ul class="list-group">
                            
                        </ul>
                        
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

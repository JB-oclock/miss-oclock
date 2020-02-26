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
                        <a class="btn btn-primary @if(!$stepOver)disabled @endif" href="{{ route('next-step', ['game' => $game->id]) }}" role="button">Étape suivante</a>
                    </div>
                </div>
            </div>
            @if($game->step == 1)
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Questions</div>
                        <div class="card-body">
                            Question actuelle : {{ $game->question }} @if($question['last']) Dernière question ! @endif
                            @if($question['last'])
                                <a class="btn btn-primary @if($stepOver)disabled @endif" href="{{ route('set-step1-winners', ['game' => $game->id]) }}" role="button">Valider les vainqueurs</a>
                            @else
                                <a class="btn btn-primary" href="{{ route('next-question', ['game' => $game->id]) }}" role="button">Question suivante</a>
                            @endif
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
                        <div class="card-header">Performances <a class="btn btn-danger float-right" href="{{ route('reset-perfs', [$game->id]) }}">Reset Perfs</a></div>
                        <div class="card-body">
                            <ul class="list-group">
                            @forelse($players as $key => $player)
                                <li class="list-group-item">
                                    <span class="font-weight-bold">
                                        {{ $player->name }} : 
                                    </span>
                                    @php
                                        $disabled = ($game->performance_player != 0 && $game->performance_player != $player->id);
                                        $sendDisabled = ($disabled || $game->performance_sent);
                                        $propsDisabled = ($disabled || !$game->performance_sent || $game->performance_props_sent);
                                        $validationDisabled = ($disabled || (!$game->performance_sent || !$game->performance_props_sent));
                                    @endphp
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ route('send-performance', ['game' => $game->id, 'player' => $player->id]) }}" class="btn btn-secondary @if($sendDisabled)disabled @endif">Envoyer perf.</a>
                                            <a href="#" class="btn btn-secondary @if($propsDisabled)disabled @endif">Envoyer propositions</a>
                                            <a href="#" class="btn btn-secondary @if($validationDisabled) disabled @endif">Valider perf.</a>
                                    </div>
                                </li>
                            @empty
                                
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

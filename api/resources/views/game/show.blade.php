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
                        <a class="btn btn-primary" href="{{ route('next-step', ['game' => $game->id]) }}" role="button">Etape suivante</a>
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
                                <a class="btn btn-primary" href="{{ route('set-step1-winners', ['game' => $game->id]) }}" role="button">Valider les vainqueurs</a>
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
            @endif
        </div>
    </div>
</div>
@endsection

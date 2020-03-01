@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <span>Édition de la game</span>
                </div>
                <div class="card-body">
                  {{ Form::model($game, array('route' => array('edit-game-post', $game->id))) }}

                  <div class="form-group">
                    {{ Form::label('code', 'Code du jeu') }}
                    {{ Form::text('code', null, ['class' => 'form-control']) }}
                    <small id="winnersInfo" class="form-text text-muted">5 caractères (lettres et chiffres)</small>
                  </div>

                  <div class="form-group">
                    {{ Form::label('winners', 'Nombre de gagnants pour l\'étape 1') }}
                    {{ Form::number('winners', null, ['class' => 'form-control']) }}
                  </div>

                  <div class="form-group">
                    {{ Form::submit('Enregistrer', ['class' => 'btn btn-primary']) }}
                    {!! Form::close() !!}
                  </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">Gestion des associations</div>
                <div class="card-body">
                    <a class="btn btn-success" href="{{ route('next-step', ['game' => $game->id]) }}" role="button">Questions liées</a><br><br>
                    <a class="btn btn-success" href="{{ route('next-step', ['game' => $game->id]) }}" role="button">Performances liées</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

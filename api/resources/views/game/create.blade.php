@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span>Création d'une game</span>
                </div>
                <div class="card-body">
                  {{ Form::open(['route' => 'create-game-post']) }}

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
                    <small id="associationsInfo" class="form-text text-muted">L'ajout de questions et performances se fait après création</small>
                    {!! Form::close() !!}
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

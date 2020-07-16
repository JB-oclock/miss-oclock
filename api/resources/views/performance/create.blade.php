@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  @isset ($performance)
                    <span>Édition d'une performance</span>
                  @else
                    <span>Création d'une performance</span>
                  @endisset
                </div>
                <div class="card-body">
                  @isset ($performance)
                    {{ Form::model($performance, array('route' => array('edit-performance-post', $performance->id))) }}
                  @else
                    {{ Form::open(['route' => 'create-performance-post']) }}
                  @endisset

                  <div class="form-group">
                    {{ Form::label('title', 'Intitulé de la question (pour le public)') }}
                    {{ Form::text('title', null, ['class' => 'form-control']) }}
                  </div>

                  <div class="form-group">
                    {{ Form::label('answer_good', 'Bonne réponse (chose à dessiner)') }}
                    {{ Form::text('answer_good', null, ['class' => 'form-control']) }}
                  </div>

                  <div class="form-group">
                    {{ Form::label('answer_1', 'Autre proposition - 1') }}
                    {{ Form::text('answer_1', null, ['class' => 'form-control']) }}
                    {{ Form::label('answer_2', 'Autre proposition - 2') }}
                    {{ Form::text('answer_2', null, ['class' => 'form-control']) }}
                    {{ Form::label('answer_3', 'Autre proposition - 3') }}
                    {{ Form::text('answer_3', null, ['class' => 'form-control']) }}
                  </div>

                  <div class="form-group">
                    {{ Form::submit('Enregistrer', ['class' => 'btn btn-primary']) }}
                    {!! Form::close() !!}
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

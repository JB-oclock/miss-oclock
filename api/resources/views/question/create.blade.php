@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  @isset ($question)
                    <span>Édition d'une question</span>
                  @else
                    <span>Création d'une question</span>
                  @endisset
                </div>
                <div class="card-body">
                  @foreach($errors->all() as $message)
                      <div class="alert alert-danger">{{ $message }}</div>
                  @endforeach
                  @isset ($question)
                    {{ Form::model($question, array('route' => array('edit-question-post', $question->id), 'files' => true)) }}
                  @else
                    {{ Form::open(['route' => 'create-question-post', 'files' => true]) }}
                  @endisset

                  <div class="form-group">
                    {{ Form::label('title', 'Intitulé de la question') }}
                    {{ Form::text('title', null, ['class' => 'form-control']) }}
                  </div>

                  <div class="form-group">
                    {{ Form::label('answer_good', 'Bonne réponse') }}
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
                    {!! Form::label('image', "Image à afficher sur l'écran de présentation de réponse") !!}
                    {!! Form::file('image', ['class' => 'form-control']) !!}
                    @if(isset($question) && !empty($question->image))
                        <img width="200" src="{{ asset('/storage/'.$question->image) }}" >
                    @endif
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

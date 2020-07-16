@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
      <div class="col">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">Général</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="questions-tab" data-toggle="tab" href="#questions" role="tab" aria-controls="questions" aria-selected="false">Questions</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="performances-tab" data-toggle="tab" href="#performances" role="tab" aria-controls="performances" aria-selected="false">Performances</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
            <div class="card">
              <div class="card-header">
                  <span>Infos générales</span>
              </div>
              <div class="card-body">
                {{ Form::model($game, array('route' => array('edit-game-post', $game->id), 'class' => 'edit-form')) }}

                <div class="form-group">
                  {{ Form::label('code', 'Code du jeu') }}
                  {{ Form::text('code', null, ['class' => 'form-control']) }}
                  <small id="winnersInfo" class="form-text text-muted">5 caractères (lettres et chiffres)</small>
                </div>

                <div class="form-group">
                  {{ Form::label('winners', 'Nombre de gagnants pour l\'étape 1') }}
                  {{ Form::number('winners', null, ['class' => 'form-control']) }}
                </div>
                {!! Form::hidden('questions', implode(',', $questionIds), ['class' => 'questions']) !!}
                {!! Form::hidden('performances', implode(',', $performanceIds), ['class' => 'performances']) !!}
                <div class="form-group">
                  {{ Form::submit('Enregistrer', ['class' => 'btn btn-primary']) }}
                  {!! Form::close() !!}
                </div>
              </div>
          </div>
          </div>
          <div class="tab-pane fade" id="questions" role="tabpanel" aria-labelledby="questions-tab">
            <div class="card mb-4 mt-4">
              <div class="card-header d-flex align-items-center justify-content-between ">
                <h2>Questions du jeu</h2>
                <a class="btn btn-primary float-right async" href="#" data-type="questions">Enregistrer</a>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col">
                  <div class="card">
                      <div class="card-header">
                          <span>Questions retenues</span>
                      </div>
                      <div class="card-body">
                        <ul class="draggable-container container-questions list-group" id="savable">
                          @foreach ($questions as $question)
                            <li class="draggable-source list-group-item" data-id="{{ $question->id}}">{{ $question->title }}</li>
                          @endforeach
                        </ul>
                      </div>
                  </div>
              </div>
      
              <div class="col">
                  <div class="card">
                      <div class="card-header">
                          <span>Questions disponibles</span>
                      </div>
                      <div class="card-body">
                        <ul class="draggable-container list-group">
                          @foreach ($remainingQuestions as $question)
                            <li class="draggable-source list-group-item" data-id="{{ $question->id}}">{{ $question->title }}</li>
                          @endforeach
                        </ul>
                      </div>
                  </div>
              </div>
          </div>
          </div>
          <div class="tab-pane fade" id="performances" role="tabpanel" aria-labelledby="performances-tab">
            <div class="card mb-4 mt-4">
              <div class="card-header d-flex align-items-center justify-content-between ">
                <h2>Performances du jeu</h2>
                <a class="btn btn-primary float-right async" href="#" data-type="performances">Enregistrer</a>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col">
                  <div class="card">
                      <div class="card-header">
                          <span>Performances retenues</span>
                      </div>
                      <div class="card-body">
                        <ul class="draggable-container container-performances list-group" id="savable">
                          @foreach ($performances as $performance)
                            <li class="draggable-source list-group-item" data-id="{{ $performance->id}}">{{ $performance->answer_good }}</li>
                          @endforeach
                        </ul>
                      </div>
                  </div>
              </div>
      
              <div class="col">
                  <div class="card">
                      <div class="card-header">
                          <span>Performances disponibles</span>
                      </div>
                      <div class="card-body">
                        <ul class="draggable-container list-group">
                          @foreach ($remainingPerformances as $performance)
                            <li class="draggable-source list-group-item" data-id="{{ $performance->id}}">{{ $performance->answer_good }}</li>
                          @endforeach
                        </ul>
                      </div>
                  </div>
              </div>
          </div>
        </div>
            
        </div>
       
    </div>


   

</div>


<script src="{{ asset('js/dragndrop.js') }}"></script>

@endsection

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
                        @if($game->step === 0)
                            Lancer le quiz
                        @else
                            Étape suivante
                        @endif
                      </a>
                  </div>
              </div>
          </div>
            @if($game->step == 0)
                @include('game.steps.step0')
            @elseif($game->step == 1)
                @include('game.steps.step1')
            @elseif($game->step == 2)
                @include('game.steps.step2')
            @elseif($game->step == 3)
                @include('game.steps.step3')
            @endif
        </div>
    </div>
</div>
@endsection
<template class="answer-template">
    <div class="col-lg-4 col-sm-12 border px-3 p-2"></div>
</template>

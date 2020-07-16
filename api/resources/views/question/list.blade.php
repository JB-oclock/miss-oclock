@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between  align-items-center">
              <h1>Questions</h1>
              <a class="btn btn-primary" href="{{ route('create-question') }}" role="button">Nouvelle question</a>

            </li>
            @forelse ($questions as $question)
                <li class="list-group-item d-flex justify-content-between  align-items-center">
                  <a href="{{ route('edit-question', ['question' => $question->id]) }}">{{ $question->title }}</a>
                  <span>
                    <a href=""></a>
                    <a href="#" data-href="{{ route('delete-question', ['question' => $question->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="delete" class="deletebtn" data-title="{{ $question->title }}">
                      <span class="btn btn-danger">Supprimer</span>
                    </a>
                  </span>
                </li>
            @empty
                <li class="list-group-item">
                  Pas encore de question !
                </li>
            @endforelse
          </ul>
        </div>
    </div>
</div>
@endsection

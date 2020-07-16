@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between  align-items-center">
              <h1>Performances</h1>
              <a class="btn btn-primary" href="{{ route('create-performance') }}" role="button">Nouvelle performance</a>

            </li>
            @forelse ($performances as $performance)
                <li class="list-group-item d-flex justify-content-between  align-items-center">
                  <a href="{{ route('edit-performance', ['performance' => $performance->id]) }}">{{ $performance->title }}</a>
                  <span>
                    <a href=""></a>
                    <a href="#" data-href="{{ route('delete-performance', ['performance' => $performance->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="delete" class="deletebtn" data-title="{{ $performance->title }}">
                      <span class="btn btn-danger">Supprimer</span>
                    </a>
                  </span>
                </li>
            @empty
                <li class="list-group-item">
                  Pas encore de performance !
                </li>
            @endforelse
          </ul>
        </div>
    </div>
</div>
@endsection

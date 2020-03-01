@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Jeux disponibles</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="games table ">
                      <thead>
                        <th scope="col">Code</th>
                        <th scope="col">À l'étape</th>
                        <th scope="col">Création</th>
                        <th scope="col">MAJ</th>
                        <th scope="col">Action</th>
                      </thead>
                      <tbody>
                      @foreach ($games as $game)
                        <tr>
                          <td>
                            {{ $game->code }}
                          </td>
                          <td>{{ $game->step }}</td>
                          <td>{{ $game->created_at->format('d/m/Y H:i') }}</td>
                          <td>{{ $game->updated_at->format('d-m-Y H:i') }}</td>
                          <td>
                            <a href="{{ route('show-game', ['game' => $game->id]) }}" class="btn btn-success">Jouer</a>
                            <a href="{{ route('show-game', ['game' => $game->id]) }}" class="btn btn-primary">Éditer</a>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>

                    <a class="btn btn-primary" href="#" role="button">Nouveau jeu</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

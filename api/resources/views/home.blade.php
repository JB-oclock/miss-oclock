@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">


        <div class="col col-md-8">
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
                          <td>{{ $game->updated_at->format('d/m/Y H:i') }}</td>
                          <td>
                            <a href="{{ route('show-game', ['game' => $game->id]) }}" class="btn btn-success">Jouer</a>
                            <a href="{{ route('edit-game', ['game' => $game->id]) }}" class="btn btn-primary">Éditer</a>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>

                    <a class="btn btn-primary" href="{{ route('create-game') }}" role="button">Nouveau jeu</a>
                </div>
            </div>
        </div>
    </div>



    <div class="row justify-content-center mt-4">
        <div class="col col-md-4">
            <div class="card">
                <div class="card-header">Questions enregistrées</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul class="questions list">
                      @foreach ($questions as $question)
                        <li>
                          <a href="{{ route('edit-question', ['question' => $question->id]) }}">
                            {{ $question->title }}
                          </a>
                          <a href="#" data-href="{{ route('delete-question', ['question' => $question->id]) }}" data-toggle="modal" data-target="#confirm-delete" class="deletebtn" data-title="{{ $question->title }}">
                            <span class="badge badge-danger deletebtn">x</span>
                          </a>
                        </li>
                      @endforeach
                    </ul>

                    <a class="btn btn-primary" href="{{ route('create-question') }}" role="button">Nouvelle question</a>
                </div>
            </div>
        </div>


        <div class="col col-md-4">
            <div class="card">
                <div class="card-header">Performances enregistrées</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul class="performances list">
                      @foreach ($performances as $performance)
                        <li>
                          <a href="{{ route('edit-performance', ['performance' => $performance->id]) }}">
                            {{ $performance->answer_good }}
                          </a>
                          <a href="#" data-href="{{ route('delete-performance', ['performance' => $performance->id]) }}" data-toggle="modal" data-target="#confirm-delete" class="deletebtn" data-title="{{ $performance->answer_good }}">
                            <span class="badge badge-danger deletebtn">x</span>
                          </a>
                        </li>
                      @endforeach
                    </ul>

                    <a class="btn btn-primary" href="{{ route('create-performance') }}" role="button">Nouvelle performance</a>
                </div>
            </div>
        </div>

    </div>
</div>




<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
              Voulez-vous réellement supprimer cet élément :
              <p id="question-title-copy"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
              <a class="btn btn-danger btn-ok" id="confirm-delete-btn">Supprimer</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
(function() {
  const deletebtns = document.getElementsByClassName('deletebtn');
  const modalBtn = document.getElementById('confirm-delete-btn');
  const titleCopy = document.getElementById('question-title-copy');

  for (let btn of deletebtns) {
    btn.addEventListener('click', function(e){
      let url = e.target.parentElement.dataset.href;
      let title = e.target.parentElement.dataset.title;
      console.log(title);
      modalBtn.href = url;
      titleCopy.innerText = title;
    });
  }
})();
</script>

@endsection

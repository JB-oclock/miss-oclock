<div class="col-md-8">
    <div class="card">
        <div class="card-header">Votes </div>
        <div class="card-body">
            <a class="btn btn-primary  @if($game->votes_started)disabled @endif" href="{{ route('send-votes', ['game' => $game->id]) }}" role="button">Activer la votation !</a>
            <a class="btn btn-primary @if(!$game->votes_started)disabled @endif deletebtn"  href="#" data-href="{{ route('validate-votes', ['game' => $game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="valid-winners" data-title="">
                Valider les résultats
            </a>


        </div>
        <div class="card-body">
            <ul class="list-group">
                @php
                $i = 1
                @endphp
                @forelse($players as $player)
                    <li class="list-group-item">{{$player['player']->name}} : {{$player['score']}}</li>
                    @php $i++ @endphp
                @empty
                    <li class="list-group-item">Pas encore de réponses</li>
                @endforelse
            </ul>
        </div>
    </div>

</div>

<div class="col-md-8">
    <div class="card">
        <div class="card-header">Votes </div>
        <div class="card-body">
            <a class="btn btn-primary  @if($game->votes_started)disabled @endif" href="{{ route('send-roulette', ['game' => $game->id]) }}" role="button">Activer la roulette</a>
            <a class="btn btn-primary  @if($game->votes_started)disabled @endif" href="{{ route('send-subject', ['game' => $game->id]) }}" role="button">Lancer le sujet</a>
            <a class="btn btn-primary  @if($game->votes_started)disabled @endif" href="{{ route('send-votes', ['game' => $game->id]) }}" role="button">Activer la votation !</a>
            <a class="btn btn-primary @if(!$game->votes_started)disabled @endif deletebtn"  href="#" data-href="{{ route('validate-votes', ['game' => $game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="valid-winners" data-title="">
                Valider les résultats
            </a>


        </div>
        <div class="card-body">
            <h2 class="total">Total : <span>{{$totalVotes}}</span></h2>
            <ul class="list-group live-final" data-mercure={{ env('MERCURE_DOMAIN') }} data-subscribe="{{  env('MERCURE_DOMAIN') . 'missoclock/game/'.$game->id.'/final.jsonld' }}">
                @foreach($players as $player)
                    <li class="list-group-item"><span class="name">{{$player['player']->name}}</span> : <span class="score"> {{$player['score']}}</span></li>
                @endforeach
            </ul>
        </div>
    </div>

</div>

<div class="col-md-8">
    <div class="card">
        <div class="card-header">Participants : <span class="total-players">{{ count($players) }}</span></div>
        <div class="card-body">
            <ul class="list-group d-flex flex-row flex-wrap live-players" data-mercure={{ env('MERCURE_DOMAIN') }} data-subscribe="{{  env('MERCURE_DOMAIN') . 'missoclock/game/'.$game->id.'/players.jsonld' }}">
                @forelse($players as $player)
                    <li class="list-group-item w-50 border  p-2 px-3">{{$player->name}}</li>
                @empty
                    <li class="list-group-item no-players">Pas encore de participants</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

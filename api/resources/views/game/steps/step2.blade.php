<div class="col-md-8">
    <div class="card">
        <div class="card-header">Performances
            <a class="btn btn-danger float-right deletebtn"  href="#" data-href="{{ route('reset-perfs', [$game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="reset" data-title="cette étape">
                Reset Perfs
            </a>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @forelse($players as $key => $player)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="font-weight-bold flex-fill">
                            {{ $player->name }} :
                        </span>
                        @php
                            $disabled = ($perfsOver ||  ($performersData[$player->id]['nb_perfs'] == 2 && $game->performance_player != $player->id) || $game->performance_player != 0 && $game->performance_player != $player->id);
                            $sendDisabled = ($disabled || $game->performance_sent);
                            $propsDisabled = ($disabled || !$game->performance_sent || $game->performance_props_sent);
                            $validationDisabled = ($disabled || (!$game->performance_sent || !$game->performance_props_sent));
                        @endphp
                        @if($game->performance_player == $player->id)
                            <div class="mr-2 live-vote" data-mercure={{ env('MERCURE_DOMAIN') }} data-subscribe="{{ env('MERCURE_DOMAIN') . 'missoclock/game/'.$game->id.'/performances.jsonld', }}">
                               Votes : <span class="badge badge-secondary">{{ $perfVotes }}</span>
                            </div>
                        @endif
                        <div class="btn-group mr-2" role="group" aria-label="Basic example">
                                <a href="{{ route('send-performance', ['game' => $game->id, 'player' => $player->id]) }}" class="btn btn-secondary @if($sendDisabled)disabled @endif">Envoyer perf.</a>
                                <a href="{{ route('send-performance-props', ['game' => $game->id]) }}" class="btn btn-secondary @if($propsDisabled)disabled @endif">Envoyer propositions</a>
                                <a href="{{ route('validate-performance', ['game' => $game->id]) }}" class="btn btn-secondary @if($validationDisabled) disabled @endif">Valider perf.</a>
                        </div>

                        <div class="mr-2">
                            Nb dessins faits : <span class="badge badge-secondary ">{{ $performersData[$player->id]['nb_perfs'] }}</span>
                        </div>
                        <div class="mr-2">
                            Score : <span class="badge badge-success ">{{ $performersData[$player->id]['score'] }}</span>
                        </div>
                    </li>
                @empty

                @endforelse
            </ul>
            @if($perfsOver)
                <a class="btn btn-primary @if($stepOver)disabled @endif deletebtn"  href="#" data-href="{{ route('set-step2-winners', ['game' => $game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="valid-winners" data-title="">
                    Valider les vainqueurs
                </a>
            @endif
        </div>

    </div>
</div>

<div class="col-md-8">
    <div class="card">
        <div class="card-header"><h2 class="d-inline">Questions ({{$gameQuestion}} / {{ $numberQuestions }})</h2>
            @if($question['last'])
            <a class="btn btn-primary float-right @if($stepOver)disabled @endif deletebtn"  href="#" data-href="{{ route('set-step1-winners', ['game' => $game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="valid-winners" data-title="">
                Valider les vainqueurs
            </a>
            @else
            <a class="btn btn-primary float-right mr-2 deletebtn"  href="#" data-href="{{ route('next-question', ['game' => $game->id]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="next-question" data-title="">
                @if($game->question === 0)
                    Lancer la première question
                @else
                    Question suivante
                @endif
            </a>
            @endif
            @if($game->question !== 0)

                <a class="btn btn-success float-right mr-2 deletebtn"  href="#" data-href="{{ route('display-answer', ['game' => $game->id, 'question' => $question['questionId']]) }}" data-toggle="modal" data-target="#confirm-delete" data-action="display-answer" data-title="">
                    Afficher la réponse
                </a>
            @endif
        </div>
        <div class="card-body">
            <p>
                Question actuelle :  @if($question['last']) Dernière question ! @endif
            </p>
            ID : {{ $question['questionId'] }} <br>
            Question : {{ $question['question'] }} <br>

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2 class="answers">Réponses : <span class="current">{{ count($answers) }}</span> / <span class="total">{{ count($game->players) }}</span></h2>
        </div>
        <div class="card-body">
            <div class="row live-questions" data-mercure="{{ env('MERCURE_DOMAIN') }}" data-subscribe="{{ env('MERCURE_DOMAIN') . 'missoclock/game/'.$game->id.'/question/'.$question['questionId'].'.jsonld' }}">
                @forelse($answers as $answer)
                    <div class="col-lg-4 col-sm-12 border px-3 p-2 @if($answer->correct_answer) alert-success @endif">{{$answer->player->name}}</div>
                @empty
                    <div class="no-answer">Pas encore de réponses</div>
                @endforelse

            </div>

        </div>


    </div>
    <div class="card">
        <div class="card-header"><h2>Non répondu : </h2></div>
        <div class="card-body">
            <div class="row laters">
                @forelse($playersWithoutAnswer as $later)
                    <div class="col-lg-4 col-sm-12 border px-3 p-2" data-later="{{$later->name}}">{{$later->name}}</div>
                @empty
                    Tout le monde a répondu !
                @endforelse
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2>Score total :</h2>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @php
                $i = 1
                @endphp
                @forelse($players as $name => $score)
                    <li class="list-group-item @if($i <= $game->winners) list-group-item-success @endif">{{$name}} : {{$score}}</li>
                    @php $i++ @endphp
                @empty
                    <li class="list-group-item">Pas encore de réponses</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

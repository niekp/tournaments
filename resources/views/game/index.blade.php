@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $tournament->title }}</h3>
    <p><small class="text-muted">{{ __('Click on a cell to enter the score') }}</small></p>
    <table class="table table-hover" data-games>
        <thead>
            <tr>
                <th>&nbsp;</th>
                @foreach ($tournament->players->sort() as $player)
                    <th>{{ $player->name }}</th>
                @endforeach
            </tr>
        </thead>
        @foreach ($tournament->players->sort() as $player1)
            <tr>
                <th>{{ $player1->name }}</th>

                @foreach ($tournament->players->sort() as $player2)
                    @if ($player1->id != $player2->id)
                    <td data-game="{{ route('game.modal', [ 'guid' => $tournament->guid, 'id' => $tournament->getGame($player1, $player2)->id ]) }}" >
                        {{ $tournament->getGame($player1, $player2)->getWinnerText() }}
                    </td>
                    @else
                    <td>
                        -
                    </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </table>
</div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/game.js') }}" type="text/javascript" defer></script>
    <link href="{{ URL::asset('css/game.css') }}" rel="stylesheet" />
@endsection

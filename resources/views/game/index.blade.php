@extends('layouts.app')

@section('content')
<div class="container">
    <button class="btn btn-light float-right" data-copy-url>{{ __('Copy sharable URL') }}</button>
    <h3>{{ $tournament->title }}</h3>
    <p><small class="text-muted">{{ __('Click on a cell to enter the score') }}</small></p>
    <table class="table table-hover" data-games>
        <thead>
            <tr>
                <th>&nbsp;</th>
                @foreach ($tournament->players->sortBy('name') as $player)
                    <th>{{ $player->name }}</th>
                @endforeach
            </tr>
        </thead>
        @foreach ($tournament->players->sortBy('name') as $player1)
            <tr>
                <th>{{ $player1->name }}</th>

                @foreach ($tournament->players->sortBy('name') as $player2)
                    @if ($player1->id != $player2->id)
                    <td data-game="{{ route('game.modal', [ 'guid' => $tournament->guid, 'id' => $tournament->getGame($player1, $player2)->id ]) }}" >
                        {{ $tournament->getGame($player1, $player2)->getGameText() }}
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

    <h3>{{ __('Statistics') }}</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>{{ __('Player') }}</th>
                <th>{{ __('Games played') }}</th>
                <th>{{ __('Games won') }}</th>
                <th>{{ __('Won %') }}</th>
            </tr>
        </thead>
        @foreach ($statistics as $statistic)
            <tr>
                <td>{{ $statistic->player->name }}</td>
                <td>{{ $statistic->gamesPlayed }}</td>
                <td>{{ $statistic->gamesWon }}</td>
                <td>{{ $statistic->getWinPercentage() }}%</td>
            </tr>
        @endforeach
    </table>
</div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/game.js') }}" type="text/javascript" defer></script>
    <link href="{{ URL::asset('css/game.css') }}" rel="stylesheet" />
@endsection

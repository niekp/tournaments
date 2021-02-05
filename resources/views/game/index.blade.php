@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $tournament->title }}</h3>
    <table class="table table-hover">
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
                    <td>
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

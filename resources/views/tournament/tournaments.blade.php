@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tournaments') }}</div>

                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <th class="w-25">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($tournaments as $tournament)
                            <tr>
                                <td>{{ $tournament->title }}</td>
		                        <td>
                                    <a href="{{ route('tournament.edit', [ 'id' => $tournament->id ]) }}"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{ route('tournament.delete', [ 'id' => $tournament->id ]) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-link"><i class="fas fa-trash"></i></button>
                                    </form>
                                    <a href="{{ route('games', [ 'guid' => $tournament->guid ]) }}"><i class="fas fa-gamepad"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">{{ __('Start new tournament') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tournament.new') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">{{ __('Title') }}</label>
                            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" />
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="players">{{ __('Players') }}</label>
                            <textarea name="players" rows="10" class="form-control @error('players') is-invalid @enderror" aria-describedby="playersHelp">{{ old('players') }}</textarea>
                            @error('players')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <small id="playersHelp" class="form-text text-muted">
                                {{ __('Enter one player name per line') }}
                              </small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

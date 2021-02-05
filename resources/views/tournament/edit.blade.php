@extends('layouts.app')

@section('content')
<div class="container">

    <form method="POST" action="{{ route('tournament.edit.save', [ 'id' => $tournament->id ]) }}">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">{{ __('Title') }}</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ !!old('title') ? old('title') : $tournament->title }}" />
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="players">{{ __('Players') }}</label>
            <textarea name="players" rows="10" class="form-control @error('players') is-invalid @enderror" aria-describedby="playersHelp">{{ !!old('title') ? old('title') : $tournament->players->map->name->sort()->implode("\n") }}</textarea>
            @error('players')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <small id="playersHelp" class="form-text text-muted">
                {{ __('Enter one player name per line') }}
              </small>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <a class="btn btn-primary" href="{{ route('tournaments') }}">{{ __('Back') }}</a>
    </form>

</div>
@endsection

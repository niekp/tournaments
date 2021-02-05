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
        
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <a class="btn btn-primary" href="{{ route('tournaments') }}">{{ __('Back') }}</a>
    </form>

</div>
@endsection

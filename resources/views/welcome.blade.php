@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>{{ __('Tournament maker') }}</h1>
    <p class="lead">{{ __('Create tournaments and keep track of scores') }}</p>
    <p class="lead">
      @guest
      <a href="{{ route('register') }}" class="btn btn-lg btn-primary">{{ __('Create an account') }}</a>
      @else
      <a href="{{ route('tournaments') }}" class="btn btn-lg btn-primary">{{ __('Create tournaments') }}</a>
      @endguest
    </p>
  </div>
@endsection

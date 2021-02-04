@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tournaments') }}</div>

                <div class="card-body">
                    - Toon lopende tournamenten
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">{{ __('Start new tournament') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tournament.new') }}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('Title') }}</label>
                            <input type="text" name="title" class="form-control" />
                        </div>
                        
                        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

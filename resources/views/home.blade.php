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
                    Form
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

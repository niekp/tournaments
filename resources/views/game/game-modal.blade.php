<div class="modal" tabindex="-1" role="dialog" data-game-modal>
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('game.save', [ 'guid' => $game->tournament->guid, 'id' => $game->id ]) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Game :p1 - :p2', [ 'p1' => $game->player1->name, 'p2' => $game->player2->name]) }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                    <div class="form-group">
                        <label>{{ __('Score :name', ['name' => $game->player1->name]) }}</label>
                        <input type="text" name="scorePlayer1" class="form-control @error('scorePlayer1') is-invalid @enderror" value="{{ !!old('scorePlayer1') ? old('scorePlayer1') : $game->scorePlayer1 }}" />
                        @error('scorePlayer1')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('Score :name', ['name' => $game->player2->name]) }}</label>
                        <input type="text" name="scorePlayer2" class="form-control @error('scorePlayer2') is-invalid @enderror" value="{{ !!old('scorePlayer2') ? old('scorePlayer2') : $game->scorePlayer2 }}" />
                        @error('scorePlayer2')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
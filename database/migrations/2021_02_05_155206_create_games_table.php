<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('scorePlayer1')->nullable();
            $table->integer('scorePlayer2')->nullable();
            $table->unsignedBigInteger('player1_id');
            $table->unsignedBigInteger('player2_id');
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->foreignId('tournament_id')->constrained();
            $table->timestamps();

            $table->foreign('player1_id')->references('id')->on('players');
            $table->foreign('player2_id')->references('id')->on('players');
            $table->foreign('winner_id')->references('id')->on('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the user that created the tournament.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tournaments this player played in
     */
    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }

}

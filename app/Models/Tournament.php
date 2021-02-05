<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    /**
     * Get the user that created the tournament.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

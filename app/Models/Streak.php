<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Streak extends Model
{
    protected $table = 'streaks';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

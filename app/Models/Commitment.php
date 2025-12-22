<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commitment extends Model
{
    protected $table = 'commitments';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}

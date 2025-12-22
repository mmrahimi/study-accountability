<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commitments()
    {
        return $this->hasMany(Commitment::class, 'subject_id');
    }
}

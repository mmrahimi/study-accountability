<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commitment extends Model
{
    use HasFactory;

    protected $table = 'commitments';

    public const STATUS_PENDING = 'pending';

    public const STATUS_CHECKED = 'checked';

    public const STATUS_MISSED = 'missed';

    public const STATUS_CANCELED = 'canceled';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}

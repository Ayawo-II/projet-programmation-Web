<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'user_id', 'votable_id', 'votable_type', 'value',
    ];

    // ── Relations ──────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation polymorphe : renvoie la Question ou la Answer associée
    public function votable()
    {
        return $this->morphTo();
    }
}
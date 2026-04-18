<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'user_id', 'title', 'body', 'is_solved', 'is_closed', 'views',
    ];

    protected $casts = [
        'is_solved' => 'boolean',
        'is_closed' => 'boolean',
    ];

    // ── Relations ──────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'question_tag');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    // ── Helpers ────────────────────────────────────────

    // Score total de votes (+1 et -1)
    public function voteScore(): int
    {
        return $this->votes()->sum('value');
    }

    // Le vote de l'utilisateur connecté sur cette question (-1, 0, +1)
    public function userVote(): int
    {
        if (!auth()->check()) return 0;
        $vote = $this->votes()->where('user_id', auth()->id())->first();
        return $vote ? $vote->value : 0;
    }
}
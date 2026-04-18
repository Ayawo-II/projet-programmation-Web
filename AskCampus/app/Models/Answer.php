<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'question_id', 'user_id', 'body', 'is_accepted',
    ];

    protected $casts = [
        'is_accepted' => 'boolean',
    ];

    // ── Relations ──────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    // ── Helpers ────────────────────────────────────────
    public function voteScore(): int
    {
        return $this->votes()->sum('value');
    }

    public function userVote(): int
    {
        if (!auth()->check()) return 0;
        $vote = $this->votes()->where('user_id', auth()->id())->first();
        return $vote ? $vote->value : 0;
    }
}
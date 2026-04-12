<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'notifiable_type',
        'notifiable_id',
        'read',
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function createForNewAnswer(Answer $answer): void
    {
        $question = $answer->question;
        
        // Notifier l'auteur de la question
        self::create([
            'user_id' => $question->user_id,
            'type' => 'new_answer',
            'message' => "{$answer->user->name} a répondu à votre question",
            'notifiable_type' => Question::class,
            'notifiable_id' => $question->id,
        ]);
    }

    public static function createForAcceptedAnswer(Answer $answer): void
    {
        // Notifier l'auteur de la réponse
        self::create([
            'user_id' => $answer->user_id,
            'type' => 'answer_accepted',
            'message' => 'Votre réponse a été acceptée comme meilleure réponse',
            'notifiable_type' => Answer::class,
            'notifiable_id' => $answer->id,
        ]);
    }

    public static function createForDeletedContent(User $deletor, string $contentType, int $userId, string $message): void
    {
        // Notifier l'auteur du contenu supprimé (si c'est pas le modérateur lui-même)
        if ($userId !== $deletor->id) {
            self::create([
                'user_id' => $userId,
                'type' => 'content_deleted',
                'message' => "Votre {$contentType} a été supprimée par un modérateur: {$message}",
                'notifiable_type' => Question::class,
                'notifiable_id' => 0,
            ]);
        }
    }

    public function markAsRead(): void
    {
        if (!$this->read) {
            $this->update(['read' => true]);
        }
    }
}

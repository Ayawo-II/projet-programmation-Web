<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;

class AnswerPolicy
{
    /**
     * Uniquement l'auteur peut modifier sa réponse
     * Limitation: 30 minutes après création ou modérateur
     */
    public function update(User $user, Answer $answer): bool
    {
        // L'auteur peut éditer
        if ($user->id !== $answer->user_id) {
            // Sauf si modérateur
            return $user->isModerator();
        }

        // Impossible d'éditer si acceptée
        if ($answer->is_accepted) {
            return false;
        }

        // Vérifier la limite de 30 minutes
        $minutesElapsed = $answer->created_at->diffInMinutes(now());
        return $minutesElapsed <= 30;
    }

    /**
     * L'auteur ou modérateur peut supprimer
     */
    public function delete(User $user, Answer $answer): bool
    {
        return $user->id === $answer->user_id || $user->isModerator();
    }
}

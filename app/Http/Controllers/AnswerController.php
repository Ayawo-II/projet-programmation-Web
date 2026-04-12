<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerStoreRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AnswerController extends Controller
{
    /**
     * Enregistrer une nouvelle réponse
     */
    public function store(AnswerStoreRequest $request, Question $question): RedirectResponse
    {
        $answer = Answer::create([
            'question_id' => $question->id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        // Créer une notification pour l'auteur de la question
        Notification::createForNewAnswer($answer);

        return redirect()->route('questions.show', $question)
            ->with('success', 'Votre réponse a été publiée avec succès.');
    }

    /**
     * Modifier une réponse (max 30 minutes après création)
     */
    public function update(Request $request, Answer $answer): RedirectResponse
    {
        $this->authorize('update', $answer);

        $request->validate([
            'body' => ['required', 'string', 'min:20'],
        ]);

        // Vérification supplémentaire
        if ($answer->is_accepted) {
            return redirect()->route('questions.show', $answer->question)
                ->with('error', 'Impossible de modifier une réponse acceptée.');
        }

        // Vérifier la limite de 30 minutes
        $minutesElapsed = $answer->created_at->diffInMinutes(now());
        if ($minutesElapsed > 30 && !Auth::user()->isModerator()) {
            return redirect()->route('questions.show', $answer->question)
                ->with('error', 'Délai d\'édition dépassé (30 minutes max pour les étudiants).');
        }

        $answer->update([
            'body' => $request->body,
        ]);

        return redirect()->route('questions.show', $answer->question)
            ->with('success', 'Votre réponse a été modifiée.');
    }

    /**
     * Supprimer une réponse
     */
    public function destroy(Answer $answer): RedirectResponse
    {
        $this->authorize('delete', $answer);

        $question = $answer->question;

        // Impossible de supprimer si acceptée
        if ($answer->is_accepted) {
            return redirect()->route('questions.show', $question)
                ->with('error', 'Impossible de supprimer une réponse acceptée.');
        }

        $answer->delete();

        // Réduire la réputation
        $answer->user->updateReputation();

        return redirect()->route('questions.show', $question)
            ->with('success', 'Votre réponse a été supprimée.');
    }
}

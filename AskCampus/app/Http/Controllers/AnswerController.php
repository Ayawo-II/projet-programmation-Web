<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    // ── Poster une réponse ─────────────────────────────
    public function store(Request $request, Question $question)
    {
        if ($question->is_closed) {
            return back()->with('error', 'Cette question est fermée, impossible de répondre.');
        }

        $request->validate([
            'body' => 'required|string|min:20',
        ], [
            'body.min' => 'Votre réponse doit faire au moins 20 caractères.',
        ]);

        $question->answers()->create([
            'user_id' => auth()->id(),
            'body'    => $request->body,
        ]);

        // +2 de réputation pour avoir répondu
        auth()->user()->increment('reputation', 2);

        return redirect()
            ->route('questions.show', $question)
            ->with('success', 'Votre réponse a été ajoutée !');
    }

    // ── Accepter une réponse ───────────────────────────
    public function accept(Answer $answer)
    {
        $question = $answer->question;

        // Seul l'auteur de la question peut accepter
        if (auth()->id() !== $question->user_id) {
            abort(403);
        }

        // Désaccepter toutes les autres réponses
        $question->answers()->update(['is_accepted' => false]);

        // Accepter celle-ci
        $answer->update(['is_accepted' => true]);

        // Marquer la question comme résolue
        $question->update(['is_solved' => true]);

        // +15 de réputation pour l'auteur de la réponse acceptée
        $answer->user->increment('reputation', 15);

        return redirect()
            ->route('questions.show', $question)
            ->with('success', 'Meilleure réponse sélectionnée !');
    }

    // ── Supprimer sa propre réponse ────────────────────
    public function destroy(Answer $answer)
    {
        if (auth()->id() !== $answer->user_id) {
            abort(403);
        }

        $question = $answer->question;
        $answer->delete();

        return redirect()
            ->route('questions.show', $question)
            ->with('success', 'Réponse supprimée.');
    }
}
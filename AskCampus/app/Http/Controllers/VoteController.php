<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(Request $request, string $type, int $id)
    {
        // Valider le type et la valeur
        $request->validate([
            'value' => 'required|in:-1,1',
        ]);

        // Récupérer le modèle selon le type
        $votable = match ($type) {
            'question' => Question::findOrFail($id),
            'answer'   => Answer::findOrFail($id),
            default    => abort(404),
        };

        // Empêcher de voter pour son propre contenu
        if ($votable->user_id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas voter pour votre propre contenu.');
        }

        $value = (int) $request->value;

        // Chercher un vote existant
        $existingVote = Vote::where('user_id', auth()->id())
            ->where('votable_id', $id)
            ->where('votable_type', get_class($votable))
            ->first();

        if ($existingVote) {
            if ($existingVote->value === $value) {
                // Même vote → on annule (toggle)
                $existingVote->delete();
                // Annuler la réputation
                $votable->user->decrement('reputation', $value > 0 ? 5 : -2);
            } else {
                // Vote opposé → on change
                $existingVote->update(['value' => $value]);
                // Ajuster la réputation (ex: était -1, devient +1 = +7)
                $votable->user->increment('reputation', $value > 0 ? 7 : -7);
            }
        } else {
            // Nouveau vote
            Vote::create([
                'user_id'      => auth()->id(),
                'votable_id'   => $id,
                'votable_type' => get_class($votable),
                'value'        => $value,
            ]);
            // Réputation : +5 pour upvote, -2 pour downvote
            $votable->user->increment('reputation', $value > 0 ? 5 : -2);
        }

        return back();
    }
}
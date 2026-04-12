<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Vote;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class VoteController extends Controller
{
    public function voteQuestion(Request $request, Question $question): RedirectResponse
    {
        $request->validate(['value' => ['required', 'integer', 'in:-1,1']]);

        $vote = Vote::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'votable_type' => Question::class,
                'votable_id' => $question->id,
            ],
            ['value' => $request->value]
        );

        $question->user->updateReputation();

        return back();
    }

    public function voteAnswer(Request $request, Answer $answer): RedirectResponse
    {
        $request->validate(['value' => ['required', 'integer', 'in:-1,1']]);

        $vote = Vote::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'votable_type' => Answer::class,
                'votable_id' => $answer->id,
            ],
            ['value' => $request->value]
        );

        $answer->user->updateReputation();

        return back();
    }

    public function acceptAnswer(Request $request, Answer $answer): RedirectResponse
    {
        $question = $answer->question;
        $user = $request->user();

        abort_unless($user->id === $question->user_id || $user->isModerator(), 403);

        $question->answers()->update(['is_accepted' => false]);
        $answer->update(['is_accepted' => true]);
        $question->update(['is_solved' => true]);

        $answer->user->updateReputation();

        // Créer une notification pour l'auteur de la réponse
        Notification::createForAcceptedAnswer($answer);

        return back();
    }
}

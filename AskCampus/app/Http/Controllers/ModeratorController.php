<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    public function index()
    {
        $questions = Question::with(['user', 'tags'])
            ->latest()
            ->paginate(20);

        return view('moderator.index', compact('questions'));
    }

    public function toggleClose(Question $question)
    {
        $question->update(['is_closed' => !$question->is_closed]);
        $status = $question->is_closed ? 'fermée' : 'rouverte';

        return back()->with('success', "Question {$status}.");
    }

    public function destroyQuestion(Question $question)
    {
        $question->delete();
        return back()->with('success', 'Question supprimée.');
    }

    public function destroyAnswer(Answer $answer)
    {
        $question = $answer->question;
        $answer->delete();

        return redirect()
            ->route('questions.show', $question)
            ->with('success', 'Réponse supprimée par le modérateur.');
    }
}
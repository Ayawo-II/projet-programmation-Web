<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user()->load([
            'questions' => fn($q) => $q->latest()->take(5),
            'answers'   => fn($q) => $q->latest()->take(5)->with('question'),
        ]);

        $totalVotesReceived = $user->questions->sum(fn($q) => $q->voteScore())
            + $user->answers->sum(fn($a) => $a->voteScore());

        return view('profile.show', compact('user', 'totalVotesReceived'));
    }
}
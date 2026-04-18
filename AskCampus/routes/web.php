<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ModeratorController;

// ── Page d'accueil ─────────────────────────────────────
Route::get('/', [QuestionController::class, 'index'])->name('home');

// ── Routes Breeze (login, register, etc.) ──────────────
require __DIR__.'/auth.php';

// Recherche AJAX pour suggestions (pas besoin d'être connecté)
Route::get('/api/questions/search', function (\Illuminate\Http\Request $request) {
    $q = $request->get('q', '');
    return \App\Models\Question::where('title', 'like', "%{$q}%")
        ->select('id', 'title')
        ->limit(5)
        ->get();
});

// ── Routes protégées (utilisateur connecté) ────────────
Route::middleware('auth')->group(function () {

    // Questions
    Route::resource('questions', QuestionController::class);

    // Réponses (pas de show/index propre, tout est dans la question)
    Route::post('questions/{question}/answers', [AnswerController::class, 'store'])
        ->name('answers.store');
    Route::delete('answers/{answer}', [AnswerController::class, 'destroy'])
        ->name('answers.destroy');
    Route::patch('answers/{answer}/accept', [AnswerController::class, 'accept'])
        ->name('answers.accept');

    // Votes (polymorphe)
    Route::post('votes/{type}/{id}', [VoteController::class, 'store'])
        ->name('votes.store');

    // Profil
    Route::get('profile', [ProfileController::class, 'show'])
        ->name('profile.show');

    // ── Routes Modérateur uniquement ───────────────────
    Route::middleware('moderator')->group(function () {
        Route::get('moderator', [ModeratorController::class, 'index'])
            ->name('moderator.index');

        // Fermer / rouvrir une question
        Route::patch('questions/{question}/toggle-close', [ModeratorController::class, 'toggleClose'])
            ->name('moderator.toggleClose');

        // Supprimer une question (modérateur)
        Route::delete('moderator/questions/{question}', [ModeratorController::class, 'destroyQuestion'])
            ->name('moderator.destroyQuestion');

        // Supprimer une réponse (modérateur)
        Route::delete('moderator/answers/{answer}', [ModeratorController::class, 'destroyAnswer'])
            ->name('moderator.destroyAnswer');

        // Gestion des tags
        Route::resource('tags', TagController::class)
            ->except(['show']);
    });
});
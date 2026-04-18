<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // ── Liste des questions (page d'accueil) ───────────
    public function index(Request $request)
    {
        $query = Question::with(['user', 'tags'])
            ->withCount('answers');

        // Recherche par mot-clé
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        // Filtre par tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        // Tri
        $sort = $request->get('sort', 'recent');
        match ($sort) {
            'votes'    => $query->withSum('votes', 'value')->orderByDesc('votes_sum_value'),
            'unsolved' => $query->where('is_solved', false)->latest(),
            default    => $query->latest(),
        };

        $questions = $query->paginate(15)->withQueryString();
        $tags      = Tag::orderBy('name')->get();

        return view('questions.index', compact('questions', 'tags', 'sort'));
    }

    // ── Formulaire de création ─────────────────────────
    public function create()
    {
        $tags = Tag::orderBy('name')->get();
        return view('questions.create', compact('tags'));
    }

    // ── Enregistrer une nouvelle question ──────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:15|max:255',
            'body'  => 'required|string|min:30',
            'tags'  => 'required|array|min:1|max:5',
            'tags.*'=> 'exists:tags,id',
        ], [
            'title.min'  => 'Le titre doit faire au moins 15 caractères. Soyez précis !',
            'body.min'   => 'La description doit faire au moins 30 caractères.',
            'tags.required' => 'Choisissez au moins un tag pour classer votre question.',
        ]);

        $question = Question::create([
            'user_id' => auth()->id(),
            'title'   => $validated['title'],
            'body'    => $validated['body'],
        ]);

        $question->tags()->attach($validated['tags']);

        return redirect()
            ->route('questions.show', $question)
            ->with('success', 'Votre question a été publiée !');
    }

    // ── Afficher une question ──────────────────────────
    public function show(Question $question)
    {
        // Incrémenter le compteur de vues
        $question->increment('views');

        // Charger les relations
        $question->load(['user', 'tags', 'votes']);

        // Réponses : acceptée en premier, puis par score décroissant
        $answers = $question->answers()
            ->with(['user', 'votes'])
            ->orderByDesc('is_accepted')
            ->withSum('votes', 'value')
            ->orderByDesc('votes_sum_value')
            ->get();

        return view('questions.show', compact('question', 'answers'));
    }

    // ── Formulaire d'édition ───────────────────────────
    public function edit(Question $question)
    {
        $this->authorize('update', $question);
        $tags = Tag::orderBy('name')->get();
        return view('questions.edit', compact('question', 'tags'));
    }

    // ── Mettre à jour une question ─────────────────────
    public function update(Request $request, Question $question)
    {
        $this->authorize('update', $question);

        $validated = $request->validate([
            'title' => 'required|string|min:15|max:255',
            'body'  => 'required|string|min:30',
            'tags'  => 'required|array|min:1|max:5',
            'tags.*'=> 'exists:tags,id',
        ]);

        $question->update([
            'title' => $validated['title'],
            'body'  => $validated['body'],
        ]);

        $question->tags()->sync($validated['tags']);

        return redirect()
            ->route('questions.show', $question)
            ->with('success', 'Question mise à jour.');
    }

    // ── Supprimer une question ─────────────────────────
    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);
        $question->delete();

        return redirect()
            ->route('home')
            ->with('success', 'Question supprimée.');
    }
}
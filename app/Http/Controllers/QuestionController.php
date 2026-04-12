<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionStoreRequest;
use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Str;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->query('search', ''));
        $selectedTag = $request->query('tag');

        $tags = Tag::orderBy('name')->get();

        $questions = Question::with(['user', 'tags'])
            ->when($search !== '', function ($query) use ($search) {
                $query->search($search);
            })
            ->when($selectedTag, function ($query, $selectedTag) {
                $query->whereHas('tags', function ($query) use ($selectedTag) {
                    $query->where('slug', $selectedTag);
                });
            })
            ->withCount('answers')
            ->withSum('votes as score', 'value')
            ->orderByDesc('score')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('questions.index', compact('questions', 'tags', 'search', 'selectedTag'));
    }

    public function create(): View
    {
        return view('questions.create', [
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function store(QuestionStoreRequest $request)
    {
        $question = Question::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        $tagIds = collect($request->tags)->filter()->map(function ($tag) {
            return Tag::firstOrCreate([
                'slug' => Str::slug($tag),
            ], [
                'name' => ucfirst(trim($tag)),
                'description' => null,
            ])->id;
        })->unique()->values()->all();

        $question->tags()->sync($tagIds);

        return redirect()->route('questions.show', $question)->with('success', 'Question créée avec succès.');
    }

    public function show(Question $question): View
    {
        $question->load(['user', 'tags', 'votes', 'answers.user', 'answers.votes']);

        $answers = $question->answers->sortByDesc(fn ($answer) => [$answer->is_accepted ? 1 : 0, $answer->score])->values();

        return view('questions.show', compact('question', 'answers'));
    }

    /**
     * API pour chercher les questions similaires par titre
     * Utilisé par JavaScript pour le debounce lors de la saisie
     */
    public function apiSimilar(Request $request)
    {
        $title = trim($request->query('title', ''));

        if (strlen($title) < 5) {
            return response()->json(['questions' => []]);
        }

        // Tokeniser le titre (mots principaux > 3 caractères)
        $words = array_filter(
            str_word_count(strtolower($title), 1),
            fn ($word) => strlen($word) > 3
        );

        // Si moins de 2 mots significatifs, pas de recherche
        if (count($words) < 2) {
            return response()->json(['questions' => []]);
        }

        // Construire la requête de recherche
        $query = Question::with(['user', 'tags'])->limit(5);

        // Chercher les questions avec au moins 2 mots du titre
        $words_like = array_map(fn ($word) => '%' . $word . '%', $words);
        
        $query->where(function ($q) use ($words_like) {
            foreach ($words_like as $word) {
                $q->orWhere('title', 'like', $word)
                  ->orWhere('body', 'like', $word);
            }
        });

        $similar = $query->orderByDesc('created_at')->get();

        return response()->json([
            'questions' => $similar->map(fn ($q) => [
                'id' => $q->id,
                'title' => $q->title,
                'excerpt' => Str::limit(strip_tags($q->body), 60),
                'is_solved' => $q->is_solved,
                'url' => route('questions.show', $q),
            ]),
        ]);
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        
        // Statistiques utilisateur
        $totalQuestions = $user->questions()->count();
        $totalAnswers = $user->answers()->count();
        $reputation = $user->reputation ?? 0;
        
        // Tendances mensuelles
        $currentMonth = now()->startOfMonth();
        
        $questionsThisMonth = $user->questions()
            ->where('created_at', '>=', $currentMonth)
            ->count();
        
        $questionsLastMonth = $user->questions()
            ->where('created_at', '>=', now()->subMonth()->startOfMonth())
            ->where('created_at', '<', $currentMonth)
            ->count();
        
        $answersThisMonth = $user->answers()
            ->where('created_at', '>=', $currentMonth)
            ->count();
        
        $answersLastMonth = $user->answers()
            ->where('created_at', '>=', now()->subMonth()->startOfMonth())
            ->where('created_at', '<', $currentMonth)
            ->count();
        
        $reputationLastMonth = max(0, $reputation - 50); // Estimation approximative
        $reputationGain = $reputation - $reputationLastMonth;
        $impactTrend = $reputationLastMonth > 0 
            ? round((($reputationGain / $reputationLastMonth) * 100))
            : ($reputationGain > 0 ? 100 : 0);
        
        // Calcul du niveau de réputation (gamification)
        $reputationLevels = [
            100 => 'Novice',
            300 => 'Contributeur',
            600 => 'Expert',
            1000 => 'Mentor',
            1500 => 'Sage',
        ];
        
        $level = 'Novice';
        foreach ($reputationLevels as $threshold => $levelName) {
            if ($reputation >= $threshold) {
                $level = $levelName;
            }
        }
        
        // Activité sur 7 jours
        $activityTimeline = collect();
        for ($days = 6; $days >= 0; $days--) {
            $date = now()->subDays($days);
            $questions = $user->questions()->whereDate('created_at', $date->toDateString())->count();
            $answers = $user->answers()->whereDate('created_at', $date->toDateString())->count();

            $activityTimeline->push([
                'label' => $date->format('D'),
                'date' => $date->format('d/m'),
                'questions' => $questions,
                'answers' => $answers,
                'total' => $questions + $answers,
            ]);
        }
        
        // Dernières questions avec compteurs
        $recentQuestions = $user->questions()
            ->with(['answers', 'votes'])
            ->orderByDesc('created_at')
            ->limit(3)
            ->get()
            ->map(function ($q) {
                return [
                    'id' => $q->id,
                    'title' => $q->title,
                    'answers_count' => $q->answers->count(),
                    'votes' => $q->score,
                    'is_solved' => $q->is_solved,
                    'created_at' => $q->created_at->format('d M Y'),
                ];
            });
        
        // Questions non répondues
        $unansweredQuestions = $user->questions()
            ->withCount('answers')
            ->having('answers_count', 0)
            ->orderByDesc('created_at')
            ->count();
        
        // Tags populaires sur la plateforme
        $popularTags = Tag::withCount('questions')
            ->orderByDesc('questions_count')
            ->limit(6)
            ->get()
            ->map(fn($tag) => [
                'name' => $tag->name,
                'slug' => $tag->slug,
                'count' => $tag->questions_count,
            ]);
        
        // Notifications non lues
        $unreadNotifications = $user->notifications()
            ->where('read', false)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn($n) => [
                'id' => $n->id,
                'type' => $n->type,
                'message' => $n->message,
                'created_at' => $n->created_at->diffForHumans(),
            ]);
        
        $unreadCount = $user->notifications()->where('read', false)->count();

        return view('dashboard', [
            'user' => $user,
            'totalQuestions' => $totalQuestions,
            'questionsThisMonth' => $questionsThisMonth,
            'totalAnswers' => $totalAnswers,
            'answersThisMonth' => $answersThisMonth,
            'reputation' => $reputation,
            'level' => $level,
            'impactTrend' => $impactTrend,
            'activityTimeline' => $activityTimeline,
            'recentQuestions' => $recentQuestions,
            'unansweredQuestions' => $unansweredQuestions,
            'popularTags' => $popularTags,
            'unreadNotifications' => $unreadNotifications,
            'unreadCount' => $unreadCount,
        ]);
    }
}

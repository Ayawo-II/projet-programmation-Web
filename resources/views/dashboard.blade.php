<x-app-layout>
<div>
    <style>
        * { box-sizing: border-box; }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }

        :root {
            --primary: #00d4ff;
            --primary-dark: #0099cc;
            --bg-dark: #0a0e27;
            --bg-card: #131b3e;
            --bg-hover: #1a2555;
            --border: #2d3a5c;
            --text-main: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --accent-purple: #a855f7;
            --accent-red: #ef4444;
            --accent-green: #10b981;
        }

        body {
            background: var(--bg-dark);
            color: var(--text-main);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        /* Main Layout */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            background: var(--bg-dark);
        }

        /* Sidebar */
        .sidebar {
            width: 14rem;
            background: linear-gradient(135deg, var(--bg-card) 0%, var(--bg-dark) 100%);
            border-right: 1px solid var(--border);
            position: fixed;
            height: 100vh;
            z-index: 50;
            overflow-y: auto;
            padding: 2rem 0;
            left: 0;
            top: 0;
        }

        .sidebar-brand {
            padding: 0 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand-icon {
            width: 2rem;
            height: 2rem;
            background: linear-gradient(135deg, var(--primary), var(--accent-purple));
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1rem;
        }

        .sidebar-brand-text {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-main);
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            padding: 0 0.75rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .nav-item:hover {
            background: rgba(0, 212, 255, 0.1);
            color: var(--primary);
            padding-left: 1.25rem;
        }

        .nav-item.active {
            background: rgba(0, 212, 255, 0.15);
            color: var(--primary);
            border-left: 3px solid var(--primary);
            padding-left: calc(1rem - 3px);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 14rem;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .topbar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-left h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 0.25rem;
            color: var(--text-main);
        }

        .topbar-left p {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin: 0;
        }

        .topbar-right {
            text-align: right;
            color: var(--text-muted);
        }

        .topbar-right-date {
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .topbar-right-time {
            color: var(--text-main);
            font-weight: 600;
            font-size: 1rem;
        }

        /* Content Area */
        .content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        /* KPI Cards Grid */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .kpi-card {
            background: linear-gradient(135deg, var(--bg-card) 0%, rgba(0, 212, 255, 0.05) 100%);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), rgba(0, 212, 255, 0.5));
        }

        .kpi-card:hover {
            border-color: var(--primary);
            box-shadow: 0 8px 24px rgba(0, 212, 255, 0.1);
            transform: translateY(-2px);
        }

        .kpi-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .kpi-label {
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .kpi-value {
            color: var(--text-main);
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }

        .kpi-change {
            font-size: 0.8125rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .kpi-change.positive {
            color: var(--accent-green);
        }

        .kpi-change.negative {
            color: var(--accent-red);
        }

        .kpi-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: rgba(0, 212, 255, 0.1);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        /* Charts Grid */
        .charts-grid {
            display: grid;
            grid-template-columns: 1fr;
            md: grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: linear-gradient(135deg, var(--bg-card) 0%, rgba(0, 212, 255, 0.03) 100%);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            border-color: var(--primary);
            box-shadow: 0 8px 24px rgba(0, 212, 255, 0.08);
        }

        .chart-card-header {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chart-controls {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8rem;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-secondary);
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-sm:hover {
            background: rgba(0, 212, 255, 0.1);
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-sm.active {
            background: var(--primary);
            color: var(--bg-dark);
            border-color: var(--primary);
        }

        /* Stats Box */
        .stats-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .stat-item {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.1) 0%, rgba(168, 85, 247, 0.05) 100%);
            border: 1px solid var(--border);
            border-radius: 0.625rem;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(0, 212, 255, 0.08);
        }

        .stat-label {
            font-size: 0.8125rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
        }

        /* Table */
        .table-card {
            background: linear-gradient(135deg, var(--bg-card) 0%, rgba(0, 212, 255, 0.03) 100%);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .table-card-header {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 1.5rem;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
            min-width: 600px;
        }

        .table thead {
            background: rgba(0, 212, 255, 0.05);
            border-bottom: 2px solid var(--border);
        }

        .table th {
            padding: 1rem;
            text-align: left;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.8125rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            color: var(--text-secondary);
        }

        .table tbody tr:hover {
            background: rgba(0, 212, 255, 0.05);
        }

        .table a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .table a:hover {
            color: var(--text-main);
            text-decoration: underline;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.8125rem;
            font-weight: 500;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.15);
            color: var(--accent-green);
        }

        .badge-warning {
            background: rgba(234, 179, 8, 0.15);
            color: #facc15;
        }

        .badge-accent {
            background: rgba(0, 212, 255, 0.15);
            color: var(--primary);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-muted);
        }

        .empty-state p {
            margin: 0 0 1rem;
        }

        .empty-state a {
            color: var(--primary);
            text-decoration: none;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 14rem;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .content {
                padding: 1rem;
            }

            .topbar {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .topbar-right {
                text-align: left;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .kpi-grid {
                grid-template-columns: 1fr 1fr;
            }

            .stats-box {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 12rem;
            }

            .sidebar-brand-text {
                display: none;
            }

            .kpi-grid {
                grid-template-columns: 1fr;
            }

            .kpi-value {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Brand -->
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">ðŸ“š</div>
                <div class="sidebar-brand-text">AskCampus</div>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <a href="#" class="nav-item active">
                    <i class="fas fa-chart-line"></i>
                    <span>Tableau de Bord</span>
                </a>
                <a href="{{ route('questions.index') }}" class="nav-item">
                    <i class="fas fa-question-circle"></i>
                    <span>Questions</span>
                </a>
                <a href="{{ route('questions.create') }}" class="nav-item">
                    <i class="fas fa-plus-circle"></i>
                    <span>Nouvelle Question</span>
                </a>
                <a href="{{ route('notifications.index') }}" class="nav-item" style="position: relative;">
                    <i class="fas fa-bell"></i>
                    <span>Notifications</span>
                    @if($unreadCount > 0)
                        <span style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: var(--accent-red); color: white; font-size: 0.65rem; padding: 0.125rem 0.375rem; border-radius: 9999px; font-weight: 600;">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-item">
                    <i class="fas fa-user"></i>
                    <span>Profil</span>
                </a>
            </nav>

            <!-- Profile Card -->
            <div style="padding: 1.5rem 0.75rem; border-top: 1px solid var(--border); margin-top: auto;">
                <div style="background: rgba(0, 212, 255, 0.1); border: 1px solid var(--border); border-radius: 0.625rem; padding: 1rem; margin: 0 0.75rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                        <div style="width: 2rem; height: 2rem; background: linear-gradient(135deg, var(--primary), var(--accent-purple)); border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">ðŸ‘¤</div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.125rem;">Profil</div>
                            <div style="font-weight: 600; color: var(--text-main); font-size: 0.875rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $user->name }}</div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 0.5rem; font-size: 0.75rem;">
                        <span class="badge-accent">{{ $level }}</span>
                        <span class="badge-accent">{{ $reputation }}pts</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="topbar">
                <div class="topbar-left">
                    <h2>Tableau de Bord</h2>
                    <p>Bienvenue {{ $user->name }}! ðŸ‘‹</p>
                </div>
                <div class="topbar-right">
                    <div class="topbar-right-date">Aujourd'hui</div>
                    <div class="topbar-right-time">{{ now()->format('d M Y') }}</div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                <!-- KPI Cards -->
                <div class="kpi-grid">
                    <!-- Questions PosÃ©es -->
                    <div class="kpi-card">
                        <div class="kpi-header">
                            <div>
                                <div class="kpi-label">Questions PosÃ©es</div>
                                <div class="kpi-value">{{ $totalQuestions }}</div>
                            </div>
                            <div class="kpi-icon">ðŸ“</div>
                        </div>
                        <div class="kpi-change positive">
                            <i class="fas fa-arrow-up"></i> {{ $questionsThisMonth }} ce mois
                        </div>
                    </div>

                    <!-- RÃ©ponses DonnÃ©es -->
                    <div class="kpi-card">
                        <div class="kpi-header">
                            <div>
                                <div class="kpi-label">RÃ©ponses DonnÃ©es</div>
                                <div class="kpi-value">{{ $totalAnswers }}</div>
                            </div>
                            <div class="kpi-icon">ðŸ’¡</div>
                        </div>
                        <div class="kpi-change positive">
                            <i class="fas fa-arrow-up"></i> {{ $answersThisMonth }} ce mois
                        </div>
                    </div>

                    <!-- RÃ©putation -->
                    <div class="kpi-card">
                        <div class="kpi-header">
                            <div>
                                <div class="kpi-label">RÃ©putation</div>
                                <div class="kpi-value">{{ $reputation }}</div>
                            </div>
                            <div class="kpi-icon">â­</div>
                        </div>
                        <div class="kpi-change" style="color: var(--accent-purple);">
                            Niveau {{ $level }}
                        </div>
                    </div>

                    <!-- Tendance Impact -->
                    <div class="kpi-card">
                        <div class="kpi-header">
                            <div>
                                <div class="kpi-label">Tendance Impact</div>
                                <div class="kpi-value">{{ $impactTrend >= 0 ? '+' : '' }}{{ $impactTrend }}%</div>
                            </div>
                            <div class="kpi-icon">ðŸ†</div>
                        </div>
                        <div class="kpi-change {{ $impactTrend >= 0 ? 'positive' : 'negative' }};">
                            <i class="fas fa-arrow-{{ $impactTrend >= 0 ? 'up' : 'down' }}"></i> vs mois dernier
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="charts-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                    <!-- Activity Chart -->
                    <div class="chart-card">
                        <div class="chart-card-header">
                            <span>ActivitÃ© RÃ©cente</span>
                            <div class="chart-controls">
                                <button class="btn-sm active">Semaine</button>
                                <button class="btn-sm">Mois</button>
                            </div>
                        </div>
                        <div style="position: relative; height: 300px; width: 100%; overflow-x: auto;">
                            <canvas id="activityChart" style="width: 100%; max-width: 100%;"></canvas>
                        </div>
                    </div>

                    <!-- Stats Column -->
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <!-- Questions Statistics -->
                        <div class="chart-card">
                            <div class="chart-card-header" style="margin-bottom: 1rem;">Statistiques</div>
                            <div class="stats-box">
                                <div class="stat-item">
                                    <div class="stat-label">En Attente</div>
                                    <div class="stat-value">{{ $unansweredQuestions }}</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-label">RÃ©solues</div>
                                    <div class="stat-value">{{ $totalQuestions - $unansweredQuestions }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Notifications Preview -->
                        <div class="chart-card">
                            <div class="chart-card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <span>Notifications</span>
                                <span class="badge-accent">{{ $unreadCount }}</span>
                            </div>
                            @if($unreadNotifications->isNotEmpty())
                                @foreach($unreadNotifications->take(2) as $notif)
                                    <div style="padding: 0.75rem; background: rgba(0, 212, 255, 0.05); border-radius: 0.5rem; margin-bottom: 0.5rem; font-size: 0.8125rem; border-left: 3px solid var(--primary); overflow: hidden;">
                                        <div style="display: flex; gap: 0.5rem;">
                                            <span style="flex-shrink: 0;">
                                                @if($notif['type'] === 'new_answer') ðŸ’¬ @elseif($notif['type'] === 'answer_accepted') âœ… @else ðŸ—‘ï¸ @endif
                                            </span>
                                            <div style="flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                {{ $notif['message'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p style="color: var(--text-muted); text-align: center; font-size: 0.875rem; margin: 0;">Aucune notification</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Questions Table -->
                <div class="table-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <div class="table-card-header" style="margin-bottom: 0;">Mes DerniÃ¨res Questions</div>
                        <a href="{{ route('questions.index') }}?user={{ $user->id }}" style="color: var(--primary); text-decoration: none; font-size: 0.875rem;">Voir tout â†’</a>
                    </div>

                    @if($recentQuestions->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th style="text-align: center;">RÃ©ponses</th>
                                        <th style="text-align: center;">Votes</th>
                                        <th style="text-align: center;">Statut</th>
                                        <th style="text-align: center;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentQuestions as $q)
                                        <tr>
                                            <td>
                                                <a href="{{ route('questions.show', ['question' => $q['id']]) }}" style="display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    {{ $q['title'] }}
                                                </a>
                                            </td>
                                            <td style="text-align: center;">{{ $q['answers_count'] }}</td>
                                            <td style="text-align: center;">{{ $q['votes'] }}</td>
                                            <td style="text-align: center;">
                                                @if($q['is_solved'])
                                                    <span class="badge badge-success">âœ“ RÃ©solu</span>
                                                @else
                                                    <span class="badge badge-warning">â³ Attente</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center;">{{ $q['created_at'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <p>Vous n'avez pas encore posÃ© de question</p>
                            <a href="{{ route('questions.create') }}">Poser votre premiÃ¨re question â†’</a>
                        </div>
                    @endif
                </div>

                <!-- Popular Tags -->
                <div class="chart-card">
                    <div class="chart-card-header">ðŸ·ï¸ Tags Populaires</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                        @forelse($popularTags as $tag)
                            <a href="{{ route('questions.index') }}?tag={{ $tag['slug'] }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: rgba(0, 212, 255, 0.1); border: 1px solid var(--border); border-radius: 9999px; text-decoration: none; color: var(--text-secondary); font-size: 0.875rem; transition: all 0.3s ease;"
                                onmouseover="this.style.background='rgba(0, 212, 255, 0.2)'; this.style.borderColor='var(--primary)'; this.style.color='var(--primary)';"
                                onmouseout="this.style.background='rgba(0, 212, 255, 0.1)'; this.style.borderColor='var(--border)'; this.style.color='var(--text-secondary)';">
                                <span>{{ $tag['name'] }}</span>
                                <span style="background: rgba(0, 212, 255, 0.3); padding: 0 0.375rem; border-radius: 0.25rem; font-size: 0.75rem;">{{ $tag['count'] }}</span>
                            </a>
                        @empty
                            <p style="color: var(--text-muted);">Aucun tag disponible</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('activityChart');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const labels = {!! json_encode($activityTimeline->pluck('label')) !!};
            const questions = {!! json_encode($activityTimeline->pluck('questions')) !!};
            const answers = {!! json_encode($activityTimeline->pluck('answers')) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Questions',
                            data: questions,
                            borderColor: '#00d4ff',
                            backgroundColor: 'rgba(0, 212, 255, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#00d4ff',
                            pointBorderColor: '#0a0e27',
                            pointBorderWidth: 2,
                        },
                        {
                            label: 'RÃ©ponses',
                            data: answers,
                            borderColor: '#a855f7',
                            backgroundColor: 'rgba(168, 85, 247, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#a855f7',
                            pointBorderColor: '#0a0e27',
                            pointBorderWidth: 2,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: { color: '#94a3b8', font: { size: 12 } }
                        },
                        filler: { propagate: true }
                    },
                    scales: {
                        y: {
                            grid: { color: 'rgba(45, 58, 92, 0.3)' },
                            ticks: { color: '#94a3b8' },
                            beginAtZero: true
                        },
                        x: {
                            grid: { color: 'rgba(45, 58, 92, 0.3)' },
                            ticks: { color: '#94a3b8' }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
  
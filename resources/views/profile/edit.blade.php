<x-app-layout>
    @php
        $user = Auth::user();
        $initials = collect(explode(' ', trim($user->name ?? 'Dosseh')))->filter()->map(fn($part) => strtoupper(substr($part, 0, 1)))->take(2)->join('');
    @endphp

    <style>
        .profile-shell {
            min-height: 100vh;
            width: 100%;
            color: #fff;
            position: relative;
            overflow: hidden;
            background: radial-gradient(circle at top left, rgba(255,255,255,0.08), transparent 22%),
                        radial-gradient(circle at bottom right, rgba(124,58,237,0.18), transparent 18%),
                        linear-gradient(180deg, #0F0C29 0%, #1A1A3E 55%, #24243E 100%);
        }
        .profile-shell::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(90deg, rgba(255,255,255,0.04) 0, rgba(255,255,255,0.04) 1px, transparent 1px, transparent 40px),
                              repeating-linear-gradient(0deg, rgba(255,255,255,0.03) 0, rgba(255,255,255,0.03) 1px, transparent 1px, transparent 40px);
            opacity: 0.18;
            pointer-events: none;
        }
        .profile-shell::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 15%, rgba(255,255,255,0.08), transparent 16%),
                        radial-gradient(circle at 85% 10%, rgba(124,58,237,0.14), transparent 12%),
                        radial-gradient(circle at 80% 80%, rgba(56,189,248,0.12), transparent 18%);
            opacity: 0.75;
            pointer-events: none;
            mix-blend-mode: screen;
        }
        .profile-shell .profile-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 32px;
            max-width: 1500px;
            margin: 0 auto;
            padding: 40px 36px 60px;
        }
        .profile-sidebar {
            display: flex;
            flex-direction: column;
            gap: 28px;
            min-height: calc(100vh - 80px);
            padding: 32px 24px;
            border-radius: 32px;
            background: rgba(15, 15, 43, 0.68);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(18px);
            box-shadow: 0 40px 90px rgba(0,0,0,0.25);
        }
        .profile-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            font-weight: 700;
            background: linear-gradient(135deg, #f8fafc, #c4b5fd);
            -webkit-background-clip: text;
            color: transparent;
        }
        .profile-brand span {
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, #818cf8, #7c3aed);
        }
        .profile-sidebar .sidebar-subtitle {
            color: #b4b9d6;
            text-transform: uppercase;
            letter-spacing: 0.28em;
            font-size: 0.72rem;
        }
        .profile-nav {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .profile-nav a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            border-radius: 18px;
            color: #c8d2f5;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.25s ease;
            position: relative;
        }
        .profile-nav a:hover {
            background: rgba(124,58,237,0.16);
            color: #f8fafc;
        }
        .profile-nav a.active {
            background: linear-gradient(180deg, rgba(124,58,237,0.22), rgba(79,70,229,0.14));
            color: #fff;
        }
        .profile-nav a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 42px;
            border-radius: 999px;
            background: linear-gradient(180deg, #818cf8, #7c3aed);
        }
        .profile-nav i {
            width: 22px;
            text-align: center;
            font-size: 1rem;
        }
        .profile-divider {
            border-top: 1px solid rgba(255,255,255,0.08);
            margin: 18px 0;
        }
        .profile-user-card {
            border-radius: 28px;
            padding: 24px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(20px);
        }
        .profile-user-card .avatar {
            width: 68px;
            height: 68px;
            border-radius: 24px;
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 1.25rem;
            background: linear-gradient(135deg, #7c3aed, #818cf8);
            color: #fff;
        }
        .profile-user-card p {
            color: #cbd5e8;
        }
        .profile-user-card .user-name {
            margin-top: 14px;
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
        }
        .profile-user-card .user-email {
            margin-top: 4px;
            color: #94a3b8;
            font-size: 0.92rem;
        }
        .profile-user-card .dropdown {
            margin-top: 18px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #dbe2ff;
            font-weight: 600;
        }
        .profile-main {
            display: flex;
            flex-direction: column;
            gap: 28px;
        }
        .profile-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
            padding: 32px 36px;
            border-radius: 32px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            box-shadow: 0 35px 70px rgba(0,0,0,0.18);
        }
        .profile-head h1 {
            margin: 0;
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.4rem, 2.8vw, 3.5rem);
            line-height: 1;
            background: linear-gradient(135deg, #f8fafc, #c4b5fd);
            -webkit-background-clip: text;
            color: transparent;
        }
        .profile-head p {
            max-width: 720px;
            margin-top: 16px;
            color: #c4c9e8;
            line-height: 1.8;
            font-size: 1rem;
        }
        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 999px;
            border: 1px solid rgba(124,58,237,0.32);
            background: rgba(124,58,237,0.18);
            color: #e0d7ff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-size: 0.82rem;
        }
        .profile-actions {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 16px;
        }
        .profile-actions .action-pill {
            padding: 12px 18px;
            border-radius: 999px;
            background: rgba(255,255,255,0.08);
            color: #e2e8f0;
            border: 1px solid rgba(255,255,255,0.08);
            font-weight: 600;
        }
        .profile-card,
        .glass-card,
        .stats-panel,
        .advice-panel {
            border-radius: 28px;
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(22px);
            background: rgba(255,255,255,0.06);
            box-shadow: 0 35px 80px rgba(0,0,0,0.16);
        }
        .profile-card {
            padding: 32px;
        }
        .profile-card .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 0.24em;
            color: #c4b5fd;
            font-size: 0.8rem;
        }
        .profile-card h2 {
            margin: 20px 0 12px;
            font-size: 2rem;
            color: #fff;
            line-height: 1.1;
        }
        .profile-card p {
            color: #b8bfd3;
            line-height: 1.8;
        }
        .form-group {
            margin-top: 28px;
        }
        .form-group label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: #d8ddeb;
            margin-bottom: 10px;
        }
        .input-field {
            position: relative;
        }
        .input-field input {
            width: 100%;
            padding: 16px 18px 16px 48px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.08);
            color: #f8fafc;
            font-size: 0.97rem;
            outline: none;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }
        .input-field input:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 6px rgba(129,140,248,0.12);
            background: rgba(255,255,255,0.11);
        }
        .input-field .field-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            display: grid;
            place-items: center;
            color: #a5b4fc;
        }
        .input-note {
            margin-top: 10px;
            color: #9ca3af;
            font-size: 0.88rem;
        }
        .btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 16px 30px;
            border-radius: 40px;
            border: none;
            background: linear-gradient(135deg, #7c3aed, #818cf8);
            color: #fff;
            font-weight: 700;
            letter-spacing: 0.02em;
            box-shadow: 0 18px 40px rgba(124,58,237,0.3);
            cursor: pointer;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 52px rgba(124,58,237,0.36);
        }
        .password-strength {
            margin-top: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #d8ddeb;
            font-size: 0.92rem;
        }
        .strength-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 78px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,0.08);
            color: #f8fafc;
            font-weight: 700;
        }
        .strength-weak { background: rgba(248,113,113,0.18); color: #fecaca; }
        .strength-medium { background: rgba(251,191,36,0.18); color: #facc15; }
        .strength-strong { background: rgba(34,197,94,0.18); color: #bef264; }
        .stats-panel {
            padding: 28px;
            background: linear-gradient(180deg, rgba(79,70,229,0.95), rgba(124,58,237,0.88));
        }
        .stats-panel h3 {
            margin: 0;
            color: #fff;
            font-size: 1.15rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .stats-panel p {
            margin-top: 8px;
            color: rgba(255,255,255,0.76);
            font-size: 0.95rem;
            line-height: 1.7;
        }
        .stats-grid {
            margin-top: 24px;
            display: grid;
            gap: 16px;
        }
        .stats-item {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 16px;
            padding: 18px 20px;
            border-radius: 24px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.16);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .stats-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 24px 50px rgba(0,0,0,0.16);
        }
        .stats-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            background: rgba(255,255,255,0.16);
            color: #fff;
            font-size: 1.1rem;
        }
        .stats-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 6px;
        }
        .stats-value {
            font-size: 1.55rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
        }
        .stats-label {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.2em;
            color: rgba(255,255,255,0.72);
        }
        .advice-panel {
            padding: 24px 26px;
            background: rgba(254,243,199,0.18);
            border: 1px solid rgba(245,158,11,0.18);
            color: #f8f6eb;
            backdrop-filter: blur(18px);
        }
        .advice-panel h4 {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin: 0;
            font-size: 1rem;
            color: #f59e0b;
        }
        .advice-panel p {
            margin-top: 14px;
            color: #f7ebd7;
            line-height: 1.8;
        }
        @media (max-width: 1220px) {
            .profile-shell .profile-grid { grid-template-columns: 1fr; padding: 32px 24px 48px; }
            .profile-sidebar { min-height: auto; }
        }
        @media (max-width: 900px) {
            .profile-head { flex-direction: column; }
        }
        @media (max-width: 720px) {
            .profile-shell::before,
            .profile-shell::after { opacity: 0.12; }
            .profile-head,
            .profile-card,
            .stats-panel,
            .advice-panel,
            .profile-sidebar { border-radius: 24px; }
            .profile-main { gap: 20px; }
        }
    </style>

    <div class="profile-shell">
        <div class="profile-grid">
            <aside class="profile-sidebar">
                <div>
                    <div class="profile-brand"><span></span>AskCampus</div>
                    <div class="sidebar-subtitle">Mon espace</div>
                </div>

                <nav class="profile-nav">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-chart-line"></i>Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}"><i class="fas fa-user-circle"></i>Profil</a>
                    <a href="{{ route('questions.create') }}" class="{{ request()->routeIs('questions.create') ? 'active' : '' }}"><i class="fas fa-question-circle"></i>Questions</a>
                    <a href="#" class=""><i class="fas fa-reply-all"></i>Réponses</a>
                    <a href="#" class=""><i class="fas fa-tags"></i>Sujets</a>
                    <a href="#" class=""><i class="fas fa-chart-pie"></i>Analytics</a>
                    <a href="#" class=""><i class="fas fa-clock"></i>Activité</a>
                </nav>

                <div class="profile-divider"></div>

                <div class="profile-user-card">
                    <div class="avatar">{{ $initials ?: 'DO' }}</div>
                    <div class="user-name">{{ $user->name ?? 'Dosseh' }}</div>
                    <div class="user-email">{{ $user->email ?? 'dossehapeti63@gmail.com' }}</div>
                    <div class="dropdown">Menu <i class="fas fa-chevron-down"></i></div>
                </div>
            </aside>

            <main class="profile-main">
                <section class="profile-head">
                    <div>
                        <p class="profile-badge">Étudiant</p>
                        <h1>Mon profil</h1>
                        <p>Gère tes informations personnelles, ton rôle et ta réputation avec un espace clair et moderne.</p>
                    </div>
                    <div class="profile-actions">
                        <div class="action-pill">DO</div>
                        <div class="action-pill">{{ $user->email ?? 'dossehapeti63@gmail.com' }}</div>
                    </div>
                </section>

                <div class="grid gap-8 lg:grid-cols-[1.8fr_1fr]">
                    <div class="space-y-8">
                        <section class="profile-card">
                            <div class="section-title">PROFIL UTILISATEUR</div>
                            <h2>{{ $user->name ?? 'Dosseh' }}</h2>
                            <p>Voici ton espace personnel AskCampus : mets à jour ton profil, améliore ta réputation et conserve un compte sécurisé.</p>
                        </section>

                        <section class="glass-card">
                            <div class="section-title">Informations de compte</div>
                            <h2>Met à jour ton identité</h2>
                            <p class="input-note">Mets à jour ton nom et ton email pour rester visible auprès de la communauté.</p>

                            <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
                                @csrf
                                @method('patch')

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <div class="input-field">
                                        <span class="field-icon"><i class="fas fa-user"></i></span>
                                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name" />
                                    </div>
                                    <div class="input-note">Nom complet affiché sur ton profil public.</div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-field">
                                        <span class="field-icon"><i class="fas fa-envelope"></i></span>
                                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                                    </div>
                                    <div class="input-note">Adresse utilisée pour te connecter et recevoir les notifications.</div>
                                </div>

                                <button type="submit" class="btn-save">Sauvegarder les informations</button>
                            </form>
                        </section>

                        <section class="glass-card">
                            <div class="section-title">Sécurité</div>
                            <h2>Change ton mot de passe</h2>
                            <p class="input-note">Change ton mot de passe régulièrement pour protéger ton compte AskCampus.</p>

                            <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
                                @csrf
                                @method('put')

                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <div class="input-field">
                                        <span class="field-icon"><i class="fas fa-lock"></i></span>
                                        <input id="current_password" name="current_password" type="password" autocomplete="current-password" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <div class="input-field">
                                        <span class="field-icon"><i class="fas fa-lock"></i></span>
                                        <input id="password" name="password" type="password" autocomplete="new-password" />
                                    </div>
                                    <div class="password-strength" id="passwordStrength">
                                        <span class="strength-pill strength-weak">Faible</span>
                                        <span class="input-note">Ton mot de passe doit être long et unique.</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <div class="input-field">
                                        <span class="field-icon"><i class="fas fa-check"></i></span>
                                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
                                    </div>
                                </div>

                                <button type="submit" class="btn-save">Sauvegarder le mot de passe</button>
                            </form>
                        </section>
                    </div>

                    <aside class="space-y-6">
                        <section class="stats-panel">
                            <h3>Statistiques</h3>
                            <p>Un aperçu instantané de ta réputation, de ton inscription et de ton rôle.</p>
                            <div class="stats-grid">
                                <div class="stats-item">
                                    <div class="stats-icon"><i class="fas fa-star"></i></div>
                                    <div class="stats-body">
                                        <div class="stats-value">{{ $user->reputation }}</div>
                                        <div class="stats-label">Réputation</div>
                                    </div>
                                </div>
                                <div class="stats-item">
                                    <div class="stats-icon"><i class="fas fa-calendar-alt"></i></div>
                                    <div class="stats-body">
                                        <div class="stats-value">{{ $user->created_at?->format('d/m/Y') ?? '—' }}</div>
                                        <div class="stats-label">Inscription</div>
                                    </div>
                                </div>
                                <div class="stats-item">
                                    <div class="stats-icon"><i class="fas fa-award"></i></div>
                                    <div class="stats-body">
                                        <div class="stats-value">{{ $user->display_role }}</div>
                                        <div class="stats-label">Rôle</div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="advice-panel">
                            <h4>💡 Conseil</h4>
                            <p>Choisis un nom clair et professionnel pour que les étudiants te reconnaissent facilement sur AskCampus.</p>
                        </section>
                    </aside>
                </div>
            </main>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordStrength = document.getElementById('passwordStrength');

        const strengthText = (score) => {
            if (score < 3) return { label: 'Faible', className: 'strength-weak' };
            if (score < 5) return { label: 'Moyen', className: 'strength-medium' };
            return { label: 'Fort', className: 'strength-strong' };
        };

        passwordInput?.addEventListener('input', (event) => {
            const value = event.target.value;
            let score = 0;
            if (value.length >= 8) score += 2;
            if (/[A-Z]/.test(value)) score += 1;
            if (/[0-9]/.test(value)) score += 1;
            if (/[^A-Za-z0-9]/.test(value)) score += 1;
            const result = strengthText(score);
            const pill = passwordStrength.querySelector('.strength-pill');
            pill.textContent = result.label;
            pill.className = `strength-pill ${result.className}`;
        });
    </script>
</x-app-layout>

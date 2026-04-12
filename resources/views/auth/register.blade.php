{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AskCampus') }} - Inscription</title>

    <!-- Local styling only, no external font CDN -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --primary-light: #818CF8;
            --secondary: #7C3AED;
            --secondary-light: #A78BFA;
            --accent: #06B6D4;
            --success: #10B981;
            --warning: #F59E0B;
            --error: #EF4444;
            --dark: #0F172A;
            --darker: #020617;
            --light: #F8FAFC;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, #0F0C29 0%, #1A1A3E 50%, #24243E 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        .bg-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.4), transparent);
            border-radius: 50%;
            animation: floatParticle linear infinite;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.5;
            }
            90% {
                opacity: 0.5;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 0;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .auth-wrapper {
            position: relative;
            width: 100%;
            max-width: 1080px;
            min-height: 660px;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(28px);
            border-radius: 42px;
            box-shadow: 0 24px 60px -24px rgba(0, 0, 0, 0.5), 
                        0 0 0 1px rgba(255, 255, 255, 0.08),
                        inset 0 1px 0 rgba(255, 255, 255, 0.05);
            overflow: hidden;
            z-index: 10;
        }

        .split-layout {
            display: flex;
            height: 100%;
            min-height: 750px;
            align-items: stretch;
        }

        .welcome-panel {
            flex: 1.05;
            background: linear-gradient(135deg, 
                rgba(79, 70, 229, 0.95) 0%, 
                rgba(124, 58, 237, 0.95) 50%, 
                rgba(6, 182, 212, 0.95) 100%);
            padding: 48px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .welcome-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, rgba(255,255,255,0.14) 0deg, rgba(255,255,255,0.04) 15deg, transparent 70deg, rgba(255,255,255,0.08) 110deg, transparent 160deg, rgba(255,255,255,0.1) 220deg, transparent 320deg);
            transform-origin: center center;
            animation: rotateBg 20s linear infinite;
        }

        @keyframes rotateBg {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .welcome-content {
            position: relative;
            z-index: 1;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 800;
            color: white;
            margin-bottom: 50px;
            letter-spacing: -0.02em;
            display: inline-block;
        }

        .logo span {
            font-weight: 400;
        }

        .welcome-title h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .welcome-title p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 1rem;
            line-height: 1.6;
            max-width: 90%;
        }

        .stats-container {
            display: flex;
            gap: 30px;
            margin: 40px 0;
            flex-wrap: wrap;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 20px 25px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            flex: 1;
            min-width: 100px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
        }

        .stat-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .quote-block {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .quote-icon {
            font-size: 2rem;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 15px;
        }

        .quote-text {
            font-size: 0.95rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            font-style: italic;
            margin-bottom: 10px;
        }

        .quote-author {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .form-panel {
            flex: 0.95;
            padding: 46px 36px 36px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: rgba(15, 23, 42, 0.92);
            border-left: 1px solid rgba(255, 255, 255, 0.08);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 0 50px rgba(0,0,0,0.18);
        }

        .form-panel::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 220px;
            height: 220px;
            background: radial-gradient(circle at 30% 30%, rgba(99, 102, 241, 0.28), transparent 55%);
            pointer-events: none;
        }

        .form-container {
            max-width: 360px;
            margin: 0 auto;
            width: 100%;
            padding-top: 8px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h2 {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #FFFFFF 0%, #A5B4FC 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .form-header p {
            color: var(--gray-400);
            font-size: 0.9rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 28px;
        }

        .input-group input {
            width: 100%;
            padding: 18px 48px 18px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-group input:focus-visible {
            outline: 3px solid rgba(79, 70, 229, 0.35);
            outline-offset: 3px;
        }

        .input-group input:focus {
            border-color: var(--primary);
            background: rgba(79, 70, 229, 0.1);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .input-group input:focus ~ label,
        .input-group input:not(:placeholder-shown) ~ label {
            top: 0;
            transform: translateY(-50%) scale(0.85);
            background: var(--dark);
            padding: 0 8px;
            color: var(--primary-light);
        }

        .input-group label {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            pointer-events: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .input-group .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .input-group input:focus ~ .input-icon {
            color: var(--primary);
        }

        .strength-bar {
            margin-top: 10px;
            height: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,0.1);
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0;
            border-radius: 999px;
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .checkbox span {
            color: var(--gray-400);
            font-size: 0.85rem;
        }

        .forgot-link,
        .sign-in-link a {
            color: var(--primary-light);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .forgot-link:hover,
        .sign-in-link a:hover,
        .forgot-link:focus-visible,
        .sign-in-link a:focus-visible {
            color: var(--primary);
            outline: none;
            text-decoration: underline;
        }

        .btn-login:focus-visible,
        .social-btn:focus-visible {
            outline: 3px solid rgba(79, 70, 229, 0.35);
            outline-offset: 4px;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 20px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -10px rgba(79, 70, 229, 0.5);
        }

        .btn-login.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-login.loading .btn-text {
            visibility: hidden;
        }

        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gray-600), transparent);
        }

        .divider-text {
            color: var(--gray-500);
            font-size: 0.8rem;
        }

        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .social-btn {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-300);
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            background: rgba(79, 70, 229, 0.2);
            border-color: var(--primary);
            transform: translateY(-3px) scale(1.05);
            color: white;
        }

        .social-btn.google:hover {
            background: rgba(234, 67, 53, 0.15);
            border-color: rgba(234, 67, 53, 0.45);
            color: #ffffff;
        }

        .social-btn.github:hover {
            background: rgba(113, 128, 150, 0.15);
            border-color: rgba(113, 128, 150, 0.45);
            color: #ffffff;
        }

        .social-btn.microsoft:hover {
            background: rgba(0, 120, 212, 0.18);
            border-color: rgba(0, 120, 212, 0.45);
            color: #ffffff;
        }

        .register-link {
            text-align: center;
            color: var(--gray-400);
            font-size: 0.9rem;
        }

        .sign-in-link {
            text-align: center;
            color: var(--gray-400);
            font-size: 0.9rem;
        }

        .alert-message {
            padding: 14px 18px;
            border-radius: 16px;
            font-size: 0.85rem;
            margin-bottom: 25px;
            animation: slideDown 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .alert-icon {
            margin-right: 10px;
            font-size: 1rem;
            vertical-align: middle;
            display: inline-flex;
            align-items: center;
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            font-weight: 700;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #FCA5A5;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6EE7B7;
        }

        @media (max-width: 1024px) {
            .split-layout {
                flex-direction: column;
            }
            
            .welcome-panel {
                padding: 40px;
                min-height: auto;
            }
            
            .welcome-title h1 {
                font-size: 2.5rem;
            }
            
            .stats-container {
                margin: 30px 0;
            }
            
            .form-panel {
                padding: 40px;
            }
        }

        @media (max-width: 640px) {
            .welcome-panel {
                padding: 30px;
            }
            
            .welcome-title h1 {
                font-size: 2rem;
            }
            
            .stats-container {
                gap: 15px;
            }
            
            .stat-card {
                padding: 15px;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            .form-panel {
                padding: 30px 20px;
            }
            
            .form-header h2 {
                font-size: 1.8rem;
            }
        }

        .animate-item {
            opacity: 1;
            transform: none;
        }
    </style>
</head>
<body>
    <div class="bg-particles" id="particles"></div>
    <div class="grid-overlay"></div>

    <div class="auth-wrapper" id="authWrapper">
        <div class="split-layout">
            <div class="welcome-panel">
                <div class="welcome-content">
                    <div class="logo animate-item">
                        Ask<span>Campus</span>
                    </div>
                    
                    <div class="welcome-title animate-item">
                        <h1>Rejoins AskCampus</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere, voluptatem.</p>
                    </div>
                    
                    <div class="stats-container">
                        <div class="stat-card animate-item">
                            <div class="stat-number" data-target="20">0</div>
                            <div class="stat-label">Membres engagés</div>
                        </div>
                        <div class="stat-card animate-item">
                            <div class="stat-number" data-target="12">0</div>
                            <div class="stat-label">Réponses partagées</div>
                        </div>
                        <div class="stat-card animate-item">
                            <div class="stat-number" data-target="95">0</div>
                            <div class="stat-label">Universités connectées</div>
                        </div>
                    </div>
                </div>
                
                <div class="quote-block animate-item">
                    <div class="quote-icon">“</div>
                    <div class="quote-text">
                        "Chaque échange nous rapproche de la réussite collective."
                    </div>
                    <div class="quote-author">
                        — Communauté AskCampus
                    </div>
                </div>
            </div>

            <div class="form-panel">
                <div class="form-container">
                    <div class="form-header animate-item">
                        <h2>Inscription</h2>
                        <p>Crée ton compte et commence à participer.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert-message alert-error animate-item">
                            @foreach ($errors->all() as $error)
                                <div><span class="alert-icon">⚠</span>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <div class="input-group animate-item">
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder=" " required autofocus>
                            <label>Nom complet</label>
                            <span class="input-icon">👤</span>
                        </div>

                        <div class="input-group animate-item">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder=" " required>
                            <label>Adresse email</label>
                            <span class="input-icon">✉</span>
                        </div>

                        <div class="input-group animate-item">
                            <input type="password" name="password" id="password" placeholder=" " required>
                            <label>Mot de passe</label>
                            <span class="input-icon">🔒</span>
                            <div class="strength-bar"><div id="strengthFill" class="strength-fill"></div></div>
                        </div>

                        <div class="input-group animate-item">
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder=" " required>
                            <label>Confirmation du mot de passe</label>
                            <span class="input-icon">🔒</span>
                        </div>

                        <button type="submit" class="btn-login animate-item" id="registerBtn">
                            <span class="btn-text">Créer mon compte</span>
                        </button>

                        <div class="divider animate-item">
                            <div class="divider-line"></div>
                            <span class="divider-text">ou</span>
                            <div class="divider-line"></div>
                        </div>

                        <div class="social-buttons animate-item">
                            @if(config('services.google.client_id') && config('services.google.client_secret'))
                                <a href="{{ route('social.login', ['provider' => 'google']) }}" class="social-btn google" aria-label="Connexion avec Google">
                                    <span class="social-icon">G</span>
                                </a>
                            @endif

                            @if(config('services.github.client_id') && config('services.github.client_secret'))
                                <a href="{{ route('social.login', ['provider' => 'github']) }}" class="social-btn github" aria-label="Connexion avec GitHub">
                                    <span class="social-icon">GH</span>
                                </a>
                            @endif

                            @if(config('services.microsoft.client_id') && config('services.microsoft.client_secret'))
                                <a href="{{ route('social.login', ['provider' => 'microsoft']) }}" class="social-btn microsoft" aria-label="Connexion avec Microsoft">
                                    <span class="social-icon">MS</span>
                                </a>
                            @endif
                        </div>

                        <div class="sign-in-link animate-item">
                            Tu as déjà un compte ?
                            <a href="{{ route('login') }}">Connexion</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            for (let i = 0; i < 60; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                const size = Math.random() * 6 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDuration = Math.random() * 10 + 8 + 's';
                particle.style.animationDelay = Math.random() * 5 + 's';
                particle.style.opacity = Math.random() * 0.5 + 0.1;
                particlesContainer.appendChild(particle);
            }
        }

        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                let current = 0;
                const increment = target / 50;
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.innerText = Math.floor(current) + (counter.innerText.includes('+') ? '+' : '');
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.innerText = target + (counter.innerText.includes('+') ? '+' : '');
                    }
                };
                updateCounter();
            });
        }

        function initPageAnimations() {
            document.body.classList.add('loaded');
        }

        const registerForm = document.getElementById('registerForm');
        const registerBtn = document.getElementById('registerBtn');
        const passwordInput = document.getElementById('password');
        const strengthFill = document.getElementById('strengthFill');

        passwordInput.addEventListener('input', function() {
            const strength = calculateStrength(this.value);
            strengthFill.style.width = `${strength}%`;
            if (strength < 40) {
                strengthFill.style.background = '#ef4444';
            } else if (strength < 75) {
                strengthFill.style.background = '#f59e0b';
            } else {
                strengthFill.style.background = '#10b981';
            }
        });

        function calculateStrength(password) {
            let score = 0;
            if (password.length >= 8) score += 35;
            if (/[A-Z]/.test(password)) score += 20;
            if (/[0-9]/.test(password)) score += 20;
            if (/[^A-Za-z0-9]/.test(password)) score += 25;
            return Math.min(score, 100);
        }

        registerForm.addEventListener('submit', function() {
            registerBtn.classList.add('loading');
        });

        document.querySelectorAll('.input-group input').forEach(input => {
            if (input.value) {
                input.dispatchEvent(new Event('focus'));
                input.dispatchEvent(new Event('blur'));
            }
        });

        function initPage() {
            createParticles();
            animateCounters();
            initPageAnimations();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPage);
        } else {
            initPage();
        }
    </script>

</body>
</html>

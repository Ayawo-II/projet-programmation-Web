<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AskCampus - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen text-white">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.16),transparent_20%),radial-gradient(circle_at_bottom_right,_rgba(56,189,248,0.1),transparent_20%)]"></div>
        <div class="absolute inset-x-0 top-1/2 h-px bg-white/10"></div>
        <div class="absolute inset-y-0 left-0 w-1/2 bg-[linear-gradient(180deg,rgba(56,189,248,0.05),transparent)]"></div>
    </div>

    <div class="relative z-10 mx-auto w-full max-w-6xl px-4 py-10">
        <div class="relative overflow-hidden rounded-[2rem] border border-cyan-400/20 bg-slate-950/95 shadow-[0_40px_120px_rgba(14,165,233,0.18)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(56,189,248,0.15),transparent_15%),radial-gradient(circle_at_bottom_left,_rgba(14,165,233,0.1),transparent_18%)] pointer-events-none"></div>
            <div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(15,23,42,0.96)_45%,rgba(14,165,233,0.12)_55%)]"></div>
            <div class="relative grid min-h-[640px] grid-cols-1 overflow-hidden rounded-[2rem] lg:grid-cols-[0.95fr_1.05fr]">
                <div class="relative flex flex-col justify-center bg-slate-950/95 px-8 py-10 sm:px-10 lg:px-14">
                    <div class="absolute inset-y-0 right-0 w-36 bg-cyan-400/5 blur-3xl lg:-mr-16"></div>
                    <div class="absolute top-0 left-0 w-28 h-28 bg-cyan-300/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="relative z-10 max-w-xl">
                        <div class="mb-10">
                            <h2 class="text-4xl font-semibold tracking-tight text-white">Login</h2>
                            <p class="mt-4 max-w-md text-sm text-slate-300">Connectez-vous pour accéder à AskCampus et gérer votre espace étudiant avec un design moderne et réactif.</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-medium text-slate-200">Username</label>
                                <div class="relative">
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                        class="w-full border-b border-slate-600 bg-transparent py-4 pr-4 text-white placeholder-slate-500 focus:border-cyan-400 focus:outline-none"
                                        placeholder="admin@gmail.com">
                                    <span class="absolute right-0 top-1/2 -translate-y-1/2 text-cyan-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </span>
                                </div>
                                @error('email')
                                    <p class="text-sm text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-sm text-slate-300">
                                    <label for="password" class="font-medium">Password</label>
                                    <a href="{{ route('password.request') }}" class="text-cyan-300 hover:text-cyan-200">Forgot Password</a>
                                </div>
                                <div class="relative">
                                    <input id="password" type="password" name="password" required autocomplete="current-password"
                                        class="w-full border-b border-slate-600 bg-transparent py-4 pr-4 text-white placeholder-slate-500 focus:border-cyan-400 focus:outline-none"
                                        placeholder="Enter your password">
                                    <span class="absolute right-0 top-1/2 -translate-y-1/2 text-cyan-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </span>
                                </div>
                                @error('password')
                                    <p class="text-sm text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="flex w-full items-center justify-center rounded-full bg-gradient-to-r from-cyan-400 via-sky-500 to-blue-500 px-6 py-4 text-base font-semibold text-slate-950 shadow-lg shadow-cyan-500/30 transition-transform duration-200 hover:-translate-y-0.5">Login</button>

                            <p class="text-center text-sm text-slate-400">Don't have an account? <a href="{{ route('register') }}" class="text-cyan-300 font-semibold hover:text-cyan-100">Sign up</a></p>
                        </form>
                    </div>
                </div>

                <div class="relative overflow-hidden bg-gradient-to-br from-cyan-500 via-sky-600 to-teal-400 px-8 py-10 sm:px-10 lg:px-14 lg:py-16">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.28),transparent_22%),radial-gradient(circle_at_bottom_right,_rgba(15, 185, 255,0.18),transparent_30%)] pointer-events-none"></div>
                    <div class="absolute inset-y-0 left-0 w-full bg-[linear-gradient(135deg,rgba(15,23,42,0.12),transparent_50%)]"></div>
                    <div class="relative z-10 flex h-full flex-col justify-center">
                        <h3 class="text-sm uppercase tracking-[0.36em] text-white/80">Welcome back</h3>
                        <h1 class="mt-5 text-4xl font-bold uppercase tracking-tight text-white sm:text-5xl">WELCOME BACK!</h1>
                        <p class="mt-6 max-w-md text-sm leading-relaxed text-white/80">We're happy to have you with us again. If you need anything, we're here to help.</p>
                        <div class="mt-10 grid gap-4 sm:grid-cols-2">
                            <div class="flex h-14 items-center justify-center rounded-3xl bg-white/10 border border-white/15 text-white/90">
                                <span class="text-sm">AskCampus</span>
                            </div>
                            <div class="flex h-14 items-center justify-center rounded-3xl bg-white/10 border border-white/15 text-white/90">
                                <span class="text-sm">Student Portal</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

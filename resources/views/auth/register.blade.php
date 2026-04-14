<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AskCampus - Inscription</title>
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
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(34,211,238,0.16),transparent_18%),radial-gradient(circle_at_bottom_right,_rgba(59,130,246,0.12),transparent_18%)]"></div>
        <div class="absolute inset-x-0 top-1/2 h-px bg-white/10"></div>
        <div class="absolute right-0 top-0 h-full w-1/2 bg-[linear-gradient(180deg,rgba(15,23,42,0.05),transparent)]"></div>
    </div>

    <div class="relative z-10 mx-auto w-full max-w-6xl px-4 py-10">
        <div class="relative overflow-hidden rounded-[2rem] border border-cyan-400/20 bg-slate-950/95 shadow-[0_40px_120px_rgba(14,165,233,0.18)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(56,189,248,0.18),transparent_18%),radial-gradient(circle_at_bottom_left,_rgba(14,165,233,0.12),transparent_20%)] pointer-events-none"></div>
            <div class="relative grid min-h-[640px] grid-cols-1 overflow-hidden rounded-[2rem] lg:grid-cols-[1.05fr_0.95fr]">
                <div class="relative flex flex-col justify-center bg-gradient-to-br from-indigo-700 via-indigo-600 to-cyan-500 px-8 py-10 sm:px-10 lg:px-14">
                    <div class="absolute inset-y-0 left-0 w-32 bg-white/10 blur-3xl lg:-ml-16"></div>
                    <div class="relative z-10 max-w-xl">
                        <p class="text-sm uppercase tracking-[0.35em] text-white/80">Welcome</p>
                        <h1 class="mt-4 text-5xl font-bold uppercase tracking-tight text-white">WELCOME BACK!</h1>
                        <p class="mt-6 max-w-md text-sm leading-7 text-white/80">We're happy to have you with us again. Register now to join AskCampus and manage your student projects in one place.</p>
                        <div class="mt-10 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl border border-white/15 bg-white/10 p-5 text-sm text-white/90">
                                <p class="font-semibold uppercase tracking-[0.32em] text-white/80">Support</p>
                                <p class="mt-3 text-white/70">Need help? We're here 24/7 for your account setup.</p>
                            </div>
                            <div class="rounded-3xl border border-white/15 bg-white/10 p-5 text-sm text-white/90">
                                <p class="font-semibold uppercase tracking-[0.32em] text-white/80">Fast access</p>
                                <p class="mt-3 text-white/70">Connect instantly and start using AskCampus in seconds.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative flex flex-col justify-center bg-slate-950/95 px-8 py-10 sm:px-10 lg:px-14">
                    <div class="relative z-10 mx-auto w-full max-w-xl">
                        <div class="mb-10">
                            <p class="text-xs uppercase tracking-[0.35em] text-cyan-300/80">Sign up</p>
                            <h2 class="mt-4 text-4xl font-semibold tracking-tight text-white">Create your AskCampus account</h2>
                            <p class="mt-4 text-sm text-slate-400">Entrez vos informations pour démarrer votre inscription sécurisée.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="space-y-6">
                            @csrf

                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-medium text-slate-200">Username</label>
                                <div class="relative">
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                        class="w-full border-b border-slate-700 bg-transparent py-4 pr-4 text-white placeholder-slate-500 focus:border-cyan-400 focus:outline-none"
                                        placeholder="JohnDoe">
                                    <span class="absolute right-0 top-1/2 -translate-y-1/2 text-cyan-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </span>
                                </div>
                                @error('name')
                                    <p class="text-sm text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium text-slate-200">Email</label>
                                <div class="relative">
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                        class="w-full border-b border-slate-700 bg-transparent py-4 pr-4 text-white placeholder-slate-500 focus:border-cyan-400 focus:outline-none"
                                        placeholder="john@example.com">
                                    <span class="absolute right-0 top-1/2 -translate-y-1/2 text-cyan-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0a4 4 0 10-8 0 4 4 0 008 0zm6 0c0 6-4 10-10 10S0 18 0 12 4 2 10 2s10 4 10 10z" />
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
                                </div>
                                <div class="relative">
                                    <input id="password" type="password" name="password" required autocomplete="new-password"
                                        class="w-full border-b border-slate-700 bg-transparent py-4 pr-4 text-white placeholder-slate-500 focus:border-cyan-400 focus:outline-none"
                                        placeholder="••••••••">
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

                            <button type="submit" class="flex w-full items-center justify-center rounded-full bg-gradient-to-r from-cyan-400 via-sky-500 to-blue-500 px-6 py-4 text-base font-semibold text-slate-950 shadow-lg shadow-cyan-500/30 transition-transform duration-200 hover:-translate-y-0.5">Sign up</button>

                            <p class="text-center text-sm text-slate-400">Already have an account? <a href="{{ route('login') }}" class="text-cyan-300 font-semibold hover:text-cyan-100">Login</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

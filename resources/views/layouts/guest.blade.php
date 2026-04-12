<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --primary: #6366f1;
                --primary-dark: #4f46e5;
                --secondary: #8b5cf6;
                --accent: #f43f5e;
                --gray-100: #f1f5f9;
                --gray-200: #e2e8f0;
                --gray-300: #cbd5e1;
                --gray-400: #94a3b8;
                --gray-600: #475569;
                --gray-800: #1e293b;
            }

            body {
                min-height: 100vh;
                font-family: 'Inter', sans-serif;
                color: var(--gray-800);
                background: linear-gradient(145deg, #f8fafc 0%, #eef2ff 100%);
            }

            .glass-panel {
                background: rgba(255, 255, 255, 0.94);
                border: 1px solid rgba(255, 255, 255, 0.75);
                box-shadow: 0 30px 80px -40px rgba(15, 23, 42, 0.25);
                backdrop-filter: blur(20px);
            }

            .input-modern {
                width: 100%;
                padding: 0.95rem 1.05rem;
                border: 1.5px solid var(--gray-200);
                border-radius: 0.9rem;
                transition: all 0.3s ease;
                outline: none;
                font-size: 0.95rem;
            }

            .input-modern:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                border: none;
                padding: 0.85rem 1.5rem;
                border-radius: 1rem;
                color: white;
                font-weight: 600;
                transition: transform 0.25s ease, box-shadow 0.25s ease;
            }

            .btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 18px 35px -18px rgba(99, 102, 241, 0.5);
            }

            .gradient-text {
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen overflow-hidden bg-[radial-gradient(circle_at_top_left,_rgba(99,102,241,0.16),transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(139,92,246,0.14),transparent_30%)]">
            <div class="absolute inset-0 bg-[linear-gradient(180deg,_rgba(255,255,255,0.45),transparent)]"></div>
            <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
                <div class="w-full max-w-3xl">
                    <div class="mb-8 rounded-[2rem] border border-white/70 bg-white/90 p-8 shadow-2xl backdrop-blur-xl">
                        <div class="text-center">
                            <a href="{{ url('/') }}" class="inline-flex items-center justify-center text-3xl font-bold gradient-text">AskCampus</a>
                            <p class="mt-4 text-sm text-gray-600">Une plateforme d’entraide académique entre étudiants.</p>
                        </div>
                    </div>

                    <div class="glass-panel rounded-[2rem] p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

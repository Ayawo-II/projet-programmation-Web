<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:wght@400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --primary: #6366f1;
                --primary-dark: #4f46e5;
                --secondary: #8b5cf6;
                --accent: #f43f5e;
                --success: #10b981;
                --gray-50: #f8fafc;
                --gray-100: #f1f5f9;
                --gray-200: #e2e8f0;
                --gray-300: #cbd5e1;
                --gray-400: #94a3b8;
                --gray-500: #64748b;
                --gray-600: #475569;
                --gray-700: #334155;
                --gray-800: #1e293b;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', sans-serif;
                background: radial-gradient(circle at top, rgba(99, 102, 241, 0.16), transparent 40%), radial-gradient(circle at bottom right, rgba(139, 92, 246, 0.14), transparent 35%), linear-gradient(145deg, #f8fafc 0%, #eef2ff 100%);
                min-height: 100vh;
                color: var(--gray-800);
            }

            .navbar {
                position: sticky;
                top: 0;
                z-index: 1000;
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(24px);
                border-bottom: 1px solid rgba(99, 102, 241, 0.1);
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                border: none;
                padding: 0.75rem 1.6rem;
                border-radius: 0.9rem;
                color: white;
                font-weight: 600;
                font-size: 0.95rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }

            .btn-primary::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
                transition: left 0.4s ease;
            }

            .btn-primary:hover::before {
                left: 100%;
            }

            .btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 14px 28px -12px rgba(99, 102, 241, 0.32);
            }

            .btn-outline {
                background: transparent;
                border: 1.5px solid var(--gray-200);
                padding: 0.75rem 1.6rem;
                border-radius: 0.9rem;
                color: var(--gray-600);
                font-weight: 600;
                font-size: 0.95rem;
                transition: all 0.3s ease;
            }

            .btn-outline:hover {
                border-color: var(--primary);
                color: var(--primary);
                background: rgba(99, 102, 241, 0.06);
                transform: translateY(-1px);
            }

            .card {
                background: white;
                border-radius: 1.5rem;
                box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                border: 1px solid rgba(255, 255, 255, 0.65);
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 25px 45px -16px rgba(0, 0, 0, 0.12);
            }

            .input-modern {
                width: 100%;
                padding: 0.95rem 1rem;
                border: 1.5px solid var(--gray-200);
                border-radius: 0.9rem;
                transition: all 0.3s ease;
                outline: none;
                font-size: 0.95rem;
            }

            .input-modern:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            }

            .gradient-text {
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(32px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .fade-in-up {
                animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }

            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #eff6ff;
                border-radius: 9999px;
            }

            ::-webkit-scrollbar-thumb {
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                border-radius: 9999px;
            }
        </style>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @unless(request()->routeIs('dashboard') || request()->routeIs('profile.edit'))
                @include('layouts.navigation')
            @endunless

            @isset($header)
                <header class="bg-white/75 backdrop-blur-sm border-b border-slate-200 shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                <div class="w-full min-h-screen py-8 {{ request()->routeIs('dashboard') || request()->routeIs('profile.edit') ? 'px-0' : 'px-4 sm:px-6 lg:px-8' }}">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @stack('scripts')
    </body>
</html>

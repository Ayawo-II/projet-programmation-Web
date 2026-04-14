<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="space-y-6">
                <div class="rounded-[2rem] border border-violet-500/15 bg-slate-950/95 p-6 shadow-[0_30px_80px_rgba(139,92,246,0.12)] sm:p-8">
                    <div class="grid gap-8 lg:grid-cols-[1.4fr_0.9fr] lg:items-center">
                        <div class="space-y-4">
                            <p class="text-sm uppercase tracking-[0.35em] text-violet-300/80">AskCampus</p>
                            <h1 class="text-3xl font-semibold text-white sm:text-4xl">Bienvenue, {{ auth()->user()->name }} !</h1>
                            <p class="max-w-2xl text-sm leading-7 text-slate-300">Vous êtes connecté et prêt à gérer votre espace utilisateur. Consultez votre profil, suivez votre réputation et continuez votre activité sur AskCampus.</p>
                        </div>
                        <div class="rounded-[1.75rem] bg-white/5 p-6 ring-1 ring-white/10 backdrop-blur sm:p-8">
                            <p class="text-sm uppercase tracking-[0.35em] text-violet-200/80">Statut</p>
                            <p class="mt-4 text-base text-slate-300">Vous êtes bien connecté.</p>
                            <p class="mt-3 text-2xl font-semibold text-white">You're logged in!</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    <div class="rounded-[1.75rem] bg-slate-900/90 p-6 shadow-lg shadow-violet-500/10 ring-1 ring-white/5">
                        <p class="text-xs uppercase tracking-[0.35em] text-violet-300/70">Rôle</p>
                        <p class="mt-4 text-3xl font-semibold text-white">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                    <div class="rounded-[1.75rem] bg-slate-900/90 p-6 shadow-lg shadow-violet-500/10 ring-1 ring-white/5">
                        <p class="text-xs uppercase tracking-[0.35em] text-violet-300/70">Réputation</p>
                        <p class="mt-4 text-3xl font-semibold text-white">{{ auth()->user()->reputation }}</p>
                    </div>
                    <div class="rounded-[1.75rem] bg-slate-900/90 p-6 shadow-lg shadow-violet-500/10 ring-1 ring-white/5">
                        <p class="text-xs uppercase tracking-[0.35em] text-violet-300/70">Questions</p>
                        <p class="mt-4 text-3xl font-semibold text-white">{{ auth()->user()->questions_count }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

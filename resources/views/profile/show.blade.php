<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 leading-tight">{{ __('Profil public') }}</h2>
                <p class="text-sm text-gray-600">Affiche les éléments clés du profil utilisateur AskCampus.</p>
            </div>
            <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700">{{ $user->display_role }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 p-8 text-white shadow-2xl">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-cyan-300">AskCampus</p>
                        <h1 class="mt-4 text-4xl font-semibold">{{ $user->name }}</h1>
                        <p class="mt-3 max-w-xl text-sm text-slate-300">Profil public pour la communauté. Ta réputation reflète ta participation et ton aide apportée aux autres étudiants.</p>
                    </div>
                    <div class="rounded-3xl bg-slate-900/80 px-6 py-5 text-center ring-1 ring-white/10">
                        <p class="text-sm uppercase tracking-[0.24em] text-slate-400">Réputation</p>
                        <p class="mt-4 text-5xl font-semibold text-white">{{ $user->reputation }}</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900">Informations</h2>
                    <ul class="mt-6 space-y-4 text-slate-600">
                        <li class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-4">
                            <span>Email</span>
                            <span class="font-medium text-slate-900">{{ $user->email }}</span>
                        </li>
                        <li class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-4">
                            <span>Membre depuis</span>
                            <span class="font-medium text-slate-900">{{ $user->created_at?->format('d/m/Y') ?? '-' }}</span>
                        </li>
                    </ul>
                </div>

                <div class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900">A propos</h2>
                    <p class="mt-4 text-sm leading-7 text-slate-600">La réputation permet de mettre en valeur les membres actifs et fiables. Ce score sert à encourager l’entraide sans transformer AskCampus en un espace de compétition.</p>
                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-slate-50 p-4 text-sm text-slate-700">Rôle : <span class="font-semibold text-slate-900">{{ $user->display_role }}</span></div>
                        <div class="rounded-3xl bg-slate-50 p-4 text-sm text-slate-700">Réputation : <span class="font-semibold text-slate-900">{{ $user->reputation }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

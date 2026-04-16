<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-6 xl:grid-cols-[1.2fr_1fr]">
                <div class="rounded-[2rem] border border-violet-500/15 bg-slate-950/95 p-6 shadow-[0_30px_80px_rgba(139,92,246,0.12)] sm:p-8">
                    <h3 class="text-lg font-semibold text-white">Infos du profil</h3>
                    <p class="mt-3 text-sm text-slate-400">Toutes les informations liées à ton compte AskCampus.</p>

                    <div class="mt-8 space-y-4">
                        <div class="rounded-[1.75rem] border border-white/10 bg-slate-900/80 p-5">
                            <p class="text-xs uppercase tracking-[0.32em] text-violet-300/80">Nom</p>
                            <p class="mt-2 text-base font-medium text-white">{{ $user->name }}</p>
                        </div>
                        <div class="rounded-[1.75rem] border border-white/10 bg-slate-900/80 p-5">
                            <p class="text-xs uppercase tracking-[0.32em] text-violet-300/80">Email</p>
                            <p class="mt-2 text-base font-medium text-white">{{ $user->email }}</p>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-[1.75rem] border border-white/10 bg-slate-900/80 p-5">
                                <p class="text-xs uppercase tracking-[0.32em] text-violet-300/80">Rôle</p>
                                <p class="mt-2 text-base font-medium text-white">{{ ucfirst($user->role) }}</p>
                            </div>
                            <div class="rounded-[1.75rem] border border-white/10 bg-slate-900/80 p-5">
                                <p class="text-xs uppercase tracking-[0.32em] text-violet-300/80">Réputation</p>
                                <p class="mt-2 text-base font-medium text-white">{{ $user->reputation }}</p>
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-[1.75rem] border border-white/10 bg-slate-900/80 p-5">
                                <p class="text-xs uppercase tracking-[0.32em] text-violet-300/80">Questions posées</p>
                                <p class="mt-2 text-base font-medium text-white">{{ $user->questions_count }}</p>
                            </div>
                            <div class="rounded-[1.75rem] border border-white/10 bg-slate-900/80 p-5">
                                <p class="text-xs uppercase tracking-[0.32em] text-violet-300/80">Réponses données</p>
                                <p class="mt-2 text-base font-medium text-white">{{ $user->answers_count }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-[2rem] border border-violet-500/15 bg-slate-950/95 p-6 shadow-[0_30px_80px_rgba(139,92,246,0.12)] sm:p-8">
                        <h3 class="text-lg font-semibold text-white">Modifier le profil</h3>
                        <div class="mt-6 max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-violet-500/15 bg-slate-950/95 p-6 shadow-[0_30px_80px_rgba(139,92,246,0.12)] sm:p-8">
                        <h3 class="text-lg font-semibold text-white">Changer le mot de passe</h3>
                        <div class="mt-6 max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-violet-500/15 bg-slate-950/95 p-6 shadow-[0_30px_80px_rgba(139,92,246,0.12)] sm:p-8">
                        <h3 class="text-lg font-semibold text-white">Supprimer le compte</h3>
                        <div class="mt-6 max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

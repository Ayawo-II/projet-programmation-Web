<x-guest-layout>
    <div class="space-y-8">
        <div class="text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-600">Réinitialisation</p>
            <h2 class="mt-4 text-3xl font-bold tracking-tight text-slate-900">Réinitialiser ton mot de passe</h2>
            <p class="mt-3 text-sm text-slate-500">Crée un nouveau mot de passe sécurisé pour reprendre l’accès à ton compte.</p>
        </div>

        <div class="rounded-3xl bg-slate-50 p-8 shadow-xl ring-1 ring-slate-200">
            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Adresse email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="mt-2 block w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Nouveau mot de passe</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password" class="mt-2 block w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirmation du nouveau mot de passe</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="mt-2 block w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <button type="submit" class="w-full rounded-2xl bg-cyan-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-cyan-500/10 transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">Réinitialiser le mot de passe</button>
            </form>

            <div class="mt-6 text-center text-sm text-slate-500">
                <a href="{{ route('login') }}" class="font-semibold text-cyan-600 hover:text-cyan-800">Retour à la connexion</a>
            </div>
        </div>
    </div>
</x-guest-layout>

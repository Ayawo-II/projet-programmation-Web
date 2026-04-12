<x-guest-layout>
    <div class="space-y-8">
        <div class="text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-600">Récupération de mot de passe</p>
            <h2 class="mt-4 text-3xl font-bold tracking-tight text-slate-900">Mot de passe oublié ?</h2>
            <p class="mt-3 text-sm text-slate-500">Saisis ton email pour recevoir un lien de réinitialisation sécurisé.</p>
        </div>

        <div class="rounded-3xl bg-slate-50 p-8 shadow-xl ring-1 ring-slate-200">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Adresse email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-2 block w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <button type="submit" class="w-full rounded-2xl bg-cyan-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-cyan-500/10 transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">Envoyer le lien de réinitialisation</button>
            </form>

            <div class="mt-6 text-center text-sm text-slate-500">
                <a href="{{ route('login') }}" class="font-semibold text-cyan-600 hover:text-cyan-800">Retour à la connexion</a>
            </div>
        </div>
    </div>
</x-guest-layout>

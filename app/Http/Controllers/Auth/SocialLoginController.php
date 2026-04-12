<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    private array $providers = ['google', 'github', 'microsoft'];

    public function redirect(string $provider): RedirectResponse
    {
        if (!in_array($provider, $this->providers, true)) {
            abort(404);
        }

        if (!class_exists(Socialite::class)) {
            return redirect()->route('login')->with('status', 'La connexion sociale n\'est pas encore configurée.');
        }

        if (empty(config("services.$provider.client_id")) || empty(config("services.$provider.client_secret"))) {
            return redirect()->route('login')->withErrors([
                'social' => "La configuration OAuth pour {$provider} est incomplète. Vérifiez les variables {$provider}_CLIENT_ID et {$provider}_CLIENT_SECRET dans votre fichier .env."
            ]);
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback(Request $request, string $provider): RedirectResponse
    {
        if (!in_array($provider, $this->providers, true)) {
            abort(404);
        }

        if (!class_exists(Socialite::class)) {
            return redirect()->route('login')->with('status', 'La connexion sociale n\'est pas encore configurée.');
        }

        $socialUser = Socialite::driver($provider)->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            ['name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Utilisateur']
        );

        auth()->login($user, true);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}

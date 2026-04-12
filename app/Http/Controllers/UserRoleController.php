<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserRoleController extends Controller
{
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:student,moderator'],
        ]);

        $actor = $request->user();
        abort_unless($actor && $actor->isModerator(), 403);

        $user->role = $request->role;
        $user->save();

        return Redirect::back()->with('success', 'Rôle mis à jour avec succès.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateTokenRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Laravel\Sanctum\PersonalAccessToken;

class TokenController extends Controller
{
    public function store(UserCreateTokenRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
        $accessToken = $user->createToken($request->input('name'))
            ->plainTextToken;

        return redirect()->route('dashboard.index')
            ->with('success', $accessToken);
    }

    public function destroy(PersonalAccessToken $token): RedirectResponse
    {
        $token->delete();

        return redirect()->route('dashboard.index')
            ->with('success', "Token $token->name was removed");
    }
}

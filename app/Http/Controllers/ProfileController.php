<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\Controller as BaseController;

class ProfileController extends BaseController
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(\App\Http\Requests\ProfileUpdateRequest $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:6144',
            'bio' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar_url) {
                Storage::disk('public')->delete($user->avatar_url);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_url = $avatarPath;
        }

        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated!');
    }

    public function destroy()
    {
        $user = User::find(Auth::id());
        Auth::logout();

        if ($user && $user->avatar_url) {
            Storage::disk('public')->delete($user->avatar_url);
        }

        if ($user) {
            $user->delete();
        }
        return redirect('/')->with('success', 'Account deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * Display the settings page
     */
    public function index(): View
    {
        $user = auth()->user();
        return view('settings.index', compact('user'));
    }

    /**
     * Update user profile settings
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->id())],
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        $data = $request->only(['name', 'email', 'bio']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
                Storage::disk('public')->delete($user->avatar_url);
            }

            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar_url'] = $avatarPath;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully!');
    }

    /**
     * Update privacy settings
     */
    public function updatePrivacy(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_visibility' => 'required|in:public,friends,private',
            'show_email' => 'boolean',
            'show_online_status' => 'boolean',
            'allow_messages' => 'boolean',
        ]);

        $user = auth()->user();

        // For now, we'll store these as JSON in a settings field
        // In a real app, you'd want separate columns or a settings table
        $settings = $user->settings ?? [];
        $settings['privacy'] = [
            'profile_visibility' => $request->profile_visibility,
            'show_email' => $request->boolean('show_email'),
            'show_online_status' => $request->boolean('show_online_status'),
            'allow_messages' => $request->boolean('allow_messages', true),
        ];

        $user->update(['settings' => $settings]);

        return redirect()->back()->with('success', 'Privacy settings updated successfully!');
    }

    /**
     * Update notification preferences
     */
    public function updateNotifications(Request $request): RedirectResponse
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'message_notifications' => 'boolean',
            'follow_notifications' => 'boolean',
            'reaction_notifications' => 'boolean',
        ]);

        $user = auth()->user();

        $settings = $user->settings ?? [];
        $settings['notifications'] = [
            'email_notifications' => $request->boolean('email_notifications'),
            'push_notifications' => $request->boolean('push_notifications'),
            'message_notifications' => $request->boolean('message_notifications', true),
            'follow_notifications' => $request->boolean('follow_notifications', true),
            'reaction_notifications' => $request->boolean('reaction_notifications', true),
        ];

        $user->update(['settings' => $settings]);

        return redirect()->back()->with('success', 'Notification preferences updated successfully!');
    }

    /**
     * Delete user account
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required',
            'confirm_delete' => 'required|accepted',
        ]);

        $user = auth()->user();

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Password is incorrect.']);
        }

        // Delete avatar if exists
        if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
            Storage::disk('public')->delete($user->avatar_url);
        }

        // Log out and delete user
        auth()->logout();
        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }
}

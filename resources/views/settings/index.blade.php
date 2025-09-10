<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                {{ __('Settings') }}
            </h2>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Manage your account preferences
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Settings Navigation Tabs -->
            <div class="mb-8">
                <nav class="flex space-x-1 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl p-2 shadow-xl border border-white/20 dark:border-slate-700/50">
                    <button
                        onclick="showTab('profile')"
                        id="profile-tab"
                        class="tab-button flex-1 py-3 px-4 rounded-xl text-sm font-medium transition-all duration-200 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300"
                    >
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </button>
                    <button
                        onclick="showTab('privacy')"
                        id="privacy-tab"
                        class="tab-button flex-1 py-3 px-4 rounded-xl text-sm font-medium transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700"
                    >
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Privacy
                    </button>
                    <button
                        onclick="showTab('notifications')"
                        id="notifications-tab"
                        class="tab-button flex-1 py-3 px-4 rounded-xl text-sm font-medium transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700"
                    >
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c1.54 0 3-.36 4.3-1l1.57-.85.49.85c.32.55.95.88 1.64.78.68-.1 1.13-.76.91-1.42l-.3-.9C19.84 18.82 21 15.6 21 12c0-5.52-4.48-10-10-10z" />
                        </svg>
                        Notifications
                    </button>
                    <button
                        onclick="showTab('account')"
                        id="account-tab"
                        class="tab-button flex-1 py-3 px-4 rounded-xl text-sm font-medium transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700"
                    >
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Account
                    </button>
                </nav>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <ul class="text-red-800 dark:text-red-200">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Profile Settings Tab -->
            <div id="profile-tab-content" class="tab-content">
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50 p-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Profile Information</h3>

                    <form action="{{ route('settings.updateProfile') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Avatar Upload -->
                        <div class="flex items-center space-x-6">
                            <div class="relative">
                                @if($user->avatar_url)
                                    <img src="{{ asset('storage/' . $user->avatar_url) }}"
                                         alt="Current avatar"
                                         class="w-20 h-20 rounded-full object-cover ring-4 ring-blue-500">
                                @else
                                    <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <label for="avatar" class="absolute -bottom-2 -right-2 bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full cursor-pointer transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </label>
                                <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h4>
                                <p class="text-gray-600 dark:text-gray-400">Update your profile picture</p>
                            </div>
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200">
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bio</label>
                            <textarea id="bio" name="bio" rows="3" maxlength="500"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 resize-none transition-all duration-200"
                                      placeholder="Tell us about yourself...">{{ old('bio', $user->bio ?? '') }}</textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Maximum 500 characters</p>
                        </div>

                        <div class="flex justify-end">
                            <x-loading.button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                Save Changes
                            </x-loading.button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Privacy Settings Tab -->
            <div id="privacy-tab-content" class="tab-content hidden">
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50 p-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Privacy Settings</h3>

                    <form action="{{ route('settings.updatePrivacy') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Profile Visibility -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Profile Visibility</label>
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="radio" name="profile_visibility" value="public"
                                           {{ ($user->settings['privacy']['profile_visibility'] ?? 'public') === 'public' ? 'checked' : '' }}
                                           class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-3 text-gray-700 dark:text-gray-300">Public - Anyone can see your profile</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="profile_visibility" value="friends"
                                           {{ ($user->settings['privacy']['profile_visibility'] ?? 'public') === 'friends' ? 'checked' : '' }}
                                           class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-3 text-gray-700 dark:text-gray-300">Friends - Only followers can see your profile</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="profile_visibility" value="private"
                                           {{ ($user->settings['privacy']['profile_visibility'] ?? 'public') === 'private' ? 'checked' : '' }}
                                           class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-3 text-gray-700 dark:text-gray-300">Private - Only you can see your profile</span>
                                </label>
                            </div>
                        </div>

                        <!-- Other Privacy Options -->
                        <div class="space-y-4">
                            <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Show Email Address</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Display your email on your public profile</div>
                                </div>
                                <input type="checkbox" name="show_email" value="1"
                                       {{ ($user->settings['privacy']['show_email'] ?? false) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                            </label>

                            <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Show Online Status</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Let others see when you're online</div>
                                </div>
                                <input type="checkbox" name="show_online_status" value="1"
                                       {{ ($user->settings['privacy']['show_online_status'] ?? false) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                            </label>

                            <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Allow Direct Messages</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Receive messages from other users</div>
                                </div>
                                <input type="checkbox" name="allow_messages" value="1"
                                       {{ ($user->settings['privacy']['allow_messages'] ?? true) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                            </label>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                Save Privacy Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notifications Settings Tab -->
            <div id="notifications-tab-content" class="tab-content hidden">
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50 p-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Notification Preferences</h3>

                    <form action="{{ route('settings.updateNotifications') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-4">
                            <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Email Notifications</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Receive notifications via email</div>
                                </div>
                                <input type="checkbox" name="email_notifications" value="1"
                                       {{ ($user->settings['notifications']['email_notifications'] ?? false) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                            </label>

                            <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Push Notifications</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Receive push notifications in your browser</div>
                                </div>
                                <input type="checkbox" name="push_notifications" value="1"
                                       {{ ($user->settings['notifications']['push_notifications'] ?? false) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                            </label>

                            <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Message Notifications</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Get notified when you receive new messages</div>
                                </div>
                                <input type="checkbox" name="message_notifications" value="1"
                                       {{ ($user->settings['notifications']['message_notifications'] ?? true) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                            </label>

                            <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Follow Notifications</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Get notified when someone follows you</div>
                                </div>
                                <input type="checkbox" name="follow_notifications" value="1"
                                       {{ ($user->settings['notifications']['follow_notifications'] ?? true) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                            </label>

                            <label class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Reaction Notifications</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Get notified when someone reacts to your posts</div>
                                </div>
                                <input type="checkbox" name="reaction_notifications" value="1"
                                       {{ ($user->settings['notifications']['reaction_notifications'] ?? true) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                            </label>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                Save Notification Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Settings Tab -->
            <div id="account-tab-content" class="tab-content hidden">
                <div class="space-y-6">
                    <!-- Change Password -->
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50 p-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Change Password</h3>

                        <form action="{{ route('settings.updatePassword') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                                <input type="password" id="current_password" name="current_password"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200">
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                                <input type="password" id="password" name="password"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200">
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200">
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Delete Account -->
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-8">
                        <h3 class="text-xl font-bold text-red-900 dark:text-red-100 mb-4">Danger Zone</h3>
                        <p class="text-red-700 dark:text-red-300 mb-6">
                            Once you delete your account, there is no going back. Please be certain.
                        </p>

                        <button
                            onclick="document.getElementById('delete-modal').classList.remove('hidden')"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl"
                        >
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Delete Account</h3>
            </div>

            <form action="{{ route('settings.destroy') }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('DELETE')

                <div>
                    <label for="delete_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter your password to confirm</label>
                    <input type="password" id="delete_password" name="password" required
                           class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                </div>

                <label class="flex items-center">
                    <input type="checkbox" name="confirm_delete" value="1" required
                           class="rounded text-red-600 focus:ring-red-500">
                    <span class="ml-3 text-gray-700 dark:text-gray-300">I understand that this action cannot be undone</span>
                </label>

                <div class="flex space-x-3">
                    <button type="button" onclick="document.getElementById('delete-modal').classList.add('hidden')"
                            class="flex-1 bg-gray-200 dark:bg-slate-700 text-gray-800 dark:text-gray-200 py-3 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active state from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('bg-blue-100', 'dark:bg-blue-900/50', 'text-blue-700', 'dark:text-blue-300');
                button.classList.add('text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-100', 'dark:hover:bg-slate-700');
            });

            // Show selected tab content
            document.getElementById(tabName + '-tab-content').classList.remove('hidden');

            // Add active state to selected tab
            document.getElementById(tabName + '-tab').classList.remove('text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-100', 'dark:hover:bg-slate-700');
            document.getElementById(tabName + '-tab').classList.add('bg-blue-100', 'dark:bg-blue-900/50', 'text-blue-700', 'dark:text-blue-300');
        }

        // Initialize first tab as active
        document.addEventListener('DOMContentLoaded', function() {
            showTab('profile');
        });
    </script>
</x-app-layout>

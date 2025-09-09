<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>
        <div>
            <x-input-label for="avatar" :value="__('Avatar')" />

            <!-- Current Avatar Display -->
            <div class="mt-2 flex items-center space-x-4">
                <!-- Avatar Image -->
                <div class="relative">
                    @if(isset($user->avatar_url) && $user->avatar_url)
                    <img class="h-20 w-20 rounded-full object-cover border-2 border-gray-300"
                        src="{{ asset('storage/' . $user->avatar_url) }}"
                        alt="{{ $user->name }}'s avatar">
                    @else
                    <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-300">
                        <svg class="h-12 w-12 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    @endif

                    <!-- edit icon, the onclick clicks the hidden file input-->
                    <button type="button"
                        onclick="document.getElementById('avatar').click()"
                        class="absolute -bottom-1 -right-1 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 shadow-lg transition-colors duration-200">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Click the edit icon to change your avatar
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                        JPG, PNG or GIF. Max size: 2MB
                    </p>
                </div>
            </div>

            <!-- Hidden File Input -->
            <input id="avatar" name="avatar" type="file" class="hidden" accept="image/*" onchange="previewAvatar(this)" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />

            <!-- Preview for new avatar -->
            <div id="avatar-preview" class="hidden mt-2">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">New avatar preview:</p>
                <img id="preview-image" class="h-20 w-20 rounded-full object-cover border-2 border-blue-300" />
            </div>
        </div>
        <div>

            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>



        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.getElementById('avatar-preview');
                const previewImg = document.getElementById('preview-image');
                previewImg.src = e.target.result; // the result of reading the file is the src
                previewDiv.classList.remove('hidden'); // make the preview div visible
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
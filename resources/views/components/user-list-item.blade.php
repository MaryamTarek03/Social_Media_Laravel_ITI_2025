<!-- It always seems impossible until it is done. - Nelson Mandela -->
@props(['user'])
<div class="mt-2 flex items-center w-full block hover:bg-gray-100 p-2 rounded-lg transition-colors duration-200">
    <x-profile-avatar :user="$user" class="w-8 h-8 rounded-full object-cover mx-auto inline" />
    <a href="{{ route('users.show', $user) }}" class="w-full h-full">
        <p class="ml-2 text-sm text-gray-700 inline-flex w-full">{{ $user->name }}</p>
    </a>
</div>
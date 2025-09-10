<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md">
            {{ session('success') }}
        </div>
        @endif

        <!-- Users Grid -->
        <div class="">
            @foreach($users as $user)
            <x-user-list-item :user="$user" />
            @endforeach
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">

                    {{-- رسالة نجاح --}}
                    @if (session('success'))
                    <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                    @endif

                    {{-- صورة البروفايل --}}
                    @if ($user->avatar_url)
                    <img src="{{ Storage::url($user->avatar_url) }}"
                        alt="Avatar"
                        class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    @else
                    <img src="https://via.placeholder.com/120"
                        alt="Default Avatar"
                        class="w-32 h-32 rounded-full mx-auto mb-4">
                    @endif

                    {{-- الاسم --}}
                    <h3 class="text-2xl font-semibold">{{ $user->name }}</h3>

                    {{-- الايميل --}}
                    <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>

                    {{-- البايو --}}
                    <p class="mt-3">
                        {{ $user->bio ?? 'No bio added yet.' }}
                    </p>

                    {{-- أزرار التحكم --}}
                    @if (Auth::id() === $user->id)
                    <div class="mt-6 flex justify-center gap-4">
                        <a href="{{ route('profile.edit') }}"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Edit Profile
                        </a>

                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to delete your account?')"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Delete Account
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


@extends('layouts.app')

@section('content')
<div class="container">
    <!-- محتوى المقال -->
    <div class="card mb-4">
        <div class="card-body">
            <h1>{{ $post->title }}</h1>
            <p class="text-muted">بواسطة {{ $post->user->name }} - {{ $post->created_at->format('Y-m-d') }}</p>
            <div>{!! nl2br(e($post->content)) !!}</div>
        </div>
    </div>

    <!-- جزء التعليقات -->
    <div class="card">
        <div class="card-header">
            <h3>التعليقات ({{ $post->comments->count() }})</h3>
        </div>
        <div class="card-body">
            
            <!-- Form to add new comment -->
            @auth
            <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-4">
                @csrf
                <div class="form-group mb-3">
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" 
                            rows="3" placeholder="اكتب تعليقك هنا..." required></textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">إضافة تعليق</button>
            </form>
            @else
            <div class="alert alert-info">
                <a href="{{ route('login') }}">سجل دخولك</a> لإضافة تعليق
            </div>
            @endauth

            <hr>

            <!-- Show Comments -->
            @forelse($post->comments as $comment)
            <div class="border-bottom pb-3 mb-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>{{ $comment->user->name }}</strong>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    
                    @if(auth()->check() && auth()->id() === $comment->user_id)
                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" 
                        onsubmit="return confirm('Do you want to delete this comment?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                    </form>
                    @endif
                </div>
                <p class="mt-2 mb-0">{{ $comment->content }}</p>
            </div>
            @empty
            <p class="text-muted text-center">لا توجد تعليقات بعد. كن أول من يعلق!</p>
            @endforelse

        </div>
    </div>
</div>
@endsection
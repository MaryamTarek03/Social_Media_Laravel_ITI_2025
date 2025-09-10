<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Post</h1>
                    <p class="mt-2 text-sm text-gray-600">Update your post</p>
                </div>
                <a href="{{ route('posts.show', $post) }}" class="text-sm text-gray-500 hover:text-gray-700">
                    ← Back to Post
                </a>
            </div>
        </div>

        <!-- Edit Post Form -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200">
            <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Content
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        rows="4"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('content') border-red-300 @enderror"
                        placeholder="Share your thoughts..."
                        required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Media -->
                @if($post->media_url)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Media</label>
                    <div class="relative inline-block">
                        <img src="{{ Storage::url($post->media_url) }}" alt="Current media" class="h-32 w-auto rounded-lg shadow-sm">
                        <label class="absolute top-2 right-2">
                            <input type="checkbox" name="remove_media" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-white bg-red-600 px-2 py-1 rounded">Remove</span>
                        </label>
                    </div>
                </div>
                @endif

                <!-- New Media Upload -->
                <div>
                    <label for="media" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $post->media_url ? 'Replace Photo (Optional)' : 'Add Photo (Optional)' }}
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="media" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <input
                                        id="media"
                                        name="media"
                                        type="file"
                                        class="sr-only"
                                        accept="image/*"
                                        onchange="previewImage(this)">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                        </div>
                    </div>
                    @error('media')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- New Image Preview -->
                    <div id="image-preview" class="hidden mt-4">
                        <img id="preview-img" class="h-32 w-auto rounded-lg shadow-sm" alt="New image preview">
                        <button type="button" onclick="removePreview()" class="mt-2 text-sm text-red-600 hover:text-red-800">
                            Remove new image
                        </button>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <div class="text-sm text-gray-500">
                        Last updated {{ $post->updated_at->diffForHumans() }}
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Update Post
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removePreview() {
            document.getElementById('image-preview').classList.add('hidden');
            document.getElementById('media').value = '';
        }
    </script>
</x-app-layout>
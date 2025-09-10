<x-app-layout>
        <div class="mt-4">
<div class="text-center">
                <a href="{{route('posts.create')}}" class="btn btn-success">Create Posts</a>
            </div>
            </div>
                <table class="table ">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Posted By</th>
        <th scope="col">Created At</th>
        <th scope="col">Actions</th>
        </tr>
    </thead>
    
    <tbody>
@foreach ($posts as $post )
        <tr>
        <td>{{$post['id']}}</td>
        <td>{{$post['content']}}</td>
        <td>{{$post->user->name}}</td>
        <td>{{$post->created_at}}</td>
        <td>
        <a href="{{route('posts.show', $post['id'])}}" class="btn btn-info">View</a>
<a href="{{ route('posts.edit', $post['id']) }}" class="btn btn-primary">Edit</a>

<form action="{{ route('posts.destroy', $post['id']) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>

        </td>
        </tr>
@endforeach
    </tbody>
    </table>
{{-- @foreach ($posts as $post)
    <div>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>

        @if(Auth::user() === $post->user_id)
            <a href="{{ route('posts.edit', $post->id) }}">Edit</a>

            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        @endif
    </div>
@endforeach --}}
</x-app-layout>
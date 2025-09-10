<x-app-layout>
        <div class="mt-4">
<div class="text-center">
                <a href="{{route('posts.create')}}" class="btn btn-success">Create Posts</a>
            </div>
            </div>
           
<div class="card mt-4">
<div class="card-header">
    Post info
</div>
<div class="card-body">
    <h5 class="card-title">Title: {{$post['id']}}</h5>
    
   <p>Description: {{$post['description']}}</p>
    
</div>
</div>

<div class="card mt-4">
    <div class="card-header">
    Post Creator Info
    </div>
    <div class="card-body">
    <h5 class="card-title">Name: Ahmed</h5>
    <p class="card-text">Email: Ahmed@gmail.com</p>
    <p>Created At: Thursday 25th of December 1975 02:15:16 PM</p>
    </div>
</div>
</x-app-layout>
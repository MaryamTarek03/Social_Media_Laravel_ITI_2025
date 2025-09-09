        @extends('layouts.app')
        @section('title') creat @endsection
        @section('content')
        <form method="POST" action="{{route('posts.store')}}">
            @csrf
            <div class="nb-3">
                <label class="form-label">Title</label>
                <input name="title" type="text" class="form-control">
            </div>
            <div class="nb-3">
                <label class="form-label">Description</label>
                <textarea  name="description" rows="3" class="form-control"></textarea>
            </div>
            <div class="nb-3">
                <label class="form-label">Post Creator</label>
                <select  name ="post_creator" class="form-control">
                    <option value="1">ahmed</option>
                    <option value="2">mohamed</option>
                </select>
            </div>
            <br>
                <button class="btn btn-success">Submit</button>   
        </form>      
        @endsection
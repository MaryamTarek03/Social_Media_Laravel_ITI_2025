<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
        public function store(){
        //get the user data
        $data = Request()->all();
        return $data;
        //store the user data in database

        //redirection to post.index
        return to_route('posts.index');
    }
}

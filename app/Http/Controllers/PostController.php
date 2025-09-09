<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
        public function index(){
        $allposts =[
            ['id' =>1,'title'=> 'php','posted by'=> 'ahmed','created_add'=>'2022-10-10 09:08:00'],
            ['id' =>2,'title'=> 'laravel','posted by'=> 'mohamed','created_add'=>'2022-10-10 08:08:00'],
            ['id' =>3,'title'=> 'java','posted by'=> 'mariam','created_add'=>'2022-10-10 05:08:00'],
            ['id' =>4,'title'=> 'css','posted by'=> 'tassnem','created_add'=>'2022-10-10 03:08:00'],
        ];
        return view('posts.index',['posts'=>$allposts]);
    }
        public function show($postid){
        $singlepost=[
            'id' =>1,'title'=> 'php','discription'=>'this dicription is:','posted by'=> 'ahmed','created_add'=>'2022-10-10 09:08:00'
        ];
        return view('posts.show',['post'=>$singlepost]);
    }
        public function create(){
        return view('posts.create');
    }
        public function store(){
        //get the user data
        $data = Request()->all();
        return $data;
        //store the user data in database

        //redirection to post.index
        return to_route('posts.index');
    }
            public function update($id)
        {
    $title = request()->input('title');
    $description = request()->input('description');
    $post_creator = request()->input('post_creator');
        // dd($title,$description,$post_creator);
        //update the user data in database

        //redirection to post.show
        return to_route('posts.show',$id);
        }
        public function edit(){
        return view('posts.edit');
    }
        public function destroy(){
            // delet post from data base
            // redirection to post.index
            return to_route('posts.index');
        }
}

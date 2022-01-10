<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
class PostController extends Controller
{
    // get all post
    public function index(){
    	return Post::all();
    }
    // Store individual post
    public function store(Request $request){
    	$validated = $this->validate($request,[
	        'title' => 'required|unique:posts|max:255',
	        'slug' => 'required',
    	]);
    	return Post::create($request->all());
    }

    // View individual post
    public function show($id){
    	return Post::find($id);
    }

     // Update a post
    public function update(Request $request, $id){
		$post=Post::find($id);
		$post->update($request->all());
		return $post;
    }

    // Delete a post
    public function destroy($id){
    	return Post::destroy($id);
    }
}

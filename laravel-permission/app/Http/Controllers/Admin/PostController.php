<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class PostController extends Controller
{
    public function create_post(){
        return view('admin.posts.create_post');
    }

    public function post_data(Request $request){
        $post= new Post();
        $post->title= $request->title;
        $post->tags= $request->tags;
        $post->user_name= Auth::user()->name;
        $post->save();
        return back()->with('message',"Post Created Successfully!!");
    }

    public function index(){
        
        $all_posts= Post::all();
        return view('admin.posts.index',compact('all_posts'));
    }

    public function edit(Post $post)
    {
        $roles = Role::all();
        return view('admin.posts.edit', compact( 'post','roles'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate(['title' => 'required','tags'=>'required']);
        $post->update($validated);

        return to_route('admin.posts.index')->with('message', 'Posts updated.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('message', 'Post deleted.');
    }


    public function assignRole(Request $request, Post $post)
    {
        if ($post->hasRole($request->role)) {
            return back()->with('message', 'Role exists.');
        }

        $post->assignRole($request->role);
        return back()->with('message', 'Role assigned.');
    }

    public function removeRole(Post $post, Role $role)
    {
        if ($post->hasRole($role)) {
            $post->removeRole($role);
            return back()->with('message', 'Role removed.');
        }

        return back()->with('message', 'Role not exists.');
    }
}

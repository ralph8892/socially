<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Jobs\SendNewPostEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function search ($term) {
        // return Post::where('title', 'LIKE', '%' . $term . '%')->orWhere('body', 'LIKE', '%' . $term . '%')->with('user:id,username,avatar')->get();

        $posts = Post::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
    }

    public function doUpdate (Post $post, Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);

        return back()->with('success', 'Post successfully updated');
    }

    public function showEditForm (Post $post) {
        return view('edit-post', ['post' => $post]);
    }

    public function delete (Post $post) {
        // if (auth()->user()->cannot('delete', $post)) {
        //     return 'You cannot do that';
        // } line 17 on web routes for exact same functionality
        $post->delete();

        return redirect('/profile/'. auth()->user()->username)->with('success', 'Post successfully deleted');
    }

    public function viewSinglePost (Post $post) {
        return view('single-post', ['post' => $post]);
    }

    public function storeNewPost (Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        dispatch(new SendNewPostEmail(['sendTo' => auth()->user()->email, 'name' => auth()->user()->username, 'title' => $newPost->title]));

		return $newPost->id;

        return redirect("/post/{$newPost->id}")->with('success', 'New Blogpost Created');
    }

    public function showCreateForm () {
        return view("create-post");
    }
}

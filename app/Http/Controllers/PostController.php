<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class PostController extends Controller
{
    public function index()
    {
        // Query Builder
        // $posts = DB::table('posts')->paginate(10);

        // Eloquent ORM
        $posts = Post::with('author')->paginate(10);
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Query Builder
        // $post = DB::table('posts')->where('id', $id)->first();
        // $post = DB::table('posts')->find($id);

        // Eloquent ORM
        // $post = Post::find($id);

        // Load author with post
        $post = Post::with('author')->findOrFail($id);
        
        if ($post) {
            return view('posts.show', ['post' => $post]);
        }
        return 'Post not found';
    }


    /**
     * Create a new resource
     */
    public function create()
    {
        $users = User::all();
        return view("posts.create", ['users' => $users]);
    }

    /**
     * Store a newly created resource in database.
     */
    public function store(StorePostRequest $request)
    {
        // Validation is handled automatically by StorePostRequest
        // No need for $request->validate() here

        // Query Builder
        // DB::table("posts")->insert([
        //     "title" => $request->input('title'),
        //     "content" => $request->input('content'),
        //     "author_id" => $request->input('author_id'),
        //     "created_at" => now(),
        //     "updated_at" => now(),
        // ]);

        // Eloquent ORM
        // $post = new Post();
        // $post->title = $request->input('title');
        // $post->content = $request->input('content');
        // $post->author_id = $request->input('author_id');
        // $post->save();

        // Mass assignment using only validated data (slug can't be injected)
        Post::create($request->validated());


        return redirect()->route("posts.index")->with("success", "Post created successfully");
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     // Query Builder
    //     // $post = DB::table('posts')->find($id);

    //     // Eloquent ORM
    //     $post = Post::find($id);

    //     if ($post) {
    //         $users = User::all();
    //         return view('posts.edit', compact('post', 'users'));
    //     }
    //     return 'Post not found';
    // }
    public function edit(Post $post) // laravel searches for $post by Post::findOrFail($id);
    {
        $users = User::all();
        return view('posts.edit', compact('post','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        // Validation is handled automatically by UpdatePostRequest

        // Query Builder
        // DB::table('posts')->where('id', $id)->update([
        //     'title' => $request->input('title'),
        //     'content' => $request->input('content'),
        //     'author_id' => $request->input('author_id'),
        //     'updated_at' => now(),
        // ]);

        // Eloquent ORM
        $post = Post::find($id);
        if ($post) {
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->author_id = $request->input('author_id');
            $post->save();
            return redirect()->route('posts.index')->with('success', 'Post updated successfully');
        }
        return 'Post not found';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Query Builder
        // DB::table('posts')->where('id', $id)->delete();

        // Eloquent ORM
        $post = Post::find($id);
        if ($post) {
            $post->delete();
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
        }
        return 'Post not found';
    }

    // restore soft deleted resource
    public function restore(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->route('posts.trashed')->with('success', 'Post restored successfully');
    }

    // show soft deleted posts
    public function trashed()
    {
        $posts = Post::onlyTrashed()->paginate(10);
        return view('posts.trashed', compact('posts'));
    }
}

// model binding
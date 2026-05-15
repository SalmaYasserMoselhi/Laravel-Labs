<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;

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
    public function store(Request $request)
    {
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

        // Mass assignment - works if fillable is set
        Post::create([
            "title" => $request->input('title'),
            "content" => $request->input('content'),
            "author_id" => $request->input('author_id'),
        ]);


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
    public function update(Request $request, string $id)
    {
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
}

// model binding
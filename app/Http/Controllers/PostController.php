<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



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
        $post = Post::with(['author', 'comments.likes', 'likes'])->findOrFail($id);
        
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

        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts_images', 'public');
        }

        // Mass assignment using only validated data (slug can't be injected)
        $post = Post::create($data);
        if($post){
            return redirect()->route("posts.index")->with("success", "Post created successfully");
        } else{
            return redirect()->route("posts.index")->with("error", "Post creation failed");
        }
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
        // Eloquent ORM
        $post = Post::findOrFail($id);
        if ($post) {
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->author_id = $request->input('author_id');

            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $post->image = $request->file('image')->store('posts_images', 'public');
            }

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
        // Eloquent ORM
        $post = Post::findOrFail($id);
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

    public function forceDelete(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        foreach ($post->comments as $comment) {
            $comment->likes()->delete();
        }
        $post->likes()->delete();
        $post->comments()->delete();

        $post->forceDelete();
        return redirect()->route('posts.trashed')->with('success', 'Post permanently deleted');
    }

    // store a new comment on a post
    public function storeComment(Request $request, string $id)
    {
        $request->validate([
            'body' => 'required|string|min:3',
        ], [
            'body.required' => 'Please enter a comment',
            'body.min' => 'Comment must be at least 3 characters',
        ]);

        $post = Post::findOrFail($id);

        $post->comments()->create([
            'body' => $request->input('body'),
        ]);

        return redirect()->route('posts.show', $id)->with('success', 'Comment added successfully');
    }

    public function likePost(string $id)
    {
        $post = Post::findOrFail($id);

        $existingLike = $post->likes()->where('user_id', auth()->id())->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            $post->likes()->create(['user_id' => auth()->id()]);
        }

        return redirect(route('posts.show', $id) . '#post-likes');
    }

    public function likeComment(string $postId, string $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        $existingLike = $comment->likes()->where('user_id', auth()->id())->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            $comment->likes()->create(['user_id' => auth()->id()]);
        }

        return redirect(route('posts.show', $postId) . '#comment-' . $commentId);
    }
}

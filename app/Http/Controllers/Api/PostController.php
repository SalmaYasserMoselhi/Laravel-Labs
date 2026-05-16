<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // GET /api/posts
    public function index()
    {
        $posts = Post::with('author')->paginate(10);

        return PostResource::collection($posts);
    }

    // GET /api/posts/{id}
    public function show(string $id)
    {
        $post = Post::with('author')->find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found',
                'status' => 'failed',
            ], 404);
        }

        return response()->json([
            'data' => new PostResource($post),
            'status' => 'success',
        ], 200);
    }

    // POST /api/posts
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $validated['author_id'] = auth()->id();

        $post = Post::create($validated);

        return response()->json([
            'data' => new PostResource($post->load('author')),
            'status' => 'success',
        ], 201);
    }
}

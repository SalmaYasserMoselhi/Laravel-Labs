<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PostController extends Controller
{
    private $defaultPosts = [
        ['id' => 1, 'title' => 'First Post', 'content' => 'This is the first post.'],
        ['id' => 2, 'title' => 'Second Post', 'content' => 'This is the second post.'],
        ['id' => 3, 'title' => 'Third Post', 'content' => 'This is the third post.'],
        ['id' => 4, 'title' => 'Fourth Post', 'content' => 'This is the fourth post.'],
        ['id' => 5, 'title' => 'Fifth Post', 'content' => 'This is the fifth post.'],
    ];

    // get posts from session
    private function getPosts()
    {
        if (!session()->has('posts')) {
            session(['posts' => $this->defaultPosts]);
        }
        return session('posts');
    }

    /**
     * Display a listing of the resources.
     */
    public function index()
    {
        // get all posts
        $posts = $this->getPosts();
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get details of one post
        $posts = $this->getPosts();
        foreach ($posts as $post) {
            if ($post['id'] == $id) {
                return view('posts.show', ['post' => $post]);
            }
        }
        return 'Post not found';
    }


    /**
     * Create a new resource
     */
    public function create()
    {
        return view("posts.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // store data in session
        $posts = $this->getPosts();
        $newPost = [
            'id' => count($posts) > 0 ? max(array_column($posts, 'id')) + 1 : 1,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ];
        $posts[] = $newPost;
        session(['posts' => $posts]);
        return redirect('/posts');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // return view of form to edit a post
        $posts = $this->getPosts();
        foreach ($posts as $post) {
            if ($post['id'] == $id) {
                return view('posts.edit', ['post' => $post]);
            }
        }
        return 'Post not found, return to <a href="/posts">Posts</a>';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update data in session
        $posts = $this->getPosts();
        foreach ($posts as $key => $post) {
            if ($post['id'] == $id) {
                $posts[$key]['title'] = $request->input('title');
                $posts[$key]['content'] = $request->input('content');
                session(['posts' => $posts]);
                return "Post updated sucessfully, return to <a href='/posts'>Posts</a>";
            }
        }
        return 'Post not found';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete from session
        $posts = $this->getPosts();
        foreach ($posts as $key => $post) {
            if ($post['id'] == $id) {
                unset($posts[$key]);
                session(['posts' => array_values($posts)]);
                return "Post deleted sucessfully, return to <a href='/posts'>Posts</a>";
            }
        }
        return "Post not found, return to <a href='/posts'>Posts</a>";
    }
}

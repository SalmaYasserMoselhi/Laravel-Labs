<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PostController extends Controller
{
    private $posts = [
        ['id' => 1, 'title' => 'First Post', 'content' => 'This is the first post.'],
        ['id' => 2, 'title' => 'Second Post', 'content' => 'This is the second post.'],
        ['id' => 3, 'title' => 'Third Post', 'content' => 'This is the third post.'],
        ['id' => 4, 'title' => 'Fourth Post', 'content' => 'This is the fourth post.'],
        ['id' => 5, 'title' => 'Fifth Post', 'content' => 'This is the fifth post.'],
    ];
    
    /**
     * Display a listing of the resources.
     */
    public function index()
    {
        // get all posts from database
        return view('posts.index', ['posts' => $this->posts]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get details of one post
        foreach ($this->posts as $post) {
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
        // store data in database
        $title = $request->title;
        return "Post created successfully with title: {$title}";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // return view of form to edit a post
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update data of a post in database
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete a post from database
    }
}

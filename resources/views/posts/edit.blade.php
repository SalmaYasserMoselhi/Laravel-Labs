@extends('layouts.main')

@section('title', 'Edit Post')
@section('content')
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="{{ $post['title'] }}"><br><br>
        <label for="content">Content:</label>
        <textarea id="content" name="content">{{ $post['content'] }}</textarea><br><br>
        <input type="submit" value="Update">
    </form>
    <br>
    <a href="/posts">Back to posts</a>
@endsection


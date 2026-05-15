@extends('layouts.main')

@section('title', 'Show Post')
@section('content')
    <h1>Show Post</h1>
    <p>Post ID: {{ $post->id }}</p>
    <p>Post Title: {{ $post->title }}</p>
    <p>Post Content: {{ $post->content }}</p>
    <p>Post Author: {{ $post->author ? $post->author->name : 'No Author' }}</p>
    <p>Created At: {{ $post->created_at->format('d M Y, h:i A') }} ({{ $post->created_at->diffForHumans() }})</p>
    <a href="/posts/{{ $post->id }}/edit">Edit</a>
    <form action="/posts/{{ $post->id }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
    <br><br>
    <a href="/posts">Back to posts</a>
@endsection

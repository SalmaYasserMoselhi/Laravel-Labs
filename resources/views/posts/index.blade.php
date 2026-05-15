@extends('layouts.main')

@section('title', 'Posts')
@section('content')
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <h1>Posts</h1>
    <a href="{{ route('posts.create') }}">
        <x-button type="button">Create Post</x-button>
    </a>
    <ul>
        @foreach ($posts as $post)
            <li>
                {{ $post->title }}
                - <small>{{ $post->created_at->format('d M Y, h:i A') }}</small>
                - <small>{{ $post->created_at->diffForHumans() }}</small>
                <a href="{{ route("posts.show", $post->id) }}">View Post</a>
                <a href="{{ route("posts.edit", $post->id) }}">Edit</a>
                <form action="{{ route("posts.destroy", $post->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    {{ $posts->links() }}
@endsection

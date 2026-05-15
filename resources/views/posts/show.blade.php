<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p>Post ID: {{ $post->id }}</p>
            <p>Post Title: {{ $post->title }}</p>
            <p>Post Content: {{ $post->content }}</p>
            <p>Post Author: {{ $post->author ? $post->author->name : 'No Author' }}</p>
            <p>Created At: {{ $post->created_at->format('d M Y, h:i A') }} ({{ $post->created_at->diffForHumans() }})</p>
            <br>
            <a href="{{ route('posts.edit', $post->id) }}">Edit</a>
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                @csrf
                @method('DELETE')
                <x-danger-button type="submit">Delete</x-danger-button>
            </form>
            <br><br>
            <a href="{{ route('posts.index') }}">Back to posts</a>
        </div>
    </div>
</x-app-layout>

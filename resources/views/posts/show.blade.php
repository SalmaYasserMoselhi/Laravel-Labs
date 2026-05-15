<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <p>Post ID: {{ $post->id }}</p>
            <p>Post Title: {{ $post->title }}</p>
            <p>Post Content: {{ $post->content }}</p>
            <p>Post Author: {{ $post->author ? $post->author->name : 'No Author' }}</p>
            @if ($post->image)
                <p>Post Image:</p>
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" style="max-width: 400px; max-height: 300px; border-radius: 8px; margin: 10px 0;">
            @endif
            <p>Created At: {{ $post->created_at->format('d M Y, h:i A') }} ({{ $post->created_at->diffForHumans() }})</p>

            <form action="{{ route('posts.like', $post->id) }}" method="POST" style="display:inline; margin-top: 10px;">
                @csrf
                <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 16px;">
                    ❤️ {{ $post->likes->count() }} Likes
                </button>
            </form>

            <br><br>
            <a href="{{ route('posts.edit', $post->id) }}">Edit</a>
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                @csrf
                @method('DELETE')
                <x-danger-button type="submit">Delete</x-danger-button>
            </form>
            <br><br>
            <a href="{{ route('posts.index') }}">Back to posts</a>

            <hr style="margin: 30px 0;">
            <h3 class="font-semibold text-lg text-gray-800 mb-4">Comments ({{ $post->comments->count() }})</h3>

            <form action="{{ route('posts.comments.store', $post->id) }}" method="POST" style="margin-bottom: 20px;">
                @csrf
                <textarea name="body" rows="3" placeholder="Write a comment..." style="width: 100%; max-width: 500px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">{{ old('body') }}</textarea>
                @error('body') <br><span style="color: red;">{{ $message }}</span> @enderror
                <br>
                <x-primary-button type="submit" style="margin-top: 8px;">Add Comment</x-primary-button>
            </form>

            @forelse ($post->comments as $comment)
                <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; margin-bottom: 10px; max-width: 500px;">
                    <p>{{ $comment->body }}</p>
                    <small style="color: #6b7280;">{{ $comment->created_at->diffForHumans() }}</small>
                    <form action="{{ route('posts.comments.like', [$post->id, $comment->id]) }}" method="POST" style="display:inline; float:right;">
                        @csrf
                        <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 14px;">
                            ❤️ {{ $comment->likes->count() }}
                        </button>
                    </form>
                </div>
            @empty
                <p style="color: #9ca3af;">No comments yet.</p>
            @endforelse

        </div>
    </div>
</x-app-layout>

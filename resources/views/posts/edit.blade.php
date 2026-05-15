<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}">
                @error('title') <span style="color: red;">{{ $message }}</span> @enderror
                <br><br>
                <label for="content">Content:</label>
                <textarea id="content" name="content">{{ old('content', $post->content) }}</textarea>
                @error('content') <span style="color: red;">{{ $message }}</span> @enderror
                <br><br>
                <label for="author_id">Post Creator:</label>
                <select id="author_id" name="author_id">
                    <option value="">Select Author</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('author_id', $post->author_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('author_id') <span style="color: red;">{{ $message }}</span> @enderror
                <br><br>
                @if ($post->image)
                    <label>Current Image:</label><br>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" style="max-width: 200px; max-height: 200px; margin-bottom: 10px;">
                    <br>
                @endif

                <label for="image">Change Image:</label>
                <input type="file" id="image" name="image">
                @error('image') <span style="color: red;">{{ $message }}</span> @enderror
                <br><br>
                <x-primary-button type="submit">Update</x-primary-button>
            </form>
            <br>
            <a href="{{ route('posts.index') }}">Back to posts</a>
        </div>
    </div>
</x-app-layout>

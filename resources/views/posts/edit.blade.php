@extends('layouts.main')

@section('title', 'Edit Post')
@section('content')
    <h1>Edit Post</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('posts.update', $post->id) }}" method="POST">
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
        <input type="submit" value="Update">
    </form>
    <br>
    <a href="/posts">Back to posts</a>
@endsection

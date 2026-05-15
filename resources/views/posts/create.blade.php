@extends('layouts.main')

@section('title', 'Create Post')
@section('content')
    <h1>Create Post</h1>
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}">
        @error('title') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>
        <label for="content">Content:</label>
        <textarea id="content" name="content">{{ old('content') }}</textarea>
        @error('content') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>
        <label for="author_id">Post Creator:</label>
        <select id="author_id" name="author_id">
            <option value="">Select Author</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('author_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>
        @error('author_id') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>
        <input type="submit" value="Create">
    </form>
@endsection
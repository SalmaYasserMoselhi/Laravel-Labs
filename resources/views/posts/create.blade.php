<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
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
                <label for="image">Post Image:</label>
                <input type="file" id="image" name="image">
                @error('image') <span style="color: red;">{{ $message }}</span> @enderror
                <br><br>
                <x-primary-button type="submit">Create</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('posts.create') }}">
                    <x-primary-button type="button">+ Create Post</x-primary-button>
                </a>
                <a href="{{ route('posts.trashed') }}" class="ml-3">
                    <x-secondary-button type="button">Trashed Posts</x-secondary-button>
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-3 px-4 font-semibold text-gray-600">Title</th>
                                <th class="py-3 px-4 font-semibold text-gray-600">Slug</th>
                                <th class="py-3 px-4 font-semibold text-gray-600">Created At</th>
                                <th class="py-3 px-4 font-semibold text-gray-600">Time Ago</th>
                                <th class="py-3 px-4 font-semibold text-gray-600 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4 font-medium">{{ $post->title }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $post->slug }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $post->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</td>
                                    <td class="py-3 px-4 text-right">
                                        <a href="{{ route('posts.show', $post->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium mr-3">View</a>
                                        <a href="{{ route('posts.edit', $post->id) }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium mr-3">Edit</a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $posts->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

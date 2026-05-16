<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trashed Posts') }}
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
                <a href="{{ route('posts.index') }}">
                    <x-secondary-button type="button">← Back to Posts</x-secondary-button>
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($posts->count() > 0)
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="py-3 px-4 font-semibold text-gray-600">Title</th>
                                    <th class="py-3 px-4 font-semibold text-gray-600">Deleted At</th>
                                    <th class="py-3 px-4 font-semibold text-gray-600 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="py-3 px-4 font-medium">{{ $post->title }}</td>
                                        <td class="py-3 px-4 text-sm text-gray-500">{{ $post->deleted_at->diffForHumans() }}</td>
                                        <td class="py-3 px-4 text-right">
                                            <form action="{{ route('posts.restore', $post->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">Restore</button>
                                            </form>
                                            <form action="{{ route('posts.forceDelete', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will permanently delete the post!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium ml-3">Force Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">No trashed posts.</p>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                {{ $posts->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

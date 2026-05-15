<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Joined:</strong> {{ $user->created_at->format('d M Y, h:i A') }}</p>
                    <p><strong>Posts Count:</strong> {{ $user->posts->count() }}</p>
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-3">Posts</h3>
                    <ul>
                        @foreach ($user->posts as $post)
                            <li class="py-1">
                                <a href="{{ route('posts.show', $post->id) }}" class="text-indigo-600 hover:text-indigo-800">{{ $post->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-800 text-sm">← Back to users</a>
            </div>
        </div>
    </div>
</x-app-layout>

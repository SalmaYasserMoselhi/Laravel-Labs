<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <x-input-label for="name" value="Name" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <x-primary-button type="submit">Update</x-primary-button>
                    </form>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('users.index') }}" class="text-gray-600 hover:text-gray-800 text-sm">← Back to users</a>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        @method('POST')

                        {{-- Title --}}
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-white">Title</label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                required
                                autofocus
                                autocomplete="title"
                                class="block w-full px-4 py-2 text-white placeholder-white bg-gray-800 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        {{-- Category --}}
                        <div class="mb-6">
                            <label for="category" class="block mb-2 text-sm font-medium text-white">Category</label>
                            <input
                                type="text"
                                id="category"
                                name="category"
                                required
                                autofocus
                                autocomplete="category"
                                class="block w-full px-4 py-2 text-white placeholder-white bg-gray-800 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('category')" />
                        </div>

                        

                        {{-- Buttons --}}
                        <div class="flex items-center gap-4">
                            <button
                                type="submit"
                                class="px-4 py-2 border border-gray-500 text-white rounded hover:bg-gray-400 hover:text-black transition"
                            >
                                SAVE
                            </button>
                            <a
                                href="{{ route('categories.index') }}"
                                class="px-4 py-2 border border-gray-500 text-white rounded hover:bg-gray-400 hover:text-black transition"
                            >
                                CANCEL
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

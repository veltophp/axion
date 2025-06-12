@extends('axion::layouts.app')

@section('axion::title')
    Blog | All Posts
@endsection

@section('axion::header')
    Blog | All Posts
@endsection

@section('axion::content')

<div class="space-y-6 max-w-4xl mx-auto">

    <!-- Header -->
    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-medium text-gray-800 dark:text-gray-100">All Posts</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Browse or manage all your posts</p>
        </div>
    </div>

    <!-- Flash Errors -->
    <div>@flash_errors</div>

    <!-- Table -->
    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-4 overflow-x-auto">
        <div class="min-w-[600px]"> <!-- Membuat breakpoint minimum lebar agar bisa scroll -->
            <table class="w-full divide-y divide-gray-200 dark:divide-dark-600 text-sm">
                <thead class="text-gray-600 dark:text-gray-300 uppercase text-xs bg-gray-50 dark:bg-dark-700">
                    <tr>
                        <th class="px-6 py-4 text-left whitespace-nowrap">Image</th>
                        <th class="px-6 py-4 text-left whitespace-nowrap">Title</th>
                        <th class="px-6 py-4 text-left whitespace-nowrap">Action</th>
                        <th class="px-6 py-4 text-left whitespace-nowrap">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-dark-600 text-gray-800 dark:text-gray-100">
                    @foreach ($posts as $post)
                    <tr class="transition hover:bg-gray-50 dark:hover:bg-dark-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="/{{ $post->image }}" alt="{{ $post->slug }}" class="h-12 w-12 object-cover rounded-md border border-gray-300 dark:border-dark-600">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('view.post', [$post->slug]) }}" class="hover:underline text-blue-600 dark:text-blue-400 font-medium">
                                {{ $post->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                            <a href="{{ route('edit.post', [$post->post_id]) }}" class="text-blue-600 dark:text-blue-400 hover:underline">Edit</a>
                            <span class="text-gray-400 dark:text-gray-500 mx-1">|</span>
                            <a href="{{ route('delete.post', [$post->post_id]) }}" class="text-red-600 hover:underline">Delete</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-block px-2 py-1 text-xs rounded-md bg-gray-100 dark:bg-dark-700 text-gray-700 dark:text-gray-300">
                                {{ $post->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    

    <!-- Empty State -->
    @if (!$posts)
    <div class="flex items-center justify-center p-8 bg-white dark:bg-dark-800 rounded-xl border border-gray-200 dark:border-dark-600 shadow-subtle">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-semibold text-gray-800 dark:text-gray-100">No articles found</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">There are no articles created yet.</p>
        </div>
    </div>
    @endif

</div>
@endsection

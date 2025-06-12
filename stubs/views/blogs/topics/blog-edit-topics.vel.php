@extends('axion::layouts.app')

@section('axion::title')
    topics | Axion Dashboard
@endsection

@section('axion::header')
    Manage topics
@endsection

@section('axion::content')

<main class="flex-1 overflow-y-auto">
    <div class="max-w-4xl mx-auto p-6">
        
        <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-8">
            <p class="text-gray-600 dark:text-gray-400 mt-1">Add new topic</p>
        </div>

        <div>@flash_errors</div>

        <form action="{{ route('update.topics', [$topic->topic_id]) }}" method="POST">

            {!! csrf_field() !!}

            <!-- topic Name -->
            <div class="my-6">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-2">topic Name</label>
                <input type="text" name="topic" required value="{{$topic->topic}}"
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                    placeholder="Enter topic name...">
            </div>

            <!-- Description -->
            <div class="my-6">
                <label class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                    placeholder="Enter description...">{{$topic->description}}</textarea>
            </div>

            <div class="my-6">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 rounded-md hover:bg-blue-700 text-white font-semibold transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Save topic
                </button>
            </div>
        </form>

        <!-- Existing topics -->
        <div class="mt-10">
            @if($topics)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($topics as $topic)
                        <div class="group relative border bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-700 rounded-lg p-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-150">
                            <div class="flex justify-between items-start">
                                <div class="min-w-0 pr-2">
                                    <h3 class="font-medium text-gray-800 dark:text-gray-100 truncate">{{ $topic->topic }}</h3>
                                    @if($topic->description)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $topic->description }}</p>
                                    @endif
                                </div>
                                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('edit.topics', [$topic->topic_id]) }}"
                                       class="p-1 text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('delete.topics', [$topic->topic_id]) }}"
                                       onclick="return confirm('Are you sure you want to delete this topic?')"
                                       class="p-1 text-gray-400 hover:text-red-500 dark:hover:text-red-400 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No topics found</p>
                </div>
            @endif
        </div>

    </div>
</main>

@endsection

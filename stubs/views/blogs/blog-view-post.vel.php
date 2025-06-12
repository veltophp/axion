@extends('layouts.app')

@section('title')
    {{ $post->title }} | Blog
@endsection

@section('content')
    <div class="px-4 mt-32">
        <!-- Post Header -->
        <div class="mb-12 max-w-3xl mx-auto">
            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide mb-4">{{$post->category()->category}}</span>
            <div class="my-8">
                <h1 class="text-4xl md:text-6xl dark:text-gray-200 font-bold text-gray-800">{{ $post->title }}</h1>
                <div class="my-4 text-gray-400">Posted at {{format($post->created_at)}}</div>
            </div>
            <img src="/{{ $post->image }}" alt="Featured Post" class="w-full rounded shadow-lg mb-6">
        </div>

    </div>

    <div class="container mx-auto px-4 max-w-3xl">

        <article class="prose max-w-none prose-lg prose-blue mb-12 dark:prose-invert">
            {!! $post->content !!}
        </article>

        <div class="border-t border-gray-200 pt-6 mb-24">
            <div class="flex flex-wrap items-center justify-between mb-6">
                <div class="flex space-x-2">
                    <a href="#"
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-full text-sm text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 transition-colors">
                        {{ $post->topic()->topic }}
                    </a>
                </div>
            </div>
            
            <div class="flex items-center space-x-3 my-12">
                @if($post->user()->picture)
                    <img class="h-16 w-16 rounded-full" src="/{{$post->user()->picture}}" alt="">
                @else
                    <img class="h-16 w-16 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($post->user()->name) }}&background=f3f4f6&color=111827" alt="">
                @endif
                <div>
                    <p class="font-medium text-gray-900 dark:text-gray-200">
                        Written by {{ $post->user()->name}}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $post->user()->bio }}
                    </p>
                </div>
            </div>
            
        </div>
    </div>
@endsection
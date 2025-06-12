@extends('layouts.app')

@section('title')
    Blog Post by {{$category}} | VeltoPHP
@endsection

@section('content')
    <div class="container mx-auto px-4 py-36 max-w-6xl">
        <!-- Popular Category -->
        <div class="mb-20">
            <h2 class="text-2xl font-light text-gray-900 dark:text-white mb-8 border-b border-gray-200 dark:border-gray-700 pb-2">Explore Post Articles by {{$category}} </h2>
            <div class="flex flex-wrap gap-3">
                @foreach ($categories as $category)
                    <a href="#"
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-full text-sm text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 transition-colors">
                        {{ $category->category }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Recent Articles -->
        <div class="mb-16">

            <h2 class="text-2xl font-light text-gray-900 dark:text-white mb-8 border-b border-gray-200 dark:border-gray-700 pb-2">Latest Writings</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                @foreach ($posts as $post)

                <!-- Article -->
                    <article class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                        <span class="text-xs tracking-widest text-red-600 uppercase mb-2 inline-block">{{$post->category}}</span>
                        <h3 class="text-xl font-light text-gray-800 dark:text-gray-100 mb-3 hover:text-red-700 dark:hover:text-red-400 transition-colors">
                            <a href="{{ route('view.post', [$post->slug]) }}">{{$post->title}}</a>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ str_limit($post->content, 200) }}</p>
                        <div class="flex items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400">{{ $users[$post->user_id]->name }}</span>
                            <span class="mx-2 text-gray-300 dark:text-gray-600">•</span>
                            <time datetime="2023-05-28" class="text-gray-500 dark:text-gray-400">{{format($post->created_at)}}</time>
                        </div>
                    </article>

                @endforeach

            </div>

        </div>

        <!-- Newsletter -->
        <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="max-w-2xl mx-auto text-center">
                <h3 class="text-2xl font-light text-gray-900 dark:text-white mb-2">Stay updated</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Receive our latest articles and resources directly in your inbox.</p>
                <form class="flex max-w-md mx-auto">
                    <input type="email" 
                           placeholder="Your email address" 
                           class="flex-grow px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:outline-none focus:border-blue-500 rounded-l-lg text-sm">
                    <button type="submit" class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-6 py-3 rounded-r-lg text-sm hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">
                        Subscribe
                    </button>
                </form>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">We respect your privacy. Unsubscribe at any time.</p>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title')
    Insights | VeltoPHP
@endsection

@section('content')
    <div class="container mx-auto px-4 py-36 max-w-6xl">
        <!-- Hero Section -->
        <div class="mb-24 text-center">
            <h1 class="text-5xl font-light text-gray-900 dark:text-gray-100 mb-6 leading-tight">
                VeltoPHP <span class="font-medium text-red-500">Blog's</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Thoughtful perspectives on modern web development and design.
            </p>
        </div>

        <!-- Popular Category -->
        <div class="mb-20">
            <h2 class="text-2xl font-light text-gray-900 dark:text-white mb-8 border-b border-gray-200 dark:border-gray-700 pb-2">Explore Categories</h2>
            <div class="flex flex-wrap gap-3">
                @foreach ($categories as $category)
                    <a href="{{route('post.category',[$category->category, $category->category_id])}}"
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-full text-sm text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 transition-colors">
                        {{ $category->category }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Featured Post -->
        @if ($featurePost)
            <div class="mb-20 group">
                <div class="flex flex-col lg:flex-row gap-8 items-center">
                    <div class="lg:w-1/3">
                        <div class="aspect-w-16 aspect-h-9 overflow-hidden rounded-xl">
                            <img src="/{{$featurePost->image}}" 
                                alt="Featured Post" 
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </div>
                    </div>
                    <div class="lg:w-2/3">
                        <span class="text-xs tracking-widest text-red-500 dark:text-red-400 uppercase mb-2 inline-block">
                            {{ $featurePost->category()?->category }}
                        </span>
                        <h2 class="text-3xl font-light text-gray-900 dark:text-white mb-4 leading-snug">
                            <a href="{{ route('view.post', [$featurePost->slug]) }}" class="hover:text-red-600 dark:hover:text-blue-400 transition-colors">
                                {{$featurePost->title}}
                            </a>
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            {{ str_limit($featurePost->content, 200) }}
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden mr-3">
                                <img src="{{ 'https://ui-avatars.com/api/?name=' . urlencode($featurePost->user()?->name) . '&background=f3f4f6&color=111827' }}" alt="Author" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{$featurePost->user()?->name}}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{format($featurePost->created_at)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p>No featured Post found!</p>
        @endif

        

        <!-- Recent Articles -->
        <div class="mb-16">
            <h2 class="text-2xl font-light text-gray-900 dark:text-white mb-8 border-b border-gray-200 dark:border-gray-700 pb-2">Latest Writings</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($posts as $post)
                    <!-- Article -->
                    <article class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                        <span class="text-xs tracking-widest text-red-600 uppercase mb-2 inline-block">{{ $post->category()->category }}</span>
                        <h3 class="text-xl font-light text-gray-800 dark:text-gray-100 mb-3 hover:text-red-700 dark:hover:text-red-400 transition-colors">
                            <a href="{{ route('view.post', [$post->slug]) }}">{{$post->title}}</a>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ str_limit($post->content, 200) }}</p>
                        <div class="flex items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400">{{ $post->user()?->name }}</span>
                            <span class="mx-2 text-gray-300 dark:text-gray-600">•</span>
                            <time datetime="{{ $post->created_at }}" class="text-gray-500 dark:text-gray-400">{{ format($post->created_at) }}</time>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <!-- Popular Topics -->
        <div class="mb-20">
            <h2 class="text-2xl font-light text-gray-900 dark:text-white mb-8 border-b border-gray-200 dark:border-gray-700 pb-2">Explore Topics</h2>
            <div class="flex flex-wrap gap-3">
                @foreach ($topics as $topic)
                    <a href="{{route('post.topic',[$topic->topic, $topic->topic_id])}}"
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-full text-sm text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 transition-colors">
                        {{ $topic->topic }}
                    </a>
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

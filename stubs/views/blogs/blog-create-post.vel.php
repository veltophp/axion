@extends('axion::layouts.app')

@section('axion::title')
    Blog | Axion Dashboard
@endsection

@section('axion::header')
    Blog | Create Post
@endsection

@section('axion::content')

<div class="max-w-4xl mx-auto p-0 space-y-6">

    <div>@flash_errors</div>

    <form action="{{ route('submit.post') }}" enctype="multipart/form-data" method="post" class="space-y-6">
        {!! csrf_field() !!}
        
        <!-- Title -->
        <div>
            <label class="text-sm font-medium text-foreground">Post Title</label>
            <input type="text" name="title" required
                class="w-full px-4 py-3 mt-2 text-base border border-border rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="Enter title...">
        </div>

        <!-- Category & Topic -->
        <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">
            <div class="flex-1 space-y-2">
                <label class="text-sm font-medium text-foreground">Select a Category</label>
                @if ($categories)
                    <select name="category_id" required
                        class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary">
                        @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                @else
                    <p class="text-sm text-muted-foreground">No categories available</p>
                @endif
            </div>

            <div class="flex-1 space-y-2">
                <label class="text-sm font-medium text-foreground">Select a Topic</label>
                @if ($topics)
                    <select name="topic_id" required
                        class="w-full px-4 py-3 border border-border rounded-xl bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary">
                        @foreach ($topics as $topic)
                            <option value="{{ $topic->topic_id }}">{{ $topic->topic }}</option>
                        @endforeach
                    </select>
                @else
                    <p class="text-sm text-muted-foreground">No topics available</p>
                @endif
            </div>
        </div>

        <!-- WYSIWYG -->
        <div>
            <label class="block text-sm font-medium text-foreground mb-2">Content</label>
            @php echo wysiwyg('#editor', 'content') @endphp
        </div>

        <!-- Image Upload -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-foreground">Featured Image</label>
            <input type="file" name="image" id="image" class="w-full" />
            @php echo fileInput('#image','image') @endphp
        </div>

        <!-- Featured Checkbox -->
        <div>
            <label class="inline-flex items-center space-x-2 text-sm">
                <input type="checkbox" name="is_featured" value="1" class="rounded border-border text-purple-600">
                <span class="text-foreground">Mark as Featured</span>
            </label>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col md:flex-row gap-2">
            <button type="submit" name="status" value="Publish"
                class="w-full md:w-auto px-4 py-3 bg-blue-500 text-white font-semibold rounded-xl hover:bg-primary/90 transition">
                Publish Post
            </button>

            <button type="submit" name="status" value="Draft"
                class="w-full md:w-auto px-6 py-3 bg-muted text-foreground font-semibold rounded-xl hover:bg-muted/70 transition">
                Save Draft
            </button>
        </div>
    </form>
</div>
@endsection

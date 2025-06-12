<?php

namespace Velto\Axion\Controllers;

use Velto\Axion\Controller;
use Velto\Axion\App\Auth;
use Velto\Axion\Models\Blog;
use Velto\Axion\Models\User;
use Velto\Axion\Models\BlogCategory;
use Velto\Axion\Models\BlogTopic;



class BlogDashboardController extends Controller
{
    public function createPost()
    {
        $categories = BlogCategory::all();
        $topics     = BlogTopic::all();

        return view('axion::blogs.blog-create-post',[

            'categories' => $categories,
            'topics'    => $topics
        ]);
    }
    public function allPost()
    {

        $posts = Blog::where('user_id', Auth::user()->user_id)->get();

        $category = [];

        foreach ($posts as $post) {
            $users[$post->user_id] = User::where('user_id', $post->user_id)->first();
        }

        return view('axion::blogs.blog-all-post',['posts' => $posts]);
    }
    public function editPost($post_id)
    {

        $categories = BlogCategory::all();
        $topics     = BlogTopic::all();

        $post = Blog::where('post_id', $post_id)->first();

        return view('axion::blogs.blog-edit-post', [
            
            'post' => $post,
            'categories' => $categories,
            'topics'    => $topics
        
        ]);
    }
    public function deletePost($post_id)
    {
        $post = Blog::where('post_id', $post_id)->first();

        if (is_array($post)) {
            $post = $post[0] ?? null;
        }

        if (!$post) {
            flash()->error('Post not found.');
            return redirect()->route('all.post');
        }

        /**
         * Delete image from folder assets/images
         */
        if (!empty($post->image)) {

            $imagePath = real_path($post->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        Blog::delete(['post_id' => $post_id]);

        flash()->success('Post deleted successfully!');
        return redirect()->route('all.post');
    }
    public function viewPost($slug)
    {

        $post = Blog::where('slug', $slug)->first();

        if(!$post){

            abort('404');
        }

        return view('axion::blogs.blog-view-post',['post' => $post]);
    }
    public function updatePost($post_id)
    {
        $request = request()->all();
    
        $errors = validate($request, [
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'status'    => 'required|string',
            'category_id'  => 'required|string',
            'topic_id'     => 'required|string',
        ]);
            
        if (!empty($errors)) {
            flash()->error($errors);
            return redirect()->route('edit.post');
        }

    
        $image = request()->file('image');

        $hasImage = !empty($image['name']);
    
        $updatePost = [
            'post_id'       => uvid(6),
            'user_id'       => Auth::user()->user_id,
            'category_id'   => $request['category_id'],
            'topic_id'      => $request['topic_id'],
            'title'         => $request['title'],
            'slug'          => slug($request['title']),
            'content'       => $request['content'],
            'status'        => $request['status'],
            'is_featured'   => isset($request['is_featured']) ? 1 : 0,
        ];
    
        if ($hasImage) {
            $updatePost['image'] = storeImage($image)->save();
        }
    
        Blog::where('post_id', $post_id)->update($updatePost);
    
        return redirect()->route('all.post');
    }
    public function submitPost()
    {

        $request = request()->all();

        $errors = validate($request, [
            'title'         => 'required|string|max:255',
            'content'       => 'required|string',
            'status'        => 'required|string',
            'category_id'   => 'required|string',
            'topic_id'      => 'required|string',

        ]);

        if (!empty($errors)) {
            flash()->error($errors);
            return redirect()->route('create.post');

        }

        $image = request()->file('image');
        $imageUrl = storeImage($image)->save();

        $post = [
            'post_id'       => uvid(6),
            'user_id'       => Auth::user()->user_id,
            'category_id'   => $request['category_id'],
            'topic_id'      => $request['topic_id'],
            'title'         => $request['title'],
            'slug'          => slug($request['title']),
            'content'       => $request['content'],
            'image'         => $imageUrl,
            'status'        => $request['status'],
            'is_featured'   => isset($request['is_featured']) ? 1 : 0,
        ];

        Blog::create($post);

        flash()->success('Post created successfully!');
        return redirect()->route('all.post');

    }
    public function blogIndex()
    {
        $topics = BlogTopic::all();
        $categories = BlogCategory::all();
    
        $featurePost = Blog::where('is_featured', 1)
            ->where('status', 'Publish')
            ->first();
                
        $posts = Blog::where('status', 'Publish')->get();
    
        return view('axion::blogs.blog-home', [
            'posts' => $posts,
            'featurePost' => $featurePost,
            'topics' => $topics,
            'categories' => $categories,
        ]);
    }
    

}
<?php

namespace Velto\Axion\Controllers;

use Velto\Axion\Controller;
use Velto\Axion\Models\BlogCategory;
use Velto\Axion\Models\Blog;
use Velto\Axion\Models\User;



class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::all();
        return view('axion::blogs.categories.blog-categories',['categories' => $categories]);
    
    }
    public function indexCategory($category, $category_id)
    {

        $categories = BlogCategory::all();
    
        $posts = Blog::where('status', 'Publish')
        ->where('category_id', $category_id)
        ->get();

        return view('axion::blogs.blog-view-by-category', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }
    public function store()
    {
        $request = request()->all();

        $errors = validate($request, [
            'category'      => 'required|string|max:255',
            'description'   => 'required|string',
        ]);

        if (!empty($errors)) {
            flash()->error($errors);
            return to_route('categories');

        }
        
        $categories = [
            'category_id'   => uvid(6),
            'category'      => $request['category'],
            'description'   => $request['description'],
        ];

        BlogCategory::create($categories);

        flash()->success('Post category created successfully!');
        return to_route('categories');

    }
    public function destroy($category_id)
    {

        BlogCategory::delete(['category_id' => $category_id]);

        flash()->success('Category deleted successfully!');
        return to_route('categories');

    }
    public function edit($category_id)
    {

        $categories = BlogCategory::all();

        $category = BlogCategory::where('topic_id',$category_id)->first();

        return view('axion::blogs.categories.blog-edit-categories',[
            
            'categories' => $categories,
            'category' => $category
        
        ]);

    }
    public function update($category_id)
    {
        $request = request()->all();

        $updateCategory = [

            'category' => $request['category'],
            'description' => $request['description'],
        ];

        BlogCategory::where('category_id', $category_id)->update($updateCategory);

        return to_route('categories');

    }
}
<?php

namespace Velto\Axion\Controllers;

use Velto\Axion\Controller;
use Velto\Axion\Models\Blog;
use Velto\Axion\Models\BlogTopic;

class BlogTopicController extends Controller
{
    public function index()
    {
        $topics = BlogTopic::all();
        return view('axion::blogs.topics.blog-topics', ['topics' => $topics]);
    }

    public function indexTopic($topic, $topic_id)
    {

        $topics = BlogTopic::all();
    
        $posts = Blog::where('status', 'Publish')
        ->where('topic_id', $topic_id)
        ->get();

        return view('axion::blogs.blog-view-by-topic', [
            'posts' => $posts,
            'topics' => $topics
        ]);
    }
    public function store()
    {
        $request = request()->all();

        $errors = validate($request, [
            'topic'         => 'required|string|max:255',
            'description'   => 'required|string',
        ]);

        if (!empty($errors)) {
            flash()->error($errors);
            return to_route('topics');
        }
        
        $topics = [
            'topic_id'      => uvid(6),
            'topic'         => $request['topic'],
            'description'   => $request['description'],
        ];

        BlogTopic::create($topics);

        flash()->success('Post topic created successfully!');
        return to_route('topics');
    }
    public function destroy($topic_id)
    {
        BlogTopic::delete(['topic_id' => $topic_id]);

        flash()->success('Topic deleted successfully!');
        return to_route('topics');
    }
    public function edit($topic_id)
    {
        $topics = BlogTopic::all();
        $topic  = BlogTopic::where('topic_id', $topic_id)->first();

        return view('axion::blogs.topics.blog-edit-topics', [
            'topics' => $topics,
            'topic' => $topic
        ]);
    }
    public function update($topic_id)
    {
        $request = request()->all();

        $updateTopic = [
            'topic'    => $request['topic'],
            'description' => $request['description'],
        ];

        BlogTopic::where('topic_id', $topic_id)->update($updateTopic);

        return to_route('topics');
    }
}

<?php

namespace Velto\Axion\Models;

use Velto\Axion\Model;

class Blog extends Model
{
 
    protected string $table = 'blogs';

    protected array $fillable = [
        'post_id',
        'user_id',
        'category_id',
        'topic_id',
        'title',
        'content',
        'image',
        'slug',
        'is_featured',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'category_id');
    }

    public function topic()
    {
        return $this->belongsTo(BlogTopic::class, 'topic_id', 'topic_id');
    }

}
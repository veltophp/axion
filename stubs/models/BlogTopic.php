<?php

namespace Velto\Axion\Models;

use Velto\Axion\Model;

class BlogTopic extends Model
{
    protected string $table = 'blog_topics';

    protected array $fillable = ['topic_id','topic','description'];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'topic_id', 'topic_id');
    }
}
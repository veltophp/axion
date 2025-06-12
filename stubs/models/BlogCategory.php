<?php

namespace Velto\Axion\Models;

use Velto\Axion\Model;

class BlogCategory extends Model
{
    
    protected string $table = 'blog_categories';

    protected array $fillable = ['category_id', 'category', 'description'];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id', 'category_id');
    }
}
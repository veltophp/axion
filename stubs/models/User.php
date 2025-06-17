<?php

namespace Velto\Axion\Models;

use Velto\Axion\Model;

class User extends Model
{

    protected string $table = 'users';

    protected array $fillable = ['user_id','name','bio','picture','role','email','password','email_verified'];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id', 'user_id');
    }
}
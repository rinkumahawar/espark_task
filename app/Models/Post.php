<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = [
        'user_id',
        'description'
    ];
    protected $guarded = array();

    public function Images()
    {
        return $this->hasMany('App\Models\Image');
    }
    public function Comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}

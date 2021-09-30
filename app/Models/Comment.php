<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'image'
    ];
    public function getUserName($user_id)
    {
    	$name = User::select('name')->find($user_id)->name;
    	return $name;
    }
    public function Replies()
    {
        return $this->hasMany('App\Models\Reply');
    }
    public function getImageAttribute($value)
	{	

	    if ($value) {
	        return asset('comment/'.$value);
	    } else {
	        return null;
	    }
	}
    
}
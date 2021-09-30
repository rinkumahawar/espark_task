<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $table = 'replies';
    protected $fillable = [
        'type',
        'user_id',
        'comment_user_id',
        'reply_comment_id',
        'comment_id',
        'comment',
        'image'
    ];
    public function getUserName($user_id)
    {
    	$name = User::select('name')->find($user_id)->name;
    	return $name;
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

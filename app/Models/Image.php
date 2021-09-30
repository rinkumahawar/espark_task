<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $guarded = array();


    public function storeData($input)
    {
        return static::create($input);
    }
    public function getNameAttribute($value)
	{	

	    if ($value) {
	        return asset('post/'.$value);
	    } else {
	        return asset('post/no-image.jpg');
	    }
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];

    public function category()
    {
    	return $this->belongsTo('App\Models\Category');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function revision()
    {
    	return $this->hasMany('App\Models\Revision');
    }
}

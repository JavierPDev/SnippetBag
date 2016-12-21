<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Snippet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'text', 'syntax', 'tags', 'title', 'description'
    ];

    public function user()
    {
      return $this->belongsTo('App\User');
    }
    
    public function tags()
    {
      return $this->morphToMany('App\Tag', 'taggable');
    }
}

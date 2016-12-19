<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
    protected $fillable = [
        'text', 'syntax', 'tags'
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

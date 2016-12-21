<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Snippet extends Model
{
    use SoftDeletes;
    use Sluggable;

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

		/**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
      return [
        'slug' => [
          'source' => 'title',
          'unique' => true,
        ]
      ];
    }
}

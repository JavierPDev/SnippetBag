<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Laravel\Scout\Searchable;

class Snippet extends Model
{
    use SoftDeletes;
    use Sluggable;
    use Searchable;

    protected $fillable = [
        'text', 'syntax', 'tags', 'title', 'description', 'public',
    ];

    /**
     * Return true if snippet can be viewed by input user
     *
     * @param  App\User  $user
     * @return bool
     */
    public function canBeViewedBy($user)
    {
      return $this->public || 
        ($user && ($user->is_admin || $user->id === $this->user_id));
    }
    

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

		/**
		 * Get the route key for the model.
		 *
		 * @return string
		 */
		public function getRouteKeyName()
		{
			return 'slug';
		}
}

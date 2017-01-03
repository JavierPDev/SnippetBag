<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cviebrock\EloquentSluggable\Sluggable;

class User extends Authenticatable
{
    use Notifiable;
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'social_id', 'social_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function snippets()
    {
      return $this->hasMany('App\Snippet');
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
          'source' => 'name',
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

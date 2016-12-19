<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  public function snippets()
  {
    return $this->morphedByMany('App\User', 'taggable');
  }
}

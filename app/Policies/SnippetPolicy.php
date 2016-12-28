<?php

namespace App\Policies;

use App\User;
use App\Snippet;
use Illuminate\Auth\Access\HandlesAuthorization;

class SnippetPolicy
{
    use HandlesAuthorization;

		public function before($user, $ability)
		{
				if ($user->is_admin) {
						return true;
				}
		}

    /**
     * Determine whether the user can view the snippet.
     *
     * @param  \App\User  $user
     * @param  \App\Snippet  $snippet
     * @return mixed
     */
    public function view(User $user, Snippet $snippet)
    {
      return $snippet->public || $user->id == $snippet->user_id;
    }

    /**
     * Determine whether the user can create snippets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the snippet.
     *
     * @param  \App\User  $user
     * @param  \App\Snippet  $snippet
     * @return mixed
     */
    public function update(User $user, Snippet $snippet)
    {
        //
    }

    /**
     * Determine whether the user can delete the snippet.
     *
     * @param  \App\User  $user
     * @param  \App\Snippet  $snippet
     * @return mixed
     */
    public function delete(User $user, Snippet $snippet)
    {
      return $user->id == $snippet->user_id;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Snippet;

class AdminController extends Controller
{
    const PAGE_SIZE = 10;

    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Display a listing of snippets.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function snippet_index(Request $request)
    {
      if ($search_term = $request->search_term)
      {
        $snippets = Snippet::search($search_term)
                      ->orderBy('created_at', 'desc')
                      ->paginate(self::PAGE_SIZE)
                      ->appends($request->input());
      }
      else
      {
        $snippets = Snippet::orderBy('created_at', 'desc')
                      ->paginate(self::PAGE_SIZE)
                      ->appends($request->input());
      }

      $is_admin_route = true;

      $request->session()->put('redirect', '/admin/snippets');

      return view('snippets.index', compact('snippets', 'search_term', 'is_admin_route'));
    }

    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_index(Request $request)
    {
      $users = User::orderBy('created_at', 'desc')
                    ->paginate(self::PAGE_SIZE);

      return view('users.index', compact('users'));
    }

    /**
     * Display edit form for user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function user_edit(User $user)
    {
      return view('users.edit', compact('user'));
    }
    
}

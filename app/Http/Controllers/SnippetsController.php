<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Snippet;
use App\Http\Requests;

class SnippetsController extends Controller
{
    const PAGE_SIZE = 10;

    public function __construct()
    {
      $this->middleware('auth')->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if ($search_term = $request->search_term)
      {
        // TODO: Where clause does not take effect. Seems to be a problem with
        //        laravel scout. See:
        // http://laravel.io/forum/12-07-2016-laravel-scout-where-clause-not-working-as-expected
        $snippets = Snippet::search($search_term)
                      ->where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->paginate(self::PAGE_SIZE)
                      ->appends($request->input());
      }
      else
      {
        $snippets = Snippet::whereUserId(Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->paginate(self::PAGE_SIZE)
                      ->appends($request->input());
      }

      return view('snippets.index', compact('snippets', 'search_term'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('snippets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\SnippetWriteRequest $request)
    {
      $snippet = $request->all();
      $file = $request->file('file');

      if ($file)
      {
        $snippet['text'] = file_get_contents($file->getRealPath());
      }
      if (!$file && !$snippet['text'])
      {
        $request->session()->flash('flash_message', 'Snippet is required');
        $request->session()->flash('message_type', 'danger');

        return redirect('/snippets/create')->withInput();
      }

      $snippet = Auth::user()->snippets()->create($snippet);

      return redirect('/snippets/'.$snippet->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  \App\Snippet $snippet
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Snippet $snippet)
    {
      $user = Auth::user();

      if($this->is_unauthorized($snippet, $user, $request))
      {
        return redirect('/snippets');
      }

      $back = url()->previous();
      $user = $snippet->user;

      return view('snippets.show', compact('snippet', 'back', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Snippet $snippet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Snippet $snippet)
    {
      $user = Auth::user();

      if($this->is_unauthorized($snippet, $user, $request))
      {
        return redirect('/snippets');
      }

      $snippet->delete();

      $request->session()->flash('flash_message', 'Deleted snippet');
      $request->session()->flash('message_type', 'info');

      return redirect("/snippets");
    }

    /**
     * Check if user is authorized for operation.
     *
     * @param  \App\Snippet  $snippet
     * @param  \App\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function is_unauthorized($snippet, $user, $request)
    {
      $not_admin = !$user || !$user->is_admin;
      $not_owner = $snippet->user->id !== $user['id'];

      if (!$snippet->public && $not_admin && $not_owner)
      {
          $request->session()->flash('flash_message', 'Not authorized');
          $request->session()->flash('message_type', 'warning');

          // If they're not logged in they will be redirected yet again
          // to login page since /snippets is restricted
          return true;
      }

      return false;
    }
}

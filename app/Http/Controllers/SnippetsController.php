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
      $snippets = Snippet::whereUserId(Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(self::PAGE_SIZE)
                    ->appends($request->input());

      $search_term = null;
      $is_admin_route = false;

      $request->session()->put('redirect', '/snippets');

      return view('snippets.index', compact('snippets', 'search_term', 'is_admin_route'));
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

      if(!$snippet->canBeViewedBy($user))
      {
        abort('401');
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
      $this->authorize('delete', $snippet);

      $snippet->delete();

      $request->session()->flash('flash_message', 'Deleted snippet');
      $request->session()->flash('message_type', 'info');

      $redirect = $request->session()->pull('redirect', null);

      return redirect($redirect);
    }
}

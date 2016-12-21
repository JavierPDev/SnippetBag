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
      $this->middleware('auth', ['except' => ['show']]);
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

      return view('snippets.index', compact('snippets'));
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

      if ($file = $request->file('file'))
      {
        $snippet['text'] = file_get_contents($file->getRealPath());
      }

      $snippet = Auth::user()->snippets()->create($snippet);

      return redirect('/snippets/'.$snippet->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  str  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
      $snippet = Snippet::whereSlug($slug)->first();
      $back = url()->previous();

      return view('snippets.show', compact('snippet', 'back'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Snippet::find($id)->delete();
      $user_id = Auth::id();

      return redirect("/snippets?user=".$user_id);
    }
}

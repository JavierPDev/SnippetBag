<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Http\Requests;

class UsersController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      $user = Auth::user();

      return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserWriteRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UserWriteRequest $request, User $user)
    {
      $user->name = $request->name;
      $user->email = $request->email;
      $user->theme = $request->theme;

      if ($pass = $request->password)
      {
        $user->password = bcrypt($pass);
      }

      $user->update();

      $request->session()->flash('flash_message', 'User updated successfully');
      $request->session()->flash('message_type', 'success');

      return redirect('/snippets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
      if (!Auth::user() || ((Auth::id() != $user->id) && (!Auth::user()->is_admin)))
      {
        abort(401);
      }

      $user->delete();

      $request->session()->flash('flash_message', 'Deleted user');
      $request->session()->flash('message_type', 'info');

      if (Auth::user()->is_admin)
      {
        return redirect('/admin/users');
      }
      else
      {
        return redirect('/');
      }
    }
}

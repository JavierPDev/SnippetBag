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
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UserWriteRequest $request)
    {
      $user = User::findOrFail(Auth::id());
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

      return view('users.edit', compact('user'));
    }
}

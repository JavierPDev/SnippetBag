<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;

use App\Http\Controllers\Controller;
use App\User;

class SocialAuthController extends Controller
{
    const SOCIAL_TYPE = 'google';

    /**
     * Redirect the user to the Google authentication page.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request)
    {
      return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google authentication. 
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
      $google_user = Socialite::driver('google')->user();

      $local_user = User::where('social_id', $google_user->getId())
                          ->where('social_type', self::SOCIAL_TYPE)
                          ->first();

      // Create user if it doesn't exist
      if (!$local_user)
      {
        $local_user = $this->createUserWithSocialDetails($google_user);
      }

      Auth::loginUsingId($local_user->id, true);

      return redirect('/home');
    }

    private function createUserWithSocialDetails($google_user)
    {
      return User::create([
        'name' => $google_user->getName(),
        'email' => $google_user->getEmail(),
        'social_id' => $google_user->getId(),
        'social_type' => self::SOCIAL_TYPE,
        'password' => bcrypt($google_user->token),
      ]);
    }
}

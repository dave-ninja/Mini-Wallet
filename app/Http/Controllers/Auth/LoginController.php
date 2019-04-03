<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
     
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }
    
    private function findOrCreateUser($user, $provider)
    {
        $authUserProv = User::where('provider_id',$user->id)->first();
        $authUserEmail = User::where('email',$user->email)->first();
        if($authUserProv) {
            $upt = User::where('provider_id', $user->id)->update(['name' => $user->name,'provider' => strtoupper($provider)]);
            if($upt) return $authUserProv;
            return $authUserProv;
        }
        elseif ($authUserEmail) {
            $upt = User::where('email', $user->email)->update(['name' => $user->name,'provider' => strtoupper($provider)]);
            if($upt) return $authUserEmail;
        }
        if(is_null($user->name)) $user->name = $user->email;
        return User::create([
            'name'        => $user->name,
            'email'       => $user->email,
            'provider'    => strtoupper($provider),
            'provider_id' => $user->id
        ]);
    }
}

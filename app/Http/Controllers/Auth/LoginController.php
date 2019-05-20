<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\User;
use App\Http\Controllers\CookieController as Cookie;

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
    protected $redirectTo = '/accueil';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $login = Auth::attempt([
            'email' => request('email'),
            'password' => request('password')
        ]);

        if($login){
            $name=User::getUser()->firstName;
            Cookie::setAlert('success','Bonjour '.$name.', ravi de vous revoir !');
            return redirect()->route('home');
        }
        return redirect()->route('login')->withInput($request->except('password'))->withErrors(['email' => "Email ou mot de passe incorrect",]);
    }


    public function logout()
    {
      Auth::logout();
      Cookie::setAlert('info','Vous êtes à présent déconnecté');
      return redirect()->route('home');
    }
}

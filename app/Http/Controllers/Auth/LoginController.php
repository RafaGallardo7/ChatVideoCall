<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

// use Illuminate\Http\Request;

use App\Models\User;

use Request;
use Redirect;
use Image;
use Helpers;
use URL;
use Auth;
use View;
use Hash;
use Session;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        $items = $request::validate([           
            'email' => 'exists:users,email|required|string|email|max:255',            
            'password' => 'required|string|min:6'            
        ]);
                
        $data = Request::all();                

        $user = User::where([
            'email' => $data['email'],
            'password' => $data['password']
        ])->first();

        
        if($user) {
            Auth::login($user);        
            return Redirect::to('/chat/1');
        }
        
    }
    
    public function logout() {
        Session::flush();
        Auth::logout();        
        return Redirect::to('/');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\TeamInvitation;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Propaganistas\LaravelFakeId\Facades\FakeId;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $email = $request->email;

        if($email !== 'joanbojchev@gmail.com') return abort(403);

        if (Auth::attempt ([ 'email' => $email, 'password' => $request->password ])) {
            session([ 'email' => $email ]);

            /* go to the requested page that requires login ( usually if link is clicked in email)
             or go to home route if no page is requested (by default)*/
             
             return redirect()->to('/');

        } else {
            $errors = [
                'email' => "Invalid Credentials. Please try again."
            ];
            
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function showLoginForm(Request $request)
    {
        return view('auth.login');
    }


    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}

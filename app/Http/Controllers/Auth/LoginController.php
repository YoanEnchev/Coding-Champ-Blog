<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\TeamInvitation;
use App\Models\User;
use App\Repositories\TechEntityRepository;
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
    public function __construct(TechEntityRepository $techEntityRepo)
    {
        $this->middleware('guest')->except('logout');
        $this->techEntityRepo = $techEntityRepo;
    }

    public function login(Request $request)
    {
        $email = $request->email;

        // Allow only for one user to login for now.
        if($email !== config('auth.admin_email')) return redirect()->back()->withError("Accessible only from admin.")->withInput();

        if (Auth::attempt([ 'email' => $email, 'password' => $request->password ])) {
            session([ 'email' => $email ]);

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
        $techEntities = $this->techEntityRepo->getAll();

        return view('auth.login', compact('techEntities'));
    }


    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}

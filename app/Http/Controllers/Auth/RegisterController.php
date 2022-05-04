<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Auth, Exception;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\TechEntityRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, TechEntityRepository $techEntityRepository)
    {
        $this->middleware('guest');
        $this->userRepository = $userRepository;
        $this->techEntityRepository = $techEntityRepository;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required | email',
            'username' => 'required | string | max:80',
            // It's said that bcrypt algorithm is reliable only for password shorter than 80 symbols.
            'password' => 'required | string | max:80',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->email;
        $username = $request->username;

        if($this->userRepository->findByEmail($email) !== null) {
            return redirect()->back()->withErrors(['email' => 'Email is already taken.'])->withInput();
        }

        if($this->userRepository->findByUsername($username) !== null) {
            return redirect()->back()->withErrors(['username' => 'Username is already taken.'])->withInput();
        }

        try {
            $user = $this->userRepository->create([
                'username' => $username,
                'email' => $email,
                'password' => bcrypt($request->password)
            ]);

            Auth::login($user);
        }
        catch (Exception $ex) {
            return redirect()->back()->withError("Registration failed")->withInput();
        }

        return redirect()->route('home');
    }

    public function showRegistrationForm(Request $request)
    {
        $techEntities = $this->techEntityRepository->getAll();

        return view('auth.register', compact('techEntities'));
    }
}

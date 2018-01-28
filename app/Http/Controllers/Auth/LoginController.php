<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    //	protected $redirectTo = '/home';

    protected $redirectPath = 'bko.home';
    protected $loginPath = 'login';
    protected $redirectAfterLogout = 'login';
    protected $redirectTo = 'bko.home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return route($this->redirectPath);
        }

        return property_exists($this, 'redirectTo') ? route($this->redirectTo) : '/';
    }

    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? route($this->loginPath) : '/auth/login';
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect(property_exists($this, 'redirectAfterLogout') ? route($this->redirectAfterLogout) : '/');
    }
}

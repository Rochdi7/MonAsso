<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect users to this path after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Use 'phone' instead of the default 'email' for login.
     */
    public function username()
    {
        return 'phone';
    }

    /**
     * Optional: Override guard if you're using a custom guard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Ensure user is redirected to dashboard explicitly.
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect($this->redirectTo);
    }
}

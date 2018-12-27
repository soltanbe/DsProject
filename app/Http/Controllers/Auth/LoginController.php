<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    //override this method to use username
    public function username()
    {
        return 'username';
    }
    //override this method to implamet log
    public function authenticate(Request $request)
    {
        $requestd=$request->all();
        $clientIP = \Request::ip();
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            DB::table('user_log')->insert(array(
                'username'=>$requestd['username'],
                'status_logon'=>1,
                'ip'=>$clientIP,
                'last_login'=>date('Y-m-d h:i:s'),
            ));
            return redirect()->intended('dashboard');
        }else{
            DB::table('user_log')->insert(array(
                'username'=>$requestd['username'],
                'status_logon'=>0,
                'ip'=>$clientIP
            ));
        }
    }

}

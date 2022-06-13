<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Role;
use App\Visitor;
use  Illuminate\Support\Carbon;

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


    public function authenticated($request, $user)
    {
        $role = $user->role;
        if ($role->name == 'admin') {
            $this->redirectTo = 'admin';
        } else if ($role->name == 'manager') {
            $this->redirectTo = 'manager';
        } else if ($role->name == 'client') {
            $this->redirectTo = 'client';
        }
    }
    public function all(Request $request ){
        $input = $request->all();
        if( isset( $request->qrvarification ) ){
            try {
                $visitor = Visitor::where( 'uni_id', "=", $request->qrvarification )->where( "checked_in", "=", null )->first();
                if( $visitor ){
                    $input['checked_in'] = 1;
                    $datetime = Carbon::now();
                    $input[ 'checkin_time' ] = $datetime->toDateTimeString();
                    $visitors = $visitor->update($input);
                    $visitors = ['Yes' => 1];
                    return view( 'auth/thankyou', compact( 'visitors' ) );
                }else{
                    return view( 'auth/thankyou' );
                }
            } catch ( \Exception $ex ) {
                return view( 'auth/thankyou' );
            }
        }
    }
}

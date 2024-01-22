<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function index() {
        return view('admin.login');
    }

    public function authenticate(Request $request) {
        
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]); 

        if ($validator->passes()) {
            
            if (Auth::guard('admin')->attemp(['email' => $request->email, 'password' => $request->password],$request->get('remember'))){

                return redirect()->route('admin.dashboard');
                
            } else {
                return redirect()->route('admin.login')->with('error', 'Either Email/Password is incorrect');
            }
        
        } else {
            return redirect()->route('admin.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }
}

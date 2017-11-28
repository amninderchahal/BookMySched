<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class AuthController extends Controller
{
    public function login(Request $request){

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $res = $this->postData('/api/login', $request->all());

        $code = $res->getStatusCode();
        $data = json_decode($res->getBody(), true);

        if($code==202){

            return view('auth.login')->with('msg',$data['error']);
        }
        else if($code==203){

            session()->regenerate();
            session([
                'id'=> $data['id'],
                'firstname'=> $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'role'=> $data['role'],
                'role_id'=> $data['role_id'],
                'organization_id'=> $data['organization_id'],
                'is_authenticated' => true
            ]);

            return redirect('/home');
        }
    }

    public function logout(){

        session()->flush();
        return view('welcome');
    }

    public function forgotPassword(Request $request){

        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $data['email'] = $request->input('email');

        $res = $this-> postData('/api/forgotpassword', $data);

        $code = $res->getStatusCode();
        $data = json_decode($res->getBody(), true);

        if($code==202)
        {
            return view('auth.forgotpassword')->with('msg',$data['error']);
        }
        else if($code==203)
        {
            return view('auth.login')->with('msg', $data['msg']);
        }
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|min:6',
            'new_password' => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required|min:6'
        ]);

        $res = $this-> postData('/api/changepassword', $request->all());

        $code = $res->getStatusCode();
        $data = json_decode($res->getBody(), true);

        if($code==202)
        {
            return view('auth.changepassword')->with('msg',$data['error']);
        }
        else if($code==203)
        {
            return view('auth.changepassword')->with('msg',$data['msg']);
        }
    }
}

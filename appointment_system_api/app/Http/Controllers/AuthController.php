<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Person;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = Person::where('email', $request->input('email'))
                          ->first();

        if (!$user){

            return response()->json([
               'error' =>'This email does not exist in our record'
            ],202);
        }

        else if (!password_verify($request->input('password'), $user->password)){

            return response()->json([
               'error' => 'Incorrect Password'
            ],202);
        }
        else{

            return response()->json([
                'id' => $user->id,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'role' => $user->role->name,
                'role_id' => $user->role_id,
                'organization_id' => $user->organization_id,
            ],203);

        }
    }

    public function forgotPassword(Request $request){

        $user = Person::where('email', $request->input('email'))
                          ->first();

        if (!$user)
        {
            return response()->json([
               'error' =>'This email does not exist in our record'
            ],202);
        }
        else{
            $password = str_random(8);
            $to = $request->input('email');
            $subject = "New password generated";
            $txt = "We received a password reset request for this email address. Kindly use the password given below to log in.\n\n New password:".$password."\nYou can change this password once you log in.";

            mail($to,$subject,$txt);

            $user->password = password_hash($password, PASSWORD_BCRYPT);
            $user->save();

            return response()->json([
               'msg' =>'New password sent. Please check your email.'
            ],203);
        }
    }

    public function changePassword(Request $request){

        $email = $request->input('email');
        $current_password = $request->input('current_password');
        $new_password = $request->input('new_password');

        $user = Person::where('email', $email)
                          ->first();

        if ($user)
        {
            if(password_verify($current_password, $user->password))
            {
                $user->password = password_hash($new_password, PASSWORD_BCRYPT);
                $user->save();

                return response()->json([
                   'msg' =>'Password Changed'
                ],203);
            }
            else
            {
                return response()->json([
                   'error' =>'Current password is incorrect'
                ],202);
            }
        }
        else{
            return response()->json([
                   'error' =>'Something went wrong'
                ],202);
        }
    }
}

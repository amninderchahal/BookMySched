<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\Organization;

class AdminController extends Controller
{
    public function index($org_id){

        $admins = Person::where('role_id', 2)
                        ->where('organization_id', $org_id)
                        ->paginate(20);

        $organization = Organization::find($org_id);

        return response()->json([
           'admins' => $admins,
           'organization'=>$organization
        ]);
    }

    public function get($id){

        try{
            $admin = Person::where('role_id',2)
                             ->find($id);
        }
        catch(Exception $e){
            return response()->json([
               'error' => $e
            ],500);
        }

        return response()->json([
           'admin' => $admin
        ]);
    }

    public function trashed($org_id){

        $admins = Person::onlyTrashed()
                        ->where('role_id', 2)
                        ->where('organization_id', $org_id)
                        ->paginate(20);

        $org_id = Person::onlyTrashed()
                        ->where('role_id', 2)
                        ->pluck('organization_id')
                        ->toArray();

        $organizations = Organization::find($org_id);

        return response()->json([
           'admins' => $admins,
           'organizations'=>$organizations
        ]);
    }

    public function restore($id){

        $org_id = Person::onlyTrashed()
                        ->where('role_id', 2)
                        ->pluck('organization_id')
                        ->toArray();

        $organizations = Organization::find($org_id);

        try{
            $admin = Person::onlyTrashed()
                           ->where('id',$id)
                           ->where('role_id', 2)
                           ->restore();
        }
        catch(Exception $e){
            return response()->json([
               'error' => $e,
               'organizations'=>$organizations
            ],500);
        }

        return response('success', 200);
    }

    public function delete($id){

        try{
           $person = Person::where('role_id', 2)
                            ->find($id);
            $person->delete();
        }
        catch(\Exception $e){
            return response()->json([
               'error' => $id
            ],500);
        }

        return response('success', 200);
    }

    public function update(Request $request, $id){

        try{
            $admin = Person::where('role_id', 2)
                           ->find($id);

            $admin->firstname = $request->input('firstname');
            $admin->lastname = $request->input('lastname');
            $admin->email = $request->input('email');
            $admin->organization_id = $request->input('organization_id');
            $admin->role_id = $request->input('role_id');
            $admin->street = $request->input('street');
            $admin->city = $request->input('city');
            $admin->country = $request->input('country');
            $admin->postal_code = $request->input('postal_code');
            $admin->phone_number = $request->input('phone_number');
            $admin->save();
        }
        catch(\Exception $e){
            return response()->json([
               'error' => $e
            ],500);
        }

        return response('success', 200);
    }

    public function add(Request $request){

        $admin = Person::where('email', $request->input('email'))
                                    ->get();

        if(!$admin->isEmpty()){

           return response()->json([
               'error' => 'This email already exists in our records'
            ],500);
        }

        try{
            $admin = new Person;

            $admin->firstname = $request->input('firstname');
            $admin->lastname = $request->input('lastname');
            $admin->email = $request->input('email');
            $admin->password = password_hash($request->input('password'), PASSWORD_BCRYPT);
            $admin->organization_id = $request->input('organization_id');
            $admin->role_id = $request->input('role_id');
            $admin->street = $request->input('street');
            $admin->city = $request->input('city');
            $admin->country = $request->input('country');
            $admin->postal_code = $request->input('postal_code');
            $admin->phone_number = $request->input('phone_number');
            $admin->save();
        }
        catch(Exception $e){
            return response()->json([
               'error' => $e
            ],500);
        }

        return response('success', 200);
    }
}

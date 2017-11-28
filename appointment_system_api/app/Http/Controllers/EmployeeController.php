<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\Organization;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index($org_id){

        $employees = Person::where('role_id', 3)
                        ->where('organization_id', $org_id)
                        ->paginate(20);

        $organization = Organization::find($org_id);

        return response()->json([
           'employees' => $employees,
           'organization'=>$organization
        ]);
    }

    public function get($id){

        $employee = Person::where('role_id',3)
                          ->find($id);

        return response()->json([
           'employee' => $employee
        ]);
    }

    public function update(Request $request, $id){

        try{
            $employee = Person::where('role_id', 3)
                           ->find($id);

            $employee->firstname = $request->input('firstname');
            $employee->lastname = $request->input('lastname');
            $employee->email = $request->input('email');
            $employee->organization_id = $request->input('organization_id');
            $employee->role_id = $request->input('role_id');
            $employee->street = $request->input('street');
            $employee->city = $request->input('city');
            $employee->country = $request->input('country');
            $employee->postal_code = $request->input('postal_code');
            $employee->phone_number = $request->input('phone_number');
            $employee->save();
        }
        catch(Exception $e){
            return response()->json([
               'error' => $e
            ],500);
        }

        return response('success', 200);
    }

     public function delete($id){

        try{
            Person::destroy($id);
        }
        catch(Exception $e){
            return response()->json([
               'error' => $e
            ],500);
        }

        return response('success', 200);
    }

    public function trashed($org_id){

        $employees = Person::onlyTrashed()
                           ->where('role_id', 3)
                           ->where('organization_id', $org_id)
                           ->paginate(20);

        $organization = Organization::find($org_id);

        return response()->json([
           'employees' => $employees,
           'organization'=>$organization
        ]);
    }
    public function restore($id){

        $org_id = Person::onlyTrashed()
                        ->where('role_id', 3)
                        ->pluck('organization_id')
                        ->toArray();

        $organizations = Organization::find($org_id);

        try{
            Person::onlyTrashed()
                  ->where('id',$id)
                  ->where('role_id', 3)
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

    public function add(Request $request){

        $employee = Person::where('email', $request->email)
                                    ->get();

        if(!$employee->isEmpty()){

           return response()->json([
               'error' => 'This email already exists in our records'
            ],500);
        }
        try{
            $employee = new Person;

            $employee->firstname = $request->input('firstname');
            $employee->lastname = $request->input('lastname');
            $employee->email = $request->input('email');
            $employee->password = Hash::make($request->input('password'));
            $employee->organization_id = $request->input('organization_id');
            $employee->role_id = $request->input('role_id');
            $employee->street = $request->input('street');
            $employee->city = $request->input('city');
            $employee->country = $request->input('country');
            $employee->postal_code = $request->input('postal_code');
            $employee->phone_number = $request->input('phone_number');
            $employee->save();
        }
        catch(\Exception $e){
            return response()->json([
               'error' => $e
            ],500);
        }

        return response('success', 200);
    }
}

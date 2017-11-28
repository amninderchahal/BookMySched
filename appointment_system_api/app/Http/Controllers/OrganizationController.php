<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Organization;
use App\Person;
use App\Address;
use App\Organization_address;
use Illuminate\Support\Facades\DB;


class OrganizationController extends Controller
{
    public function index(){

        $organizations = Organization::paginate(20);

        return response()->json([
           'organizations' => $organizations
        ]);
    }

    public function get($id){

        try{
            $organization = Organization::find($id);
        }
        catch(Exception $e){
            return response()->json([
               'error' => $e
            ],500);
        }

        return response()->json([
           'organization' => $organization
        ]);
    }
    public function getAll()
    {
        $organizations = Organization::get();

        return response()->json([
           'organizations' => $organizations
        ]);
    }
    public function trashed(){

        $organizations = Organization::onlyTrashed()
                                     ->paginate(15);

        return response()->json([
           'organizations' => $organizations
        ]);
    }

    public function delete($id){

        try{
            $organization = Organization::where('id',$id)
                                        ->delete();

            $address_Id = Organization_address::where('organization_id', $id)
                                                        ->pluck('address_id')->toArray();

            $addresses = Address::whereIn('id', $address_Id)
                                ->delete();

            $organization_address = Organization_address::where('organization_id', $id)
                                                        ->delete();

        }
        catch(Exception $e){
            return response()->json([
               'error' => $e
            ],500);
        }

        return response('success', 200);
    }

    public function restore($id){

        try{
            $organization = Organization::onlyTrashed()
                                     ->where('id',$id)
                                     ->restore();
        }
        catch(Exception $e){
            return response()->json([
               'error' => $e
            ],500);
        }

        return response('success', 200);
    }

    public function add(Request $request){

        $organization = Organization::where('name', $request->input('name'))
                                    ->get();

        if(!$organization->isEmpty()){

           return response()->json([
               'error' => 'Organization name already taken'
            ],500);
        }

        try{
            DB::select("CALL add_organization_proc (?, ?, ?, ?, ?, ?)",array(
                  $request->input('name'),
                  $request->input('street'),
                  $request->input('city'),
                  $request->input('country'),
                  $request->input('postal_code'),
                  $request->input('phone_number')));
        }
        catch(Exception $e){
            return response()->json([
               'error' => $e
            ],500);
        }

        return response('success', 200);
    }

    public function update(Request $request, $id){

        try{
            $organization = Organization::where('id',$id)
                                        ->first();
            $organization->name = $request->input('name');
            $organization->save();
        }
        catch(Exception $e){
            return response()->json([
               'error' => $e
            ],500);
        }

        return response('success', 200);
    }

    public function getAdminOrg($id){

        $admin = Person::where('role_id', 2)
                        ->find($id);

        $organization = Organization::where('id', $admin->organization_id)
                                    ->paginate(15);

        return response()->json([
           'organizations' => $organization
        ]);
    }
}

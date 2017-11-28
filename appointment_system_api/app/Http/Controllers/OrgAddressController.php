<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organization;
use App\Address;
use App\Organization_address;

class OrgAddressController extends Controller
{
    public function get($org_id, $id){

        $organization = Organization::where('id', $org_id)
                                ->get();

        $address = Address::where('id', $id)->get();

        return response()->json([
           'address' => $address,
           'organization'=>$organization
        ]);
    }

    public function getAllAddress($id){

        $organization = Organization::where('id', $id)
                                ->get();

        $address_Id = Organization_address::where('organization_id',$id)
                                          ->pluck('address_id')->toArray();

        $addresses = Address::whereIn('id', $address_Id)->get();

        return response()->json([
           'addresses' => $addresses,
           'organization'=>$organization
        ]);
    }

    public function getTrashedOrgAddress($id){

        $organization = Organization::onlyTrashed()
                                ->where('id', $id)
                                ->get();

        $address_Id = Organization_address::onlyTrashed()
                                          ->where('organization_id',$id)
                                          ->pluck('address_id')->toArray();

        $addresses = Address::onlyTrashed()
                             ->find($address_Id);

        return response()->json([
           'addresses' => $addresses,
           'organization'=>$organization
        ]);
    }
    public function trashed($id){

        $organization = Organization::find($id);

        $address_Id = Organization_address::onlyTrashed()
                                          ->where('organization_id',$id)
                                          ->pluck('address_id')->toArray();

        $addresses = Address::onlyTrashed()
                            ->find($address_Id);

        return response()->json([
           'addresses' => $addresses,
           'organization'=>$organization
        ]);
    }
    public function add(Request $request, $id){

        $address = new Address;
        $address->street = $request->input('street');
        $address->city = $request->input('city');
        $address->country = $request->input('country');
        $address->postal_code = $request->input('postal_code');
        $address->phone_number = $request->input('phone_number');
        $address->save();

        $organization_address = new Organization_address;
        $organization_address -> organization_id = $id;
        $organization_address -> address_id = $address->id;
        $organization_address -> save();

        return response('success', 200);
    }

    public function update(Request $request, $id){

        $address = Address::find($id);
        $address->street = $request->input('street');
        $address->city = $request->input('city');
        $address->country = $request->input('country');
        $address->postal_code = $request->input('postal_code');
        $address->phone_number = $request->input('phone_number');
        $address->save();

        return response('success', 200);
    }

    public function delete($id){

        Organization_address::where('address_id', $id)->delete();

        Address::destroy($id);

        return response('success', 200);
    }

    public function restore($id){

        $organization_address = Organization_address::onlyTrashed()
                                                    ->where('address_id', $id)
                                                    ->first();
        $organization_address->restore();

        $address = Address::onlyTrashed()
                          ->find($id);

        $address->restore();

        return response('success', 200);
    }
}

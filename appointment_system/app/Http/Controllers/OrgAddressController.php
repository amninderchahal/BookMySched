<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrgAddressController extends Controller
{
    public function getAddress($id){

        $res = $this->getRequest('/api/organization/address/'.$id);
        $res_data = json_decode($res->getBody(), true);
        $data = $res->getBody();

        $count = count(array_get($res_data, 'addresses', []));
        $organization = array_get($res_data, 'organization', []);

        $uri = array(
            'edit_uri'=>'/organization/address/edit/',
            'delete_uri'=>'/organization/address/delete/'
        );
        return view('organization.address.index', ['data'=> $data, 'organization'=> $organization[0], 'uri'=> $uri, 'count'=> $count]);
    }

    public function edit($org_id, $id){
        $res = $this->getRequest('/api/organization/address/'.$org_id.'/edit/'.$id);
        $address = json_decode($res->getBody(), true);
        $data = $address['address'];
        $organization = $address['organization'];
        return view('organization.address.edit')
                    ->with('data', $data[0])
                    ->with('organization', $organization[0]);
    }

    public function getTrashedOrgAddress($id){
        $res = $this->getRequest('/api/organization/trashed/address/'.$id);
        $res_data = json_decode($res->getBody(), true);
        $data = $res->getBody();
        $count = count(array_get($res_data, 'addresses', []));
        $organization = $res_data['organization'];
        return view('organization.address.trashedOrg', ['data'=> $data, 'organization'=> $organization[0], 'count'=> $count]);
    }

    public function add(Request $request, $id){

        $this->validate($request, [
            'street' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postal_code' => 'required|min:6',
            'phone_number' => 'required',
        ]);

        $this->postData('/api/organization/address/add/'.$id, $request->all());

        return redirect('/organization/address/'.$id)
                ->with('msg', 'New address added!')
                ->with('className', 'success');
    }

    public function update(Request $request,  $org_id, $id){

        $this->validate($request, [
            'street' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
            'phone_number' => 'required',
        ]);

        $this->postData('/api/organization/address/update/'.$id, $request->all());

        return redirect('/organization/address/'.$org_id)
                ->with('msg', 'Address updated!')
                ->with('className', 'success');
    }

    public function delete($org_id, $id){

        $this->getRequest('/api/organization/address/delete/'.$id);

        return redirect('/organization/address/'.$org_id)
                ->with('msg', 'Address deleted!')
                ->with('className', 'success');
    }

    public function restore($org_id, $id){

        $this->getRequest('/api/organization/address/restore/'.$id);

        return redirect('/organization/address/'.$org_id)
                ->with('msg', 'Address restored')
                ->with('className', 'success');
    }

    public function trashedAddresses($id){

        $res = $this->getRequest('/api/organization/address/trashed/'.$id);
        $res_data = json_decode($res->getBody(), true);
        $data = $res->getBody();
        $count = count(array_get($res_data, 'addresses', []));
        $organization = array_get($res_data, 'organization', []);

        $uri = array(
            'restore_uri'=>'/organization/address/restore/'
        );

        return view('organization.address.deleted', ['data'=> $data, 'organization'=> $organization, 'uri'=> $uri, 'count'=>$count]);
    }
}

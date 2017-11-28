<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganizationsController extends Controller
{
    public function index(Request $request){
        $data['page'] = $request->input('page');
        $res = $this->getData('/api/organization', $data);
        $res_data = json_decode($res->getBody(), true);
        $organizations = $res->getBody();
        $count = count(array_get($res_data, 'organizations.data', []));
        $data = array_get($res_data, 'organizations', []);

        $uri = array(
            'edit_uri'=>'/organization/edit',
            'delete_uri'=>'/organization/delete',
            'view_uri'=>'/organization/address',
            'page_uri'=>'/organization'
        );

        return view('organization.index', ['organizations'=>$organizations, 'data'=>$data,'count'=>$count, 'uri' => $uri]);
    }

    public function get($id){
        $res = $this->getRequest('/api/organization/get/'.$id);
        $organization = json_decode($res->getBody(), true);
        $data = array_get($organization, 'organization', []);

        return view('organization.address.new') ->with('organization', $data);
    }

    public function trashed(Request $request){
        $data['page'] = $request->input('page');
        $res = $this->getData('/api/organization/trashed', $data);
        $res_data = json_decode($res->getBody(), true);
        $organizations = $res->getBody();
        $data = array_get($res_data, 'organizations', []);
        $count = count(array_get($res_data, 'organizations.data', []));

        $uri = array(
            'restore_uri'=>'/organization/restore',
            'view_uri'=>'/organization/trashed/address',
            'page_uri'=>'/organization/trashed'
        );

        return view('organization.deleted', ['organizations'=>$organizations, 'data'=>$data,'count'=> $count, 'uri' => $uri]);
    }

    public function restoreOrganization($id){

        $res = $this->postRequest('/api/organization/restore/'.$id);

        $code = $res->getStatusCode();

        if($code!=200){
            return redirect('/organization/deleted')
                    ->with('msg', 'Error occured!')
                    ->with('className', 'danger');
        }

        return redirect('/organization?page=1')
                ->with('msg', 'Organization restored!')
                ->with('className', 'success');
    }

    public function newOrganization(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'street' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postal_code' => 'required|min:6',
            'phone_number' => 'required',
        ]);

            $res = $this->postData('/api/organization/add', $request->all());

            $code = $res->getStatusCode();

        if($code==500){
            $data = json_decode($res->getBody(), true);
            $error = array_get($data, 'error', []);
            return redirect('/organization/new')->with('msg', $error);
        }

        return redirect('/organization?page=1')
                ->with('msg', 'Organization added!')
                ->with('className', 'success');
    }

    public function updateOrganization(Request $request, $id){

        $this->validate($request, [
            'name' => 'required'
        ]);

        $data['name'] = $request->input('name');
        $this->postData('/api/organization/update/'.$id, $data);

        return redirect('/organization?page=1')
                ->with('msg', 'Organization updated!')
                ->with('className', 'success');
    }

    public function editOrganization($id){
        $res = $this->getRequest('/api/organization/get/'.$id);
        $res_data = json_decode($res->getBody(), true);
        $org_name = array_get($res_data, 'organization.name', []);
        return view('organization.edit')->with('name', $org_name);
    }

    public function deleteOrganization($id){
        $res = $this->getRequest('/api/organization/delete/'.$id);

        return redirect('/organization?page=1')
                ->with('msg', 'Organization deleted!')
                ->with('className', 'success');
    }
}

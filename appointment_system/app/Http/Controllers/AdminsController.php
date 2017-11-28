<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Organization;

class AdminsController extends Controller
{
    public function index(Request $request, $org_id){

        $data['page'] = $request->input('page');
        $res = $this->getData('/api/admin/organization/'.$org_id, $data);
        $res_data = json_decode($res->getBody(), true);
        $admins = $res->getBody();
        $count = count(array_get($res_data, 'admins.data', []));
        $data = array_get($res_data, 'admins', []);

        $res = $this->getRequest('/api/organization/getAll');
        $organizations = $res->getBody();

        $uri = array(
            'delete_uri'=>'/admin/delete/'.$org_id.'/',
            'edit_uri'=>'/admin/edit/',
            'filter_uri'=>'/admin/organization/',
            'page_uri'=>'/admin/organization/'.$org_id
        );

        return view('admin.index', ['admins'=>$admins, 'data'=>$data, 'organizations'=>$organizations, 'count'=>$count, 'uri'=>$uri]);
    }

    public function trashed(Request $request, $org_id){

        $data['page'] = $request->input('page');
        $org_id = $this->getOrgId($org_id);
        $res = $this->getData('/api/admin/trashed/'.$org_id, $data);

        $res_data = json_decode($res->getBody(), true);

        $admins = $res->getBody();

        $count = count(array_get($res_data, 'admins.data', []));

        $data = array_get($res_data, 'admins', []);

        $uri = array(
            'restore_uri'=>'/admin/restore/',
            'filter_uri'=>'/admin/trashed/',
            'page_uri'=>'/admin/trashed/'.$org_id
        );

        return view('admin.deleted', ['admins'=>$admins, 'data'=>$data, 'count'=>$count, 'uri'=>$uri]);
    }

     public function restoreAdmin($id){

        $res = $this->postRequest('/api/admin/restore/'.$id);

        $organizations = array_get($res, 'organizations', []);

        $code = $res->getStatusCode();

        if($code!=200){
            return redirect('/admin/deteted')
                            ->with('msg', 'Error occured!')
                            ->with('organizations', $organizations)
                            ->with('className', 'danger');
        }

        return redirect('/admin/organization/1')
                      ->with('msg', 'Admin restored!')
                      ->with('className', 'success');
    }

    public function newAdmin(){

        $res = $this->getRequest('/api/organization/getAll');
        $organizations = $res->getBody();

        return view('admin.new')->with('organizations', $organizations);
    }

    public function editAdmin($id){

        $res = $this->getRequest('/api/admin/get/'.$id);
        $res_data = json_decode($res->getBody(), true);
        $data = array_get($res_data, 'admin', []);

        $res = $this->getRequest('/api/organization/getAll');
        $res_data = json_decode($res->getBody(), true);
        $organizations = $res->getBody();

        return view('admin.edit')->with('data', $data)->with('organizations', $organizations);
    }

    public function updateAdmin(Request $request, $id){

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'organization_id' => 'required',
            'role_id' => 'required',
            'street' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postal_code' => 'required|min:6',
            'phone_number' => 'required',
        ]);

        $this->postData('/api/admin/update/'.$id, $request->all());

        return redirect('/admin/organization/'.$request->input('organization_id').'?page=1')
                        ->with('msg', 'Admin info updated!')
                        ->with('className', 'success');
    }

    public function addAdmin(Request $request){

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'organization' => 'required',
            'role' => 'required',
            'street' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postal_code' => 'required|min:6',
            'phone_number' => 'required',
        ]);

        $res = $this->postData('/api/admin/add', $request->all());

        $code = $res->getStatusCode();

        if($code==500){

            $data = json_decode($res->getBody(), true);

            $error = array_get($data, 'error', []);

            return redirect('/admin/new')
                    ->with('msg', $error)
                    ->with('className', 'danger');
        }

        return redirect('/admin/organization/'.$request->input('organization_id').'?page=1')
                ->with('msg', 'New admin added!')
                ->with('className', 'success');
    }

    public function deleteAdmin($org_id, $id)
    {
        $res = $this->postRequest('/api/admin/delete/'.$id);

        return redirect('/admin/organization/'.$org_id.'?page=1')
                ->with('msg', 'Admin deleted!')
                ->with('className', 'success');
    }
}

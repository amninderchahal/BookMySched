<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index(Request $request, $org_id){

        $data['page'] = $request->input('page');
        $org_id = $this->getOrgId($org_id);
        $res = $this->getData('/api/employee/organization/'.$org_id, $data);

        $res_data = json_decode($res->getBody(), true);
        $employees = $res->getBody();
        $count = count(array_get($res_data, 'employees.data', []));
        $data = array_get($res_data, 'employees', []);

        $uri = array(
            'delete_uri'=>'/employee/delete/',
            'edit_uri'=>'/employee/edit/',
            'filter_uri'=>'/employee/organization/',
            'page_uri'=>'/employee/organization/'.$org_id,
        );

        return view('employee.index', ['employees'=>$employees,'organizations'=>$this->getOrgData(), 'data'=>$data, 'uri'=>$uri, 'count'=>$count]);
    }

    public function newEmployee(){

        return view('employee.new')->with('organizations', $this->getOrgData());
    }

    public function addEmployee(Request $request){

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

        $res = $this->postData('/api/employee/add', $request->all());

        $code = $res->getStatusCode();

        if($code==500){

            $data = json_decode($res->getBody(), true);

            $error = array_get($data, 'error', []);

            return redirect('/employee/new')->with('msg', $error);
        }

        return redirect('/employee/organization/'.session('organization_id').'?page=1')
                ->with('msg', 'New employee added!')
                ->with('className', 'success');
    }

    public function edit($id){

        $res = $this->getRequest('/api/employee/get/'.$id);
        $res_data = json_decode($res->getBody(), true);
        $data = array_get($res_data, 'employee', []);

        return view('employee.edit')->with('data', $data)->with('organizations', $this->getOrgData());
    }

    public function updateEmployee(Request $request, $id){

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'organization' => 'required',
            'role' => 'required',
            'street' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postal_code' => 'required|min:6',
            'phone_number' => 'required',
        ]);

        $this->postData('/api/employee/update/'.$id, $request->all());

        return redirect('/employee/organization/'.session('organization_id').'?page=1')
                ->with('msg', 'Employee info updated!')
                ->with('className', 'success');
    }

    public function deleteEmployee($id)
    {
        $res = $this->postRequest('/api/employee/delete/'.$id);

        return redirect('/employee/organization/'.session('organization_id').'?page=1')
                ->with('msg', 'Employee deleted!')
                ->with('className', 'success');
    }

    public function trashed(Request $request, $org_id){

        $data['page'] = $request->input('page');
        $id = $this->getOrgId($org_id);
        $res = $this->getData('/api/employee/trashed/'.$id, $data);

        $res_data = json_decode($res->getBody(), true);
        $employees = $res->getBody();
        $count = count(array_get($res_data, 'employees.data', []));
        $data = array_get($res_data, 'employees', []);

        $uri = array(
            'restore_uri'=>'/employee/restore/',
            'filter_uri'=>'/employee/trashed/',
            'page_uri'=>'/employee/trashed/'.$org_id
        );

        return view('employee.deleted', ['employees'=>$employees, 'organizations'=>$this->getOrgData(), 'data'=>$data, 'uri'=>$uri, 'count'=>$count]);
    }

    public function restoreEmployee($id){

        $res = $this->postRequest('/api/employee/restore/'.$id);

        $organizations = array_get($res, 'organizations', []);

        $code = $res->getStatusCode();

        if($code!=200){
            return redirect('/employee/deleted')
                      ->with('msg', 'Error occured!')
                      ->with('organizations', $organizations)
                      ->with('className', 'danger');
        }

        return redirect('/employee/organization/'.session('organization_id').'?page=1')
                ->with('msg', 'Employee restored!')
                ->with('className', 'success');
    }
}

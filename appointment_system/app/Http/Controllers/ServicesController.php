<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(Request $request, $org_id){

        $data['page'] = $request->input('page');
        $org_id = $this->getOrgId($org_id);

        $res = $this->getData('/api/service/'.$org_id, $data);
        $res_data = json_decode($res->getBody(), true);
        $services = $res->getBody();
        $count = count(array_get($res_data, 'services.data', []));
        $page_data = array_get($res_data, 'services', []);

        $uri = array(
            'delete_uri'=>'/service/delete/'.$org_id.'/',
            'edit_uri'=>'/service/edit/'.$org_id.'/',
            'page_uri'=>'/service/organization/'.$org_id,
            'filter_uri'=>'/service/organization/'
        );

        return view('service.index', ['services'=>$services, 'organizations'=>$this->getOrgData(), 'count'=>$count, 'uri'=>$uri, 'data'=>$page_data]);
    }

     public function get($org_id, $id){

        $org_id = $this->getOrgId($org_id);
        $res = $this->getRequest('/api/service/'.$org_id.'/get/'.$id);
        $res_data = json_decode($res->getBody(), true);
        $service = array_get($res_data, 'service', []);
        $organization = array_get($res_data, 'organization', []);

        return view('service.edit', ['data'=>$service, 'organization'=>$organization]);
    }

    public function ajaxGetServices(Request $request, $org_id){

        $res = $this->getData('/api/service/get/'.$org_id, $request->all());
        $res_data = json_decode($res->getBody(), true);
        $services = array_get($res_data, 'services', []);
        return response()->json($services);
    }

    public function update(Request $request, $org_id, $id){

        $org_id = $this->getOrgId($org_id);
        $this->validate($request, [
            'name' => 'required',
            'description' => 'max:255'
        ]);

        $res = $this->postData('/api/service/update/'.$org_id.'/'.$id, $request->all());

        return redirect('/service/organization/'.$org_id.'?page=1')
                ->with('msg', 'Service updated!')
                ->with('className', 'success');
    }

    public function add(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'description' => 'max:255'
        ]);

        $org_id = session('organization_id');

        $data['name'] = $request->input('name');
        $data['description'] = $request->input('description');
        $data['organization_id'] = $org_id;

        $res = $this->postData('/api/service/add', $data);

        return redirect('/service/organization/'.$org_id.'?page=1')
                ->with('msg', 'New service added!')
                ->with('className', 'success');
    }

    public function delete($org_id, $id){

        $org_id = $this->getOrgId($org_id);
        $res = $this->getRequest('/api/service/'.$org_id.'/delete/'.$id);

        return redirect('/service/organization/'.$org_id.'?page=1')
                ->with('msg', 'Service deleted!')
                ->with('className', 'success');
    }

    public function restore($org_id, $id){

        $org_id = $this->getOrgId($org_id);
        $res = $this->getRequest('/api/service/'.$org_id.'/restore/'.$id);

        return redirect('/service/organization/'.$org_id.'?page=1')->with('msg', '/api/service/'.$org_id.'/restore/'.$id);
    }

    public function trashed(Request $request, $org_id){

        $data['page'] = $request->input('page');
        $res = $this->getData('/api/service/trashed/'.$org_id, $data);
        $res_data = json_decode($res->getBody(), true);
        $services = $res->getBody();
        $count = count(array_get($res_data, 'services.data', []));
        $page_data = array_get($res_data, 'services', []);

        $uri = array(
            'restore_uri'=>'/service/restore/'.$org_id.'/',
            'page_uri'=>'/service/trashed/'.$org_id,
            'filter_uri'=>'/service/trashed/'
        );

        return view('service.deleted', ['services'=>$services, 'organizations'=>$this->getOrgData(), 'count'=>$count, 'uri'=>$uri, 'data'=>$page_data]);
    }
}

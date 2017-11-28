<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $role_id = Session::get('role_id');
        $data['query'] = $request->input('query');
        $org_id = $this->getOrgId(Session::get('organization_id'));
        $id = $this->getEmpId(Session::get('id'));
        $res = $this->getData('/api/search/'.$role_id.'/'.$org_id.'/'.$id, $data);
        
        return response($res->getBody());
    }
}

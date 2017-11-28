<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Organization;

class ServiceController extends Controller
{
    public function index($id){

        $services = Service::where('organization_id', $id)
                        ->paginate(20);

        $organization = Organization::find($id);

        return response()->json([
           'services' => $services,
           'organization'=>$organization
        ]);
    }

    public function trashed($id){

        $services = Service::onlyTrashed()
                        ->where('organization_id', $id)
                        ->paginate(20);

        $organization = Organization::find($id);

        return response()->json([
           'services' => $services,
           'organization'=>$organization
        ]);
    }

    public function get($org_id, $id){

        $service = Service::where('organization_id', $org_id)
                          ->find($id);

        return response()->json([
           'service' => $service
        ]);
    }
    public function ajaxGetServices(Request $request, $org_id){

        $keyword = $request->input('keyword');
        $services = Service::where('organization_id', $org_id)
                          ->where('name', 'LIKE', $keyword.'%')
                          ->take(8)
                          ->get(['id', 'name', 'organization_id']);

        return response()->json([
           'services' => $services
        ]);
    }

    public function update(Request $request, $org_id, $id){

        $service = Service::where('organization_id', $org_id)
                            ->find($id);

        $service->name = $request->input('name');
        $service->description = $request->input('description');
        $service->save();

        return response('success', 200);
    }

    public function add(Request $request){

        $service = new Service;

        $service->name = $request->input('name');
        $service->description = $request->input('description');
        $service->organization_id = $request->input('organization_id');
        $service->save();

        return response('success', 200);
    }

    public function delete($org_id, $id){

        Service::where('organization_id', $org_id)
                ->where('id', $id)
                ->delete();

        return response('success', 200);
    }

    public function restore($org_id, $id){

        Service::onlyTrashed()
                ->where('organization_id', $org_id)
                ->where('id', $id)
                ->restore();

        return response('success', 200);
    }
}

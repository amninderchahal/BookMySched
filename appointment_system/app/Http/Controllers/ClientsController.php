<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function getClients(Request $request, $org_id)
    {
        $res = $this->getData('/api/client/'.$org_id, $request->all());
        $res_data = json_decode($res->getBody(), true);
        $clients = array_get($res_data, 'clients', []);
        return response()->json($clients);
    }
}

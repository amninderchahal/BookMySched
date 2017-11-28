<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function getClients(Request $request, $org_id)
    {
        $keyword = $request->input('keyword');
        $clients = Client::where('firstname', 'LIKE', $keyword.'%')
                         ->orWhere('lastname', 'LIKE', $keyword.'%')
                         ->take(8)
                         ->get(['id', 'firstname', 'lastname']);

        return response()->json(['clients'=>$clients]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HelperClasses\SearchHelper;

class AdminSearchController extends Controller
{
    protected $searchHelper;

    public function __construct()
    {
      $this->searchHelper = new SearchHelper();
    }
    public function index(Request $request, $org_id, $user_id)
    {
      if($request->has('query')){
        $query = $request->input('query');
        $results = $this->searchAppointments($query, $org_id);
        return response($results);
      }
    }
    public function searchAppointments($query, $org_id)
    {
      $conditions = [
        'title'=>'%'.$query.'%',
        'organization_id'=>$org_id
      ];
      $appointments = $this->searchHelper->searchAppointments($conditions);
      return $this->searchPersons($query, $appointments, $org_id);
    }
    public function searchPersons($query, $appointments, $org_id)
    {
      $sql = "(`firstname` LIKE '%".$query."%' OR `lastname` LIKE '%".$query."%') AND `organization_id`=".$org_id." AND `role_id`=3";
      $persons = $this->searchHelper->searchPersons($sql);
      $results = $appointments->merge($persons);
      return $this->searchClients($query, $results, $org_id);
    }
    public function searchClients($query, $persons, $org_id)
    {
      $sql = "(`firstname` LIKE '%".$query."%' OR `lastname` LIKE '%".$query."%')AND `organization_id`=".$org_id;
      $clients = $this->searchHelper->searchClients($sql);
      $results = $persons->merge($clients);
      return $this->searchServices($query, $results, $org_id);
    }
    public function searchServices($query, $clients, $org_id)
    {
      $conditions = [
        'name'=>'%'.$query.'%',
        'organization_id'=>$org_id
      ];
      $services = $this->searchHelper->searchServices($conditions);
      $results = $clients->merge($services);
      return $results->shuffle();
    }
}

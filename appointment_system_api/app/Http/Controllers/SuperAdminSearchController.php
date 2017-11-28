<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\HelperClasses\SearchHelper;

class SuperAdminSearchController extends Controller
{
    protected $searchHelper;

    public function __construct()
    {
      $this->searchHelper = new SearchHelper();
    }
    public function index(Request $request)
    {
      if($request->has('query')){
        $query = $request->input('query');
        $results = $this->searchAppointments($query);
        return response($results);
      }
    }
    public function searchAppointments($query)
    {
      $conditions = [
        'title'=>'%'.$query.'%'
      ];
      $appointments = $this->searchHelper->searchAppointments($conditions);
      return $this->searchPersons($query, $appointments);
    }
    public function searchPersons($query, $appointments)
    {
      $sql = "(`firstname` LIKE '%".$query."%' OR `lastname` LIKE '%".$query."%') AND `role_id` IN (2, 3)";
      $persons = $this->searchHelper->searchPersons($sql);
      $results = $appointments->merge($persons);
      return $this->searchClients($query, $results);
    }
    public function searchClients($query, $persons)
    {
      $sql = "(`firstname` LIKE '%".$query."%' OR `lastname` LIKE '%".$query."%')";
      $clients = $this->searchHelper->searchClients($sql);
      $results = $persons->merge($clients);
      return $this->searchOrganizations($query, $results);
    }
    public function searchOrganizations($query, $clients)
    {
      $conditions = [
        'name'=>'%'.$query.'%'
      ];
      $organizations = $this->searchHelper->searchOrganizations($conditions);
      $results = $clients->merge($organizations);
      return $this->searchServices($query, $results);
    }
    public function searchServices($query, $organizations)
    {
      $conditions = [
        'name'=>'%'.$query.'%'
      ];
      $services = $this->searchHelper->searchServices($conditions);
      $results = $organizations->merge($services);
      return $results->shuffle();
    }
}

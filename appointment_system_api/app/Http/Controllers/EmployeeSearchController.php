<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HelperClasses\SearchHelper;

class EmployeeSearchController extends Controller
{
    protected $searchHelper;

    public function __construct()
    {
      $this->searchHelper = new SearchHelper();
    }
    public function index(Request $request, $org_id, $emp_id)
    {
      if($request->has('query')){
        $query = $request->input('query');
        $results = $this->searchAppointments($query, $org_id, $emp_id);
        return response($results);
      }
    }
    public function searchAppointments($query, $org_id, $emp_id)
    {
      $conditions = [
        'title'=>'%'.$query.'%',
        'organization_id'=>$org_id,
        'employee_id'=>$emp_id
      ];
      $appointments = $this->searchHelper->searchAppointments($conditions);
      return $this->searchClients($query, $appointments, $org_id, $emp_id);
    }
    public function searchClients($query, $appointments, $org_id, $emp_id)
    {
      $sql = "(`firstname` LIKE '%".$query."%' OR `lastname` LIKE '%".$query."%') AND `added_by`=".$emp_id." AND `organization_id`=".$org_id;
      $clients = $this->searchHelper->searchClients($sql);
      $results = $appointments->merge($clients);
      return $results->shuffle();
    }
}

<?php
 
namespace App\HelperClasses;
use App\Appointment;
use App\Person;
use App\Client;
use App\Organization;
use App\Service;

class SearchHelper
{
    public function searchAppointments($conditions)
    {
        $searchResults = collect([]);
        $query = Appointment::select();
        foreach ($conditions as $column => $value) {
           $query->where($column, 'LIKE', $value);
        }
        $appointments = $query->take(5)->get();

        foreach ($appointments as $appointment) {
            $searchResults->push([
                'id'=>$appointment->id,
                'title'=>$appointment->title,
                'type'=> 'Appointment',
                'org_id'=>$appointment->organization_id,
                'emp_id'=>$appointment->employee_id,
                'date'=>$appointment->date,
                'created_at'=>$appointment->created_at->format('Y-m-d')
            ]);
        }
        return $searchResults;
    }
    public function searchPersons($sql)
    {
        $searchResults = collect([]);
        $persons = Person::whereRaw($sql, array(5))->get();

        foreach ($persons as $person) {
            $searchResults->push([
                'id'=>$person->id,
                'title'=>$person->firstname.' '.$person->lastname,
                'type'=> $person->role->name,
                'org_id'=>$person->organization_id,
                'emp_id'=>'0',
                'date'=>'',
                'created_at'=>$person->created_at->format('Y-m-d')
            ]);
        }
        return $searchResults;
    }
    public function searchClients($sql)
    {
        $searchResults = collect([]);
        $clients = Client::whereRaw($sql, array(5))->get();

        foreach ($clients as $client) {
            $searchResults->push([
                'id'=>$client->id,
                'title'=>$client->firstname.' '.$client->lastname,
                'type'=> 'Client',
                'org_id'=>$client->organization_id,
                'emp_id'=>$client->added_by,
                'date'=>'',
                'created_at'=>$client->created_at->format('Y-m-d')
            ]);
        }
        return $searchResults;
    }
    public function searchOrganizations($conditions)
    {
        $searchResults = collect([]);
        $query = Organization::select();
        foreach ($conditions as $column => $value) {
           $query->where($column, 'LIKE', $value);
        }
        $organizations = $query->take(5)->get();

        foreach ($organizations as $organization) {
            $searchResults->push([
                'id'=>$organization->id,
                'title'=>$organization->name,
                'type'=> 'Organization',
                'org_id'=>0,
                'emp_id'=>0,
                'date'=>'',
                'created_at'=>$organization->created_at->format('Y-m-d')
            ]);
        }
        return $searchResults;
    }
    public function searchServices($conditions)
    {
        $searchResults = collect([]);
        $query = Service::select();
        foreach ($conditions as $column => $value) {
           $query->where($column, 'LIKE', $value);
        }
        $services = $query->take(5)->get();

        foreach ($services as $service) {
            $searchResults->push([
                'id'=>$service->id,
                'title'=>$service->name,
                'type'=> 'Service',
                'org_id'=>$service->organization_id,
                'emp_id'=>0,
                'date'=>'',
                'created_at'=>$service->created_at->format('Y-m-d')
            ]);
        }
        return $searchResults;
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Helper;

class ScheduleController extends Controller
{
    public function index($org_id){

        $org_id = $this->getOrgId($org_id);
        $res = $this->getRequest('/api/employee/organization/'.$org_id);
        $res_data = json_decode($res->getBody(), true);
        $count = count(array_get($res_data, 'employees.data', []));
        $data = array_get($res_data, 'employees', []);

        $uri = array(
            'view_uri'=>'/schedule/organization/'.$org_id.'/',
            'page_uri'=>'/schedule/organization/'.$org_id,
            'filter_uri'=>'/schedule/organization/'
        );

        return view('schedule.orgSchedule', ['employees'=> $res->getBody(), 'uri'=> $uri, 'data'=>$data, 'organizations'=>$this->getOrgData(),'count'=>$count]);
    }

    public function getEmpSchedule($org_id, $id){

        $org_id = $this->getOrgId($org_id);
        $res = $this->getRequest('/api/schedule/organization/'.$org_id.'/'.$id);

        $res_data = json_decode($res->getBody(), true);
        $count = count(array_get($res_data, 'schedule', []));
        $statusCode = array_get($res_data, 'statusCode', []);

        $employee = array_get($res_data, 'employee', []);

        $uri = array(
            'add_uri'=> '/schedule/new/'.$org_id.'/'.$id
        );

        if ($statusCode == 400){

            return view('schedule.index', ['schedule'=> null, 'uri'=> $uri, 'employee'=>$employee, 'count'=>$count]);
        }
        else
        {
            $schedule = json_encode(array_get($res_data, 'schedule', []));

            return view('schedule.index', ['schedule'=>$res->getBody(), 'uri'=> $uri, 'employee'=>$employee, 'count'=>$count]);
        }
    }

    public function update(Request $request, $org_id, $id){
        $org_id = $this->getOrgId($org_id);
        $this->validate($request, [
            'start_time-*' => 'required|max:8',
            'end_time-*' => 'required|max:8'
        ]);

        $this->postData('/api/schedule/organization/'.$org_id.'/'.$id, $request->all());

        return redirect('/schedule/organization/'.$org_id.'/'.$id)
                ->with('msg', 'Schedule updated!')
                ->with('className', 'success');
    }

    public function newSchedule($org_id, $id)
    {
        $schedule['schedule'] = [];
        for($i=0; $i<5; $i++)
        {
            $schedule['schedule'][]=[
                'id'=>$i,
                'day_of_week'=> ($i+1),
                'start_time'=> '',
                'end_time'=> ''
            ];
        }

        $res = $this->getRequest('/api/employee/get/'.$id);
        $res_data = json_decode($res->getBody(), true);
        $employee = array_get($res_data, 'employee', []);

        return view('schedule.index', ['schedule'=>json_encode($schedule), 'count'=> 5, 'employee'=>$employee]);
    }

    public function addSchedule(Request $request, $org_id, $id){

        $org_id = $this->getOrgId($org_id);

        $this->validate($request, [
            'start_time-*' => 'required|max:8',
            'end_time-*' => 'required|max:8'
        ]);

        $this->postData('/api/schedule/add/'.$org_id.'/'.$id, $request->all());

        return redirect('/schedule/organization/'.$org_id.'/'.$id)
                ->with('msg', 'Schedule added!')
                ->with('className', 'success');
    }
}

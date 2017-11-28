<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index($org_id){

        $org_id = $this->getOrgId($org_id);
        $res = $this->getRequest('/api/employee/organization/'.$org_id);
        $res_data = json_decode($res->getBody(), true);
        $count = count(array_get($res_data, 'employees.data', []));
        $data = array_get($res_data, 'employees', []);

        $uri = array(
            'view_uri'=>'/appointment/organization/'.$org_id.'/',
            'page_uri'=>'/appointment/organization/'.$org_id,
            'filter_uri'=>'/appointment/organization/'
        );

        return view('appointment.orgAppointment', ['employees'=> $res->getBody(), 'uri'=> $uri, 'data'=>$data, 'organizations'=>$this->getOrgData(),'count'=>$count]);
    }

    public function getEmpAppointments(Request $request, $org_id, $emp_id)
    {
        $org_id = $this->getOrgId($org_id);
        $emp_id = $this->getEmpId($emp_id);

        if($request->ajax==true){
          $selectedDate = Carbon::createFromFormat('Y-m-d', $request->input('date'));
          $date = $selectedDate->format('Y-m');
          $res = $this->getData('/api/appointment/'.$org_id.'/'.$emp_id, ['date'=>$date]);

          return response($res->getBody());
        }
        $now = Carbon::now();
        $date = $now->format('Y-m');

        $res = $this->getData('/api/appointment/'.$org_id.'/'.$emp_id,['date'=>$date]);

        $res_data = json_decode($res->getBody(), true);
        $employee = array_get($res_data, 'employee', []);
        $appointments = $res->getBody();

        $res = $this->getRequest('/api/schedule/organization/'.$org_id.'/'.$emp_id);
        $res_data = json_decode($res->getBody(), true);
        $schedule = array_get($res_data, 'schedule', []);

        $uri = array(
            'appointment_uri'=>'/appointment/'.$org_id.'/',
            'page_uri'=>'/employee/organization/'.$org_id
        );

        return view('appointment.index', ['appointments'=>$appointments,'employee'=>$employee,'schedule'=>json_encode($schedule), 'uri'=>$uri]);
    }

    public function update(Request $request, $org_id, $emp_id, $id){

        $org_id = $this->getOrgId($org_id);
        $emp_id = $this->getEmpId($emp_id);
        $res = $this->postData('/api/appointment/'.$org_id.'/'.$emp_id.'/'.$id, $request->all());

        return redirect('/appointment/organization/'.$org_id.'/'.$emp_id)
                        ->with('msg', 'Appointment updated!')
                        ->with('className', 'success');
    }

    public function add(Request $request, $org_id, $emp_id){

        $org_id = $this->getOrgId($org_id);
        $emp_id = $this->getEmpId($emp_id);
        $res = $this->postData('/api/appointment/'.$org_id.'/'.$emp_id.'/add/new', $request->all());

        return redirect('/appointment/organization/'.$org_id.'/'.$emp_id)
                        ->with('msg', 'Appointment added!')
                        ->with('className', 'success');
    }

    public function delete($org_id, $emp_id, $id){

        $org_id = $this->getOrgId($org_id);
        $emp_id = $this->getEmpId($emp_id);
        $res = $this->postRequest('/api/appointment/'.$org_id.'/'.$emp_id.'/delete/'.$id);
        $code = $res->getStatusCode();
        if($code!=200){
            return redirect('/appointment/organization/'.$org_id.'/'.$emp_id)
                            ->with('msg', 'Error occured!')
                            ->with('className', 'danger');
        }
        return redirect('/appointment/organization/'.$org_id.'/'.$emp_id)
                        ->with('msg', 'Appointment deleted!')
                        ->with('className', 'success');
    }
}

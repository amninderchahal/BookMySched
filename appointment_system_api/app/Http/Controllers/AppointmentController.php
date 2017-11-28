<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\Person;
use App\Client;
use App\Organization;

class AppointmentController extends Controller
{
    public function index(Request $request, $org_id, $emp_id)
    {
        $date = $request->input('date');
        if($date== null || $date==''){
          return response('error', 503);
        }

        $appointments = Appointment::where('organization_id', $org_id)
                                    ->where('employee_id', $emp_id)
				                            ->where('date', 'LIKE', $request->input('date').'%')
                                    ->get();
        $data = collect([]);

        foreach($appointments as $appointment){
            $start_time = (string)$appointment->start_time;
            $end_time = (string)$appointment->end_time;
            $data->push([
                "id"=>$appointment->id,
                "title"=>$appointment->title,
                "service"=>$appointment->service->name,
                "service_id"=>$appointment->service_id,
                "organization_id"=> $appointment->organization_id,
                "employee_id"=> $appointment->employee_id,
                "client_id"=> $appointment->client_id,
                "client"=> $appointment->client->firstname.' '.$appointment->client->lastname,
                "date"=> $appointment->date,
                "start_time"=>  $appointment->start_time,
                "end_time"=>  $appointment->end_time,
                "startTime"=>  date('g:ia',  strtotime($start_time)),
                "endTime"=>  date('g:ia', strtotime($end_time)),
                "marked_as" => $appointment->marked_as
            ]);
        }
        $employee = Person::find($emp_id);

        return response()->json([
            'appointments'=>$data,
            'employee'=>$employee,
            'date'=>$date
        ]);
    }

    public function update(Request $request, $org_id, $emp_id, $id)
    {
        $appointment = Appointment::find($id);

        $appointment->title = $request->input('title');
        $appointment->service_id = $request->input('service_id');
        $appointment->client_id = $request->input('client_id');
        $appointment->date = $request->input('date');
        $appointment->start_time = date('H:i:s', strtotime($request->input('start_time')));
        $appointment->end_time = date('H:i:s', strtotime($request->input('end_time')));
        $appointment->marked_as = $request->input('marked_as');
        $appointment->save();

        return response('success', 200);
    }

    public function add(Request $request, $org_id, $emp_id)
    {
        $appointment = new Appointment;

        $appointment->title = $request->input('title');
        $appointment->service_id = $request->input('service_id');
        $appointment->organization_id = $org_id;
        $appointment->employee_id = $emp_id;
        $appointment->client_id = $request->input('client_id');
        $appointment->date = $request->input('date');
        $appointment->start_time = date('H:i:s', strtotime($request->input('start_time')));
        $appointment->end_time = date('H:i:s', strtotime($request->input('end_time')));
        $appointment->marked_as = $request->input('marked_as');
        $appointment->save();

        return response('success', 200);
    }

    public function delete($org_id, $emp_id, $id)
    {
        Appointment::destroy($id);

        return response('success', 200);
    }
}

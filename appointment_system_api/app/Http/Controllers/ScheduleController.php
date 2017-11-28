<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schedule;
use App\Organization;
use App\Person;

class ScheduleController extends Controller
{
    public function index($org_id, $id){
        
        $schedule = Schedule::where('organization_id', $org_id)
                                    ->where('employee_id', $id)
                                    ->get();
        
        $employee = Person::find($id);
        
        if ($schedule->isEmpty()){
            return response()->json([
                "statusCode"=>400,
                "error"=>"No schedule found",
                "employee" => $employee
            ]);
        }
        
        foreach($schedule as $daily){
            $start_time = (string)$daily->start_time;
            $end_time = (string)$daily->end_time;
            $daily->start_time = date('g:ia',  strtotime($start_time));
            $daily->end_time = date('g:ia', strtotime($end_time));
        }
        
        return response()->json([
            "statusCode"=>200,
            'schedule' => $schedule,
            "employee" => $employee
        ]);
    }
    
    public function update(Request $request, $org_id, $id){
    
        $inputData = $request->except('api_token', '_token');
        
        $days = [];
        $i = 0;
        foreach($inputData as $key=>$value)
        {
            $day_of_week = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
            $column = preg_replace('/[0-9]+/', '', $key);
            Schedule::where('organization_id', $org_id)
                                ->where('employee_id', $id)
                                ->where('day_of_week', $day_of_week)
                                ->update([$column => date('H:i:s', strtotime($value))]);
            
            $count = Schedule::where('organization_id', $org_id)
                                ->where('employee_id', $id)
                                ->where('day_of_week', $day_of_week)
                                ->count();
            
            if(!in_array($day_of_week, $days)){
                $days[] = $day_of_week;
            }
            
            if($count==0)
            {
                if($column==='start_time')
                {
                    $schedule = new Schedule;
                    $schedule->organization_id = $org_id;
                    $schedule->employee_id = $id;
                    $schedule->day_of_week = $day_of_week;
                    $schedule->start_time = date('H:i:s', strtotime($value));
                }
                else
                {
                    $schedule->end_time = date('H:i:s', strtotime($value));
                    $schedule->save(); 
                }  
            }
        }
        
        Schedule::where('organization_id', $org_id)
                ->where('employee_id', $id)
                ->whereNotIn('day_of_week', $days)
                ->forceDelete();
        
        return response('success', 200);
    }
    
    public function add(Request $request, $org_id, $id){
    
        $inputData = $request->except('api_token', '_token');
        
        foreach($inputData as $key=>$value)
        {    
            $day_of_week = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
            $column = preg_replace('/[0-9]+/', '', $key);
            
            if($column==='start_time')
            {
                $schedule = new Schedule;
                $schedule->organization_id = $org_id;
                $schedule->employee_id = $id;
                $schedule->day_of_week = $day_of_week;
                $schedule->start_time = date('H:i:s', strtotime($value));
            }
            else
            {
                $schedule->end_time = date('H:i:s', strtotime($value));
                $schedule->save(); 
            }  
        }
        
        return response('success', 200);
    }
}

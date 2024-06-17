<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeAttendance;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Shift;
use Illuminate\Support\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;
class EmployeeAttendanceController extends Controller
{
    
    public function employeewiseAttendance(Request $request)
    {
        
        
        $search_feild['employee_id'] = $request->employee_id;

     $currentMonthStart = Carbon::now()->startOfMonth()->format('Y-m-d');
//    $currentMonthEnd = Carbon::now()->endOfMonth()->format('Y-m-d');
   $currentMonthEnd = Carbon::now()->format('Y-m-d');
     if ($request->date_range != null) {
           $currentMonthStart = explode('/', $request->date_range)[0];
           $currentMonthEnd = explode('/', $request->date_range)[1];

       }

       $data=[];
       $employeedata=null;
       if($request->employee_id!= null){
        // $data = Employee::findOrFail($request->employee_id)
        // ->attendances()
        //      ->whereDate('created_at', '>=', $currentMonthStart)
        //    ->whereDate('created_at', '<=', $currentMonthEnd)
        //    ->orderBy('id', 'desc')
        //      ->get();
             $data = EmployeeAttendance::where('employee_id', $request->employee_id)
            ->whereDate('created_at', '>=', $currentMonthStart)
           ->whereDate('created_at', '<=', $currentMonthEnd)
            ->orderBy('id', 'desc')->get();
            $employeedata=Employee::where('id',$request->employee_id)->first();
       }
       
         
            $count=1;

            $employees=Employee::get(['id','name']);
  
       return view('attendance.employeewisereport',compact('data','search_feild','currentMonthStart','currentMonthEnd','employees','count','employeedata'));
    }
    public function clientwiseAttendance(Request $request)
    {
        
        
        $search_feild['client_id'] = $request->client_id;
        $search_feild['shift_id'] = $request->shift_id;

     $currentMonthStart = Carbon::now()->startOfMonth()->format('Y-m-d');

     $currentMonthEnd = Carbon::now()->format('Y-m-d');
     if ($request->date_range != null) {
           $currentMonthStart = explode('/', $request->date_range)[0];
           $currentMonthEnd = explode('/', $request->date_range)[1];

       }

       $data=null;
       $shifts=[];
       if($request->client_id!= null){
        
  
          // Fetch employees with their attendances within the specified date range
          // $data = Client::where('id',$request->client_id)->employees()->with(['attendances' => function($query) use ($startDate, $endDate) {
          //     $query->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd]);
          // }])->get();
        //   $data = Client::with(['employees.attendances' => function($query) use ($currentMonthStart, $currentMonthEnd) {
        //        $query->whereDate('created_at', '>=', $currentMonthStart);
        //        $query->whereDate('created_at', '<=', $currentMonthEnd);
        //    }])->findOrFail($request->client_id);
           $data = Client::with(['employees' => function($query) use ($currentMonthStart, $currentMonthEnd,$request) {
            if($request->shift_id!= null){
                $query->wherePivot('shift_id', $request->shift_id);
            }
            $query->withCount(['attendances' => function($query) use ($currentMonthStart, $currentMonthEnd) {
                $query->whereDate('created_at', '>=', $currentMonthStart);
               $query->whereDate('created_at', '<=', $currentMonthEnd);
            }]);
        }])->findOrFail($request->client_id);
        $shifts=Shift::where('client_id',$request->client_id)->get();
        
       }
     
    //    $data = Client::with(['employees.attendances' => function($query) use ($currentMonthStart, $currentMonthEnd) {
    //       $query-->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd]);
    //   }])->findOrFail($request->client_id);
         
            $count=1;

            $clients=Client::get(['id','name']);
            $startDate = Carbon::parse($currentMonthStart);
            $endDate = Carbon::parse($currentMonthEnd);
          $daydiffrence=  $startDate->diffInDays($endDate) + 1;
       return view('attendance.clientwisereport',compact('data','search_feild','currentMonthStart','currentMonthEnd','clients','count','daydiffrence','shifts'));
    }
}

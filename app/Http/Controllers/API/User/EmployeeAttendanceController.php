<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;
class EmployeeAttendanceController extends Controller
{
    public function storeAndUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'employee_ids' => 'required',
            // 'employee_ids.*' => 'integer|exists:employees,id',
            'type' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
       
        $data['mark_by']= Auth::guard('userapi')->user()->id;
        if($request->type=='check_in'){
            foreach ($request->employee_ids as $employee_id) {
           
            $data['check_in']=Carbon::now();
            $data['employee_id']=$employee_id;
            EmployeeAttendance::create($data);  
            }
            return response()->json([
                'message' => 'clock in successfully',
            ], 201);

        }
        if($request->type=='check_out'){
            foreach ($request->employee_ids as $employee_id) {
                $data['check_out']=Carbon::now();
                $data['attendance_status']=1;
            EmployeeAttendance::where('employee_id',$employee_id)->latest()->limit(1)->update($data);

            }
            return response()->json([
                'message' => 'clock out successfully',
            ], 200);
        }
     
      
    }

   
}

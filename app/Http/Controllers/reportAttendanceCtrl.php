<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\homeAttendance;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class reportAttendanceCtrl extends Controller
{
    public function searchTask(Request $request){

        $search_emp =$request->empSearch;
        $startdate = date('Y-m-d', strtotime($request->startd));
        $enddate = date('Y-m-d', strtotime($request->endd.' + 1 days'));

        // dd($);

        if($search_emp=="All"){
            $getData=homeAttendance::join('users as a','home_attendance.empID','=','a.empID')
            ->select("a.*",'home_attendance.*')
            ->whereBetween('home_attendance.created_at', [$startdate, $enddate])
            ->get();
        }else{
            $getData=homeAttendance::join('users as a','home_attendance.empID','=','a.empID')
            ->select("a.*",'home_attendance.*')
            ->whereBetween('home_attendance.created_at', [$startdate, $enddate])
            ->where('a.empID',$search_emp)
            // ->groupBy('empID')
            // ->where('lname', 'LIKE', '%'.$search_eqp.'%')
            ->get();
        }

        $getData=$getData->map(function ($item) {
            return [
                'id'    => $item->id,
                'lname' => $item->lname,
                'fname' => $item->fname,
                'timein'  => \Carbon\Carbon::parse($item->timeIn)->format('F j, Y g:i A'),
                // 'timeout' => \Carbon\Carbon::parse($item->timeOut)->format('F j, Y g:i A'),
                'timeout' => $item->timeOut ? \Carbon\Carbon::parse($item->timeOut)->format('F j, Y g:i A') : '',
                'durationtime' => number_format($item->durationTime, 2),
                // 'durationtime' => $item->durationTime,
            ];
        });

        return response()->json(['status'=>200,'data'=> $getData]);

    }

}

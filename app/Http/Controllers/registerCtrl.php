<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Validator;

use Carbon\Carbon;
use App\Models\User;
use App\Models\access;
use App\Models\emp_info;
use App\Models\empDetail;
use Illuminate\Http\Request;
use App\Models\emp_education;
use Illuminate\Support\Facades\Hash;



class registerCtrl extends Controller
{
    public function generateEmpID(){
        $getEmployees=User::get();
        if($getEmployees->count()>0){
            $id = str_pad($getEmployees->count() + 1, 4, '0', STR_PAD_LEFT);
        }else{
            $id = str_pad(1, 4, '0', STR_PAD_LEFT);
        }
        return response()->json(['status'=>200, 'data'=>$id]);
    }

    // public function create(Request $request){
    //     return response()->json(['status'=>200, 'data'=>$request->all()]);
    // }

    public function get_province(Request $request){
        $data = DB::table('refprovince')
                // ->where('provCode','0410')
                ->orderBy('provDesc','desc')
                ->get();

        return json_encode(array('status'=>200,'data'=>$data));
    }

    public function get_city(Request $request) {
        $provcode=$request->id;
        $data = DB::table('refcitymun')
            ->where('provCode',$provcode)
            ->get();
        return json_encode(array('status'=>200,'data'=>$data));
    }

    public function get_brgy(Request $request){
        $citycode=$request->id;
        $data = DB::table('refbrgy')
            ->where('citymunCode',$citycode)
            ->get();
        return json_encode(array('status'=>200,'data'=>$data));
    }

    public function create(Request $request){
        //insert to user table
        $defaultpass="123456";
        $current_date_time = Carbon::now()->toDateTimeString();
        $empID=$request->company .'-'. $request->employee_number;//code+number
            $validator = Validator::make($request->all(),[
                'email'=>'required|unique:users',
                'firstname'=>'required',
                // 'middlename'=>'required',
                'lastname'=>'required',
                'company'=>'required',
                //infos
                'gender'=>'required',
                'citizenship'=>'required',
                // 'religion'=>'required',
                // 'birthdate'=>'required',
                'status'=>'required',
                // 'homephone'=>'required',
                // 'province'=>'required',
                // 'mobile'=>'required',
                // 'city'=>'required',
                // 'barangay'=>'required',
                // 'zipcode'=>'required',
                // 'country'=>'required',
                //empDetails
                'immediate'=>'required',
                'department'=>'required',
                'company'=>'required',
                'classification'=>'required',
                'position'=>'required',
                // 'basic'=>'required',
                // 'allowance'=>'required',
                // 'hourly_rate'=>'required',
                // 'no_work_days'=>'required',
                'status'=>'required',
                // 'date_hired'=>'required',
                'job_level'=>'required',

            ]);

            if(!$validator->passes()){
                return response()->json(['status'=>201, 'error'=>$validator->errors()->toArray()]);
            }else{


                    $valuesUser = [
                        'email'=>$request->email,
                        'empID'=> $empID,
                        'status'=>'1',//active meaning
                        'suffix'=>$request->suffix,
                        'lname'=>$request->lastname,
                        'fname'=>$request->firstname,
                        'mname'=>$request->middlename,
                        'password'=>hash::make($defaultpass),
                        'role' => "3",//normal user
                        'created_at' =>  $current_date_time,
                        'updated_at' =>  $current_date_time,
                    ];
                    $valueInfos=[
                        'empEmail'=>$request->email,
                        'empID'=> $empID,
                        'empBdate'=>$request->birthdate,
                        'empCStatus'=>$request->status,
                        'empReligion'=>$request->religion,
                        'empPContact'=>$request->homephone,
                        'empHContact'=>$request->mobile,
                        'empAddStreet'=>$request->street,
                        'empAddCityDesc'=>$request->citydesc,
                        'empAddCity'=>$request->city,
                        'empAddBrgyDesc'=>$request->brgydesc,
                        'empAddBrgy'=>$request->barangay,
                        'empProvDesc'=>$request->provdesc,
                        'empProv'=>$request->province,
                        'empZipcode'=>$request->zipcode,
                        'empCountry'=>$request->country,
                        'created_at' =>  $current_date_time,
                        'updated_at' =>  $current_date_time,
                    ];
                    $valueEdu1 = [
                        'empID'=> $empID,
                        'schoolLevel'=>"Primary",
                        'schoolName'=>$request->primary_school,
                        'schoolYearStarted'=>$request->primary_year_started,
                        'schoolYearEnded'=>$request->primary_year_graduated,
                        'schoolAddress'=>$request->primary_school_address,
                        'created_at' =>  $current_date_time,
                        'updated_at' =>  $current_date_time,

                    ];
                    $valueEdu2 = [
                        'empID'=> $empID,
                        'schoolLevel'=>"Secondary",
                        'schoolName'=>$request->secondary_school,
                        'schoolYearStarted'=>$request->secondary_year_started,
                        'schoolYearEnded'=>$request->secondary_year_graduated,
                        'schoolAddress'=>$request->secondary_year_graduated,
                        'created_at' =>  $current_date_time,
                        'updated_at' =>  $current_date_time,
                    ];
                    $valueEdu3 = [
                        'empID'=> $empID,
                        'schoolLevel'=>"Tertiary",
                        'schoolName'=>$request->teriary_school,
                        'schoolYearStarted'=>$request->tertiary_year_started,
                        'schoolYearEnded'=>$request->teriary_year_graduated,
                        'schoolAddress'=>$request->teriary_school_address,
                        'created_at' =>  $current_date_time,
                        'updated_at' =>  $current_date_time,

                    ];
                    $valueDetails=[
                        'empID'=> $empID,
                        'empISID'=> $request->immediate,
                        'empDepID'=> $request->department,
                        'empCompID'=> $request->company,
                        'empClassification'=> $request->classification,
                        'empPos'=> $request->position,
                        'empBasic'=> $request->basic,
                        'empStatus'=> $request->status,
                        'empAllowance'=> $request->allowance,
                        'empHrate'=> $request->hourly_rate,
                        'empWday'=> $request->no_work_days,
                        'empJobLevel'=> $request->job_level,
                        'empAgencyID'=> $request->agency,
                        'empHMOID'=> $request->hmo,
                        'empHMONo'=> $request->hmo_number,
                        'empPicPath'=> $request->path,
                        'empDateHired'=> $request->date_hired,
                        'empDateResigned'=> $request->date_resingned,
                        'empDateRegular'=> $request->date_regularization,
                        'empPrevPos'=> $request->previous_position,
                        'empPrevDep'=> $request->previous_department,
                        'empPrevDesignation'=>$request->previous_designation,
                        'empPrevWorkStartDate'=> $request->start_date,

                        //compliance
                        'empPassport'=> $request->passport_no,
                        'empPassportExpDate'=> $request->passport_exp_date,
                        'empPassportIssueAuth'=> $request->issuing_authority,
                        'empPagibig'=> $request->pagibig,
                        'empPhilhealth'=> $request->philhealth,
                        'empSSS'=> $request->sss,
                        'empTIN'=> $request->tin,
                        'empUMID'=> $request->umid,
                        'created_at' =>  $current_date_time,
                        'updated_at' =>  $current_date_time,

                    ];
                    $valueCompliance=[
                        'empID'=> $empID,
                    ];
                    #insert also access rights
                        //user

                    $valuessysaccess = [
                        'empID'=> $empID,
                        'home'=>1,
                        'settings'=>0,
                        'rpt_attend'=>0,
                    ];


                    DB::beginTransaction();
                try {
                        DB::table('users')->insert( $valuesUser);
                        DB::table('emp_infos')->insert( $valueInfos);
                        DB::table('emp_educations')->insert( $valueEdu1);
                        DB::table('emp_educations')->insert( $valueEdu2);
                        DB::table('emp_educations')->insert( $valueEdu3);
                        DB::table('emp_details')->insert( $valueDetails);
                        DB::table('access')->insert( $valuessysaccess);
                        $imageName= $request->path->getClientOriginalName();

                        $request->path->move('img/profile/',$imageName);
                        DB::commit();
                        return response()->json(['status'=>200,'msg'=>'The employee was added successfully!' ]);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['status'=>203,'msg'=>$e->getMessage() ]);
                    }
            }
    }
}


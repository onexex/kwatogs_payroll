<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use App\Models\department;
use Illuminate\Http\Request;

class departmentCtrl extends Controller
{
    public function create_update(Request $request){
        $values = [
            'dep_name'=>$request->department,
        ];
        $validator = Validator::make($request->all(),[
            'department'=>'required',
        ]);
        if(!$validator->passes()){
            return response()->json(['status'=>201, 'error'=>$validator->errors()->toArray()]);
        }else{
                if($request->formAction==1){
                    $checkIfExist =  department::where('dep_name',$request->department);
                        if($checkIfExist->count()>0){
                            return response()->json(['status'=>200, 'msg'=>'Department exist!']);
                        }
                    $insert = department::create($values);
                }else{
                    $insert = department::where('id',$request->depID)->update($values);
                }
            if($insert){
                if($request->formAction==1){
                    return response()->json(['status'=>200, 'msg'=>'Department Created.']);
                }else{
                    return response()->json(['status'=>200, 'msg'=>'Department Updated.']);
                }
            }else{
                return response()->json(['status'=>202, 'msg'=>'Error saving']);

            }

        }

    }
    
    public function getall(Request $request){
        $getDepartment = department::latest()->get();
        if($getDepartment){
            return response()->json(['status'=>200, 'data'=>$getDepartment]);
        }
    }

    public function edit(Request $request){
        $getDepartment = department::where('id',$request->depID)->get();
        if($getDepartment){
            return response()->json(['status'=>200, 'data'=>$getDepartment]);
        }
    }
}

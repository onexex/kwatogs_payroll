<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\classification;
use DB;
use Validator;

class classiticationCtrl extends Controller
{
    public function create_update(Request $request){
        $values = [
            'class_code'=>$request->code,
            'class_desc'=>$request->description,
        ];
        $validator = Validator::make($request->all(),[
            'code'=>'required',
            'description'=>'required',
        ]);
        if(!$validator->passes()){
            return response()->json(['status'=>201, 'error'=>$validator->errors()->toArray()]);
        }else{
                if($request->formAction==1){
                    $checkIfExist =  classification::where('class_code',$request->code);
                        if($checkIfExist->count()>0){
                            return response()->json(['status'=>200, 'msg'=>'Classification code exist!']);
                        }
                    $insert = classification::create($values);
                }else{
                    $insert = classification::where('id',$request->id)->update($values);
                }
            if($insert){
                if($request->formAction==1){
                    return response()->json(['status'=>200, 'msg'=>'Classification Created.']);
                }else{
                    return response()->json(['status'=>200, 'msg'=>'Classification Updated.']);
                }
            }else{
                return response()->json(['status'=>202, 'msg'=>'Error saving']);

            }

        }

    }

    public function get_all(Request $request){
        $getClassification = classification::latest()->get();
        if($getClassification){
            return response()->json(['status'=>200, 'data'=>$getClassification]);
        }
    }

    public function edit(Request $request){
        $id=$request->classID;
        $getClassification = classification::where('id', $id)->get();
        return response()->json(['status'=>200, 'data'=>$getClassification]);
    }


    public function delete(Request $request){
        //1 super user
        //2 admin
        //3 normal user

        $user=session()->get('LoggedUserID');
        $role=session()->get('LoggedUserRole');
        $id=$request->id;

        if($role!=1){
            return response()->json(['status'=>200, 'msg'=>'Access Denied. Required superuser access for this request!']);
        }else{
            $delete = classification::where('id', $id)->delete();
            if($delete){
                return response()->json(['status'=>200, 'msg'=>"Classification deleted successfully."]);
            }else{
                return response()->json(['status'=>200, 'msg'=>"Error"]);
            }
        }
    }
}

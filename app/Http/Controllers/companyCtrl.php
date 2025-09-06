<?php

namespace App\Http\Controllers;
use DB;
use Validator;
use App\Models\company;
use Illuminate\Http\Request;

class companyCtrl extends Controller
{

    public function create_update(Request $request){
        if($request->logo==""){
             $imageName=0;
        }else{
            $imageName= $request->logo->getClientOriginalName();
        }
        $values2 = [
            'comp_id'=>$request->companyid,
            'comp_name'=>$request->company,
            'comp_code'=>$request->code,
            'comp_color'=>$request->color,
            'comp_logo_path'=>$imageName,
        ];
         $values1 = [
            'comp_id'=>$request->companyid,
            'comp_name'=>$request->company,
            'comp_code'=>$request->code,
            'comp_color'=>$request->color,
        ];
        $validator = Validator::make($request->all(),[
            'companyid'=>'required',
            'company'=>'required',
            'code'=>'required',
            'color'=>'required',
        ]);
        if(!$validator->passes()){
            return response()->json(['status'=>201, 'error'=>$validator->errors()->toArray()]);
        }else{
                if($request->formAction==1){
                    $insert = company::create($values2);
                    $request->logo->move('img/company/',$imageName);
                }else{
                    if($request->logo==""){
                        $insert = company::where('id',$request->CompanyID)->update($values1);
                    }else{
                        $insert = company::where('id',$request->CompanyID)->update($values2);
                    }

                }
            if($insert){
                if($request->formAction==1){
                    return response()->json(['status'=>200, 'msg'=>'Company Created.']);
                }else{
                    return response()->json(['status'=>200, 'msg'=>'Company Updated.']);
                }
            }else{
                return response()->json(['status'=>202, 'msg'=>'Error saving']);

            }
        }
    }

    public function get_all(Request $request){

        $getComp= company::get();
        if($getComp){
            return response()->json(['status'=>200, 'data'=>$getComp]);
        }
    }

    public function get_edit(Request $request){
        $CompanyID=$request->CompanyID;
        $getCompany = company::where('id', $CompanyID)->get();
        return response()->json(['status'=>200, 'data'=>$getCompany]);
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
            $getCompany = company::where('id', $id)->delete();
            return response()->json(['status'=>200, 'msg'=>"Company deleted successfully."]);
        }


    }




}

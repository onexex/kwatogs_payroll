<?php
namespace App\Http\Controllers;
use App\Models\liloValidations;

use Validator;
use DB;

use Illuminate\Http\Request;
class liloValidationsCtrl extends Controller
{
    //getall
    public function getall(Request $request){
        $getA = liloValidations::latest('created_at')->get();
            if($getA){
                return response()->json(['status'=>200, 'data'=>$getA]);
            }
    }
    //edit
    public function edit(Request $request){
        $liloID=$request->liloID;
        $getA = liloValidations::where('id', $liloID)->get();
        return response()->json(['status'=>200, 'data'=>$getA]);
    }

    //create_update
    public function create_update(Request $request){
        // dd(session()->get('LoggedUserComp'));
        $value =[
            'empCompID'=>session()->get('LoggedUserComp'),
            'lilo_gracePrd' => $request->graceperiod,
            'managersOverride' => $request->mngrsOverride,
            'managersTime' => $request->mngrsTime,
         ];
         $validator = Validator::make($request->all(),[
            'graceperiod' =>'required',
            'mngrsOverride' =>'required',
            'mngrsTime' =>'required',
         ]);
        if(!$validator->passes()){
            return response()->json(['status'=>201, 'error'=>$validator->errors()->toArray()]);
        }else{
                if($request->formAction==1){
                    $query = liloValidations::create($value);
                }else{
                    $query = liloValidations::where('id',$request->liloID)->update($value);
                }
            if($query){
                if($request->formAction==1){
                    return response()->json(['status'=>200, 'msg'=>'Lilo Validation Created.']);
                }else{
                    return response()->json(['status'=>200, 'msg'=>'Lilo Validation Updated.']);
                }
            }else{
                return response()->json(['status'=>202, 'msg'=>'Error']);
            }
        }
    }

}

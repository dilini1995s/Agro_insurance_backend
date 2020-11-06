<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\ValidationException;
use App\Policyfarmer;
use App\Policycrop;

class PolicyCropController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    
    public function updatecropsdetail(Request $request,$policyid)
    {
       
        try{
          
          $rate=$request->input();
          $ra=$rate['rate'];
          $crop=$request->input();
          $cr=$crop['crop'];
          $claim=$request->input();
          $cl=$claim['claim_value'];
           
            for($i=0;$i<count($ra);$i++)
              
           DB::table('policycrops')->where('insurance_id',$policyid)->where('crop_id',$cr[$i])->update(['rate'=>$ra[$i]
           ,'claim_value_for_Acre'=>$cl[$i]]);
            
            $res['status'] = true;
             $res['message'] = 'insert success!';
             return response($res, 200);
         } catch (\Illuminate\Database\QueryException $ex) {
             $res['status'] = false;
             $res['message'] = $ex->getMessage();
             return response($res, 500);
         }
         
         
 
     }
 
}

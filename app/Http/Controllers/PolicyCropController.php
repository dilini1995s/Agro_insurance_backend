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
     public function addnewpolicydetails(Request $request){
    
        $cr=new Policycrop;
        try{
        
            $v1=$request->input();
            $v2=$request->input();
            $v3=$request->input();
            $t1=$v1['value'];
            $t2=$v2['rate'];
            $t3=$v3['crop_id'];
            $d1=$request->input('insurance_id');  

          for($i=0;$i<4;$i++){
         
            $d2=$t3[$i];
            $d3=$t1[$i] ;
            $cr->rate=$t2[$i] ;
            DB::insert('insert into policycrops(insurance_id,crop_id,claim_value_for_Acre,rate) values(?,?,?,?)',
            [$d1,$t3[$i],$t1[$i],$t2[$i]]);
          }
     
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

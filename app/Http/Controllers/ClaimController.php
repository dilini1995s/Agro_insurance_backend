<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use App\Insurance;
use App\Claim;
class ClaimController extends Controller
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

    public function postclaim(Request $request){

        try{
            $claim=new Claim;
            
           $claim->policy_number=$request->input('policy_number');
           $claim->loss_amount=$request->input('amount');
           $claim->NIC=$request->input('NIC');
           $claim->incident_date=$request->input('date');
           $claim->phone=$request->input('phone');
           $claim->account_number=$request->input('account');
           $claim->bank_name=$request->input('date');
           $claim->loan_number=$request->input('loan_number');
           $claim->bank_name=$request->input('bank');
           $claim->branch=$request->input('branch');
           $claim->organization_id=$request->input('organization_id');
           $claim->company_id=$request->input('company_id');
           $claim->type_of_loss=$request->input('loss');
           $claim->image=$request->input('image');
           
            $claim->save();
       
             $res['status'] = true;
             $res['message'] = 'insert success!';
             return response($res, 200);
         } catch (\Illuminate\Database\QueryException $ex) {
             $res['status'] = false;
             $res['message'] = $ex->getMessage();
             return response($res, 500);
         }
     }
    
     public function showfarmerClaim($nic,$company_id)
     {
         //return response()->json(Insurance::find($companies_id));
        $user=Claim::where('NIC', $nic)->where('company_id', $company_id)->get();
        
        if ($user) {
         $res['status'] = true;
         $res['message'] = $user;
 
         return response($res);
         }else{
             $res['status'] = false;
              $res['message'] = 'Cannot find user!';
 
          return response($res);
              }
         }
 
    
   public function getclaimsforOrg($org_id){

    try{
        $user= Claim::where('organization_id',$org_id)->where('organization_verification',NULL)->get();
        $res['status'] = true;
        $res['message'] = $user;
 
         return response($res);
    }catch(\Illuminate\Database\QueryException $ex){
        $res['status'] = false;
        $res['message'] = 'Cannot find user!';
        return response($res);
     }
    }
    public function getclaimdetail($id){

        try{
            $user= Claim::where('id',$id)->get();
            $res['status'] = true;
            $res['message'] = $user;
            return response($res);
        }catch(\Illuminate\Database\QueryException $ex){
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
            return response($res);
         }
    }
    public function getland($id,$policy_num){

        try{
            $user= Claim::where('claims.id',$id)->where('claims.policy_number',$policy_num)->join('farmers','farmers.NIC','claims.NIC')
            ->join('policyfarmers','policyfarmers.NIC','farmers.NIC')->get();
            $res['status'] = true;
            $res['message'] = $user;
            return response($res);
        }catch(\Illuminate\Database\QueryException $ex){
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
            return response($res);
         }
    }
}

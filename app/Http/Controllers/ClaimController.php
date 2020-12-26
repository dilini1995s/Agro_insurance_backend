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

        // $rules = [
        //     'phone' => 'required|regex:/^(0)[0-9]{9}$/' ,
        //     'account' => 'required|regex:/^[0-9]+$/',
        //     'amount' => 'required|regex:/^[0-9]+$/',
        // ];
        //|regex:/^[0-9]{9}[A-Za-z]$/
      //   $rules2 = [
       
      //     'NIC' => 'required|regex:/^[a-zA-Z]*$/',
      //     'Password' => 'required'
      // ];
        //   $customMessages = [
        //      'required' => ':require correct format attribute '
        // ];
        //   $this->validate($request, $rules, $customMessages);
       
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
    
    public function showfarmerClaim($nic,$company_id){
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
    public function gethistoryforOrg($org_id){

        try{
            $user= Claim::where('organization_id',$org_id)->whereIn('organization_verification',[1,0])->get();
            $res['status'] = true;
            $res['message'] = $user;
     
             return response($res);
        }catch(\Illuminate\Database\QueryException $ex){
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
            return response($res);
         }
    }
    public function getAllclaimsforOrg($org_id){

        try{
            $user= Claim::where('organization_id',$org_id)
            ->select('type_of_loss', DB::raw('count(id) as total'))
            ->groupBy('type_of_loss')->get();

            $le1= count($user);
            $arr1=array();
            $arr2=array();
            $arr3=array();
            $amount=array();   
            for($i=0;$i<$le1;$i++){
                $arr1[$i]=$user[$i]->type_of_loss;
                $arr2[$i]=$user[$i]->total;

                
            }
            $res['status'] = true;
            $res['label'] = $arr1;
            $res['data'] = $arr2;
     
             return response($res);
        }catch(\Illuminate\Database\QueryException $ex){
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
            return response($res);
         }
    }
    public function getAllclaimsforCompany($company_id){

        try{
            $user= Claim::where('company_id',$company_id)->where('status','active')
                ->select('type_of_loss', DB::raw('count(id) as total'))
                ->groupBy('type_of_loss')->get();
    
                $le1= count($user);
                $arr1=array();
                $arr2=array();
                $arr3=array();
                $amount=array();   
            for($i=0;$i<$le1;$i++){
                $arr1[$i]=$user[$i]->type_of_loss;
                $arr2[$i]=$user[$i]->total;    
                }
            $res['status'] = true;
            $res['label'] = $arr1;
            $res['data'] = $arr2;
         
             return response($res);
        }catch(\Illuminate\Database\QueryException $ex){
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
            return response($res);
        }
    }
    public function getActiveclaimsforOrg($org_id){

        try{
            $user= Claim::where('organization_id',$org_id)->where('status','active')
                ->select('type_of_loss', DB::raw('count(id) as total'))
                ->groupBy('type_of_loss')->get();
    
                $le1= count($user);
                $arr1=array();
                $arr2=array();
                $arr3=array();
                $amount=array();   
            for($i=0;$i<$le1;$i++){
                $arr1[$i]=$user[$i]->type_of_loss;
                $arr2[$i]=$user[$i]->total;

                }
            $res['status'] = true;
            $res['label'] = $arr1;
            $res['data'] = $arr2;
         
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
    public function getclaimdetailForafarmer($nic){

        try{
            $user= Claim::where('NIC',$nic)->where('status','Active')->get();
            $res['status'] = true;
            $res['message'] = $user;
            return response($res);
        }catch(\Illuminate\Database\QueryException $ex){
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
            return response($res);
         }
    }
    public function getclaimCompany($nic,$company){

        try{
            $user= Claim::where('NIC',$nic)->where('company_id',$company)->where('status','Active')->get();
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

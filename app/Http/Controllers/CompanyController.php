<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Insurancecom;
use App\Insurance;
use App\PolicyFarmer;
use App\Policycrop;
use App\Farmer;
use App\Claim;
class CompanyController extends Controller
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

    public function showcompanies(){

        $user=Insurancecom::all();  
       
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            return response($res);
               
        } 
        else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
    
            return response($res);
         }
    }

    public function getfamers($companyId){

       
        $user=Insurance::where('company_id',$companyId)->join('policyfarmers','policyfarmers.policy_id','insurances.id')
        ->join('farmers','farmers.NIC','policyfarmers.NIC')->select('farmers.Name','farmers.NIC')->distinct()->get();  
       
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            
            return response($res);
        } 
        else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
    
            return response($res);
         }
    }

    public function getselectedfarmerPolicy($nic){

       
       $user=Farmer::where('NIC',$nic)->get();
      
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            return response($res);
             
        } 
        else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
    
            return response($res);
         }
    }
    public function getselectedfarmerdetails($nic){

       
        $user= Policyfarmer::where('policyfarmers.NIC',$nic)->whereIn('policyfarmers.status',['active','closed'])
            ->join('farmers','farmers.NIC','policyfarmers.NIC')->join('insurances','insurances.id','policyfarmers.policy_id')
            ->join('insurancecoms','insurancecoms.id','insurances.company_id')
            ->get();
       
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            
            return response($res);
        } 
        else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
    
            return response($res);
         }
    }
    
    public function showactivePolicy($nic,$com)
    {
          
        try{
            $user= Policyfarmer::where('policyfarmers.NIC',$nic)->where('insurances.company_id',$com)
            ->where('policyfarmers.status',['ACTIVE','CLOSED'])
            ->join('insurances','insurances.id','policyfarmers.policy_id')->select('policyfarmers.id','policyfarmers.premium','policyfarmers.PaidAmount',
            'insurances.name')->get();
   
            $res['status'] = true;
            $res['message'] = $user;
            return response($res, 200);
        }
            
        catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
            return response($res, 500);
        }
          
    } 
    public function updateAmount(Request $request,$policyid){

        try{
            $policy=new PolicyFarmer;
            $ge=PolicyFarmer::where('id',$policyid)->select('PaidAmount')->get();
            $va=$ge[0]->PaidAmount+$request->input('amount');
            DB::table('policyfarmers')->where('id',$policyid)->update(['PaidAmount'=>$va]);
        
            $res['status'] = true;
            $res['message'] = $ge;
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }
    public function getselectedCompanyPolicy($companyid)
    {
          
        try{
            $user= Insurance::where('company_id',$companyid)->get();
   
            $res['status'] = true;
            $res['message'] = $user;
            return response($res, 200);
            }
            
        catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
            return response($res, 500);
        }
          
    } 
    public function showRequestPolicies($companyid){

        $user=PolicyFarmer::where('agent_verification',1)->where('status','Pending')
            ->join('insurances','insurances.id','policyfarmers.policy_id')->where('insurances.company_id',$companyid)->select('policyfarmers.id','insurances.Name')->get();
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            
            return response($res);
        
        } 
        else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
    
            return response($res);
         }
    }
    public function companypolicyverification(Request $request, $policyid)
        {
            $user= Policyfarmer::findOrFail($policyid);

            $user->status= $request->input('ver');
            $user->company_reply= $request->input('issue');
          
        try{
            $user->save();
            $res['status'] = true;
            $res['message'] = 'insert success!';
            return response($res, 200);
        }
            
        catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
          
    }
    public function showCropdetails($policyid){

        $user=Policycrop::where('insurance_id',$policyid)
            ->join('crops','crops.id','policycrops.crop_id')->get();
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
           
            return response($res);
            
        } 
        else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
    
            return response($res);
         }
    }  
    
    public function updateRating(Request $request, $nic)
    {
        
    
        $ge=Farmer::where('NIC',$nic)->select('rating_number')->get();
        if($ge[0]->rating_number==0){
            $va=$ge[0]->rating_number+$request->input('rating');
        }
        else{
            $va=($ge[0]->rating_number+$request->input('rating'))/2;   
        }
       
        DB::table('farmers')->where('NIC',$nic)->update(['rating_number'=>$va]);
        try{
           
            $res['status'] = true;
            $res['message'] = 'insert success!';
            return response($res, 200);
        }
        
        catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
       }
      
    }
    public function addnewpolicy(Request $request){
    
        $ins=new Insurance;
        $ins->company_id=$request->input('company_id');
        $ins->Name=$request->input('Name');
        $ins->Description=$request->input('Description');
        $ins->Benefits=$request->input('Benefits');

        try{
            $ins->save();
            $res['status'] = true;
            $res['id'] = $ins->id;
            $res['message'] = 'insert success!';
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    } 
    public function deletepolicy($insurance_id){
       
        try{
            DB::table('policycrops')->where('insurance_id','=',$insurance_id)->delete();
            Insurance::findorFail($insurance_id)->delete();
       // Policycrop::findorFail($insurance_id)->delete();
            $res['status']=true;
            $res['message'] = 'deleted successfully';
            return response($res, 200);
       
        }catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
       
    }
    public function showRequestClaimAAIB($companyid){

        $user=Claim::whereIn('organization_verification',[1,0])->where('status','pending')
            ->where('company_id',$companyid)->get();
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            return response($res);
        } 
        else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';

             return response($res);
        }
    }  
    
    public function showRequestClaimSanasa($companyid){

        $user=Claim::where('status','Pending')
            ->where('company_id',$companyid)->get();
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            
            return response($res);
            
        } 
        else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
    
             return response($res);
         }
    }

    public function companyclaimverification(Request $request,$claim_id)
    {
        $user= Claim::findOrFail($claim_id);

        $user->status= $request->input('verify');
       // $id=$request->input('land_num');
        try{
            $user->save();
            $res['status'] = true;
            $res['message'] = 'insert success!';
            return response($res, 200);
        }
        
        catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
      
    }

    public function showActivePolicyforCompany($company_id){

      
        $user=DB::table('policyfarmers')->where('policyfarmers.status','active')->where('insurances.company_id',$company_id)
        ->join('insurances','insurances.id','policyfarmers.policy_id') 
        ->select('policyfarmers.Crop', DB::raw('sum(policyfarmers.Size) as total'))
        ->groupBy('policyfarmers.Crop')->get();

        $value=DB::table('policycrops')->join('crops','crops.id','policycrops.crop_id')
        ->select('claim_value_for_Acre','name')->get();
        if ($user)
         {
            $le1= count($user);
            $arr1=array();
            $arr2=array();
            $arr3=array();
             $amount=array();   
            for($i=0;$i<$le1;$i++){
                $arr1[$i]=$user[$i]->Crop;
                $arr2[$i]=$user[$i]->total;
            }
            for($i=0;$i<4;$i++){
                $arr3[$i]=$value[$i]->name;
              for($j=0;$j<$le1;$j++)
                if($arr3[$i]==$arr1[$j]){
                    $amount[$j]=$value[$i]->claim_value_for_Acre*$arr2[$j];
                }
            }

            $res['status'] = true;
            $res['label'] = $arr1;
            $res['data'] = $amount;
      
            return response($res);
           
        } 
        else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
    
             return response($res);
         }
    }
}

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

        //$user1=Insurance::select('companies_id','insurances.Name')->get();
       
        $user=Insurancecom::all();  
        //return response()->json(Insurancecom::all());
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            
           
            return response($res);
                //$res['me']=$user1; 
          
            return response($res);
        } 
        else{
                $res['status'] = false;
                $res['message'] = 'Cannot find user!';
    
             return response($res);
         }
    }

    public function getfamers($companyId){

        //$user1=Insurance::select('companies_id','insurances.Name')->get();
       
        $user=Insurance::where('company_id',$companyId)->join('policyfarmers','policyfarmers.policy_id','insurances.id')
        ->join('farmers','farmers.NIC','policyfarmers.NIC')->select('farmers.Name','farmers.NIC')->distinct()->get();  
        //return response()->json(Insurancecom::all());
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            
           
            return response($res);
                //$res['me']=$user1; 
          
            return response($res);
        } 
        else{
                $res['status'] = false;
                $res['message'] = 'Cannot find user!';
    
             return response($res);
         }
    }
    public function getselectedfarmerPolicy($nic){

        //$user1=Insurance::select('companies_id','insurances.Name')->get();
       $user=Farmer::where('NIC',$nic)->get();
        //return response()->json(Insurancecom::all());
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            
           
            return response($res);
                //$res['me']=$user1; 
          
            return response($res);
        } 
        else{
                $res['status'] = false;
                $res['message'] = 'Cannot find user!';
    
             return response($res);
         }
    }
    public function getselectedfarmerdetails($nic){

        //$user1=Insurance::select('companies_id','insurances.Name')->get();
       
        $user= Policyfarmer::where('policyfarmers.NIC',$nic)->whereIn('policyfarmers.status',['active','closed'])
            ->join('farmers','farmers.NIC','policyfarmers.NIC')->join('insurances','insurances.id','policyfarmers.policy_id')->join('insurancecoms','insurancecoms.id','insurances.company_id')
            ->get();
                $res['status'] = true;
        //return response()->json(Insurancecom::all());
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            
           
            return response($res);
                //$res['me']=$user1; 
          
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
            $user= Policyfarmer::where('policyfarmers.NIC',$nic)->where('insurances.company_id',$com)->where('policyfarmers.status',['ACTIVE','CLOSED'])
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

        $user=PolicyFarmer::whereIn('agent_verification',[1,0])->where('status','Pending')
            ->join('insurances','insurances.id','policyfarmers.policy_id')->where('insurances.company_id',$companyid)->select('policyfarmers.id','insurances.Name')->get();
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            
           
            return response($res);
                //$res['me']=$user1; 
          
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
    public function showCropdetails($policyid){

        $user=Policycrop::where('insurance_id',$policyid)
            ->join('crops','crops.id','policycrops.crop_id')->get();
        if ($user)
        {
            $res['status'] = true;
            $res['message'] = $user;
            
           
            return response($res);
                //$res['me']=$user1; 
          
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
}

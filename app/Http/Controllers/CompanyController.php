<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;
use App\Insurancecom;
use App\Insurance;
use App\PolicyFarmer;
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
       
        $user=Insurance::where('companies_id',$companyId)->join('policyfarmers','policyfarmers.policy_id','insurances.id')
        ->join('farmers','farmers.NIC','policyfarmers.NIC')->get();  
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
       
        $user= Policyfarmer::where('policyfarmers.NIC',$nic)->where('policyfarmers.status','pending')
            ->join('farmers','farmers.NIC','policyfarmers.NIC')->join('insurances','insurances.id','policyfarmers.policy_id')->join('insurancecoms','insurancecoms.id','insurances.companies_id')
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
            $user= Policyfarmer::where('policyfarmers.NIC',$nic)->where('insurances.companies_id',$com)->where('policyfarmers.status',['ACTIVE','CLOSED'])
            ->join('insurances','insurances.id','policyfarmers.policy_id')
           ->get();
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
}

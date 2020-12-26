<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;

use App\Policycrop;
use App\Policyrisk;
use App\Policyfarmer;
use App\Insurance;
class PolicyRiskCropController extends Controller
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
    public function showrisks($company)
    {
      $user=Insurance::where('company_id', $company)
       ->join('policyrisks','insurance_id','insurances.id')->join('risks','risks.id','risk_id')
       ->select('risk_type')
       ->distinct()->get();
       if ($user)
        {
                $res['status'] = true;
                $res['message'] = $user;
             return response($res);
        }
        else
        {
                $res['status'] = false;
                $res['message'] = 'Cannot find user!';

            return response($res);
        }
    }         
    public function showfarmersPolicyrisks1($policyid,$companyid)
    {
     $user=Policyfarmer::where('policyfarmers.id', $policyid)->where('policyfarmers.status', 'active')->where('company_id', $companyid)
       ->join('insurances','insurances.id','policyfarmers.policy_id')
       ->join('policyrisks','insurance_id','insurances.id')->join('risks','risks.risk_type','policyfarmers.risk_type')
       ->join('policycrops','policycrops.insurance_id','insurances.id')->join('crops','crops.name','policyfarmers.Crop')
       ->select('policyfarmers.id','status','policyfarmers.risk_type','policyfarmers.Crop','size','insurances.Name',
       'risks.risk_rate','policycrops.claim_value_for_Acre','policycrops.rate')->distinct()->get();

        if ($user)
        {
                $res['status'] = true;
                $res['message'] = $user;

                $le= count($user);
                $va=array();
                $ex=array();
                $ra=array();
                $v1=array();
          for($i=0;$i<$le;$i++){
              $ra[$i]=$user[$i]->size*$user[$i]->claim_value_for_Acre*$user[$i]->risk_rate;
           
            if($user[$i]->size>5 && $user[$i]->Crop=='Paddy'){
                $ex[$i]=$user[$i]->size-5;
                $va[$i]=$ex[$i]*$user[$i]->claim_value_for_Acre*$user[$i]->rate+$ra[$i];
            }
                 
            elseif ($user[$i]->size>3 && ($user[$i]->Crop=='Maize' || $user[$i]->Crop=='Big Onion' || $user[$i]->Crop=='Potato'))
                {
                    $ex[$i]=$user[$i]->size-3;
                    $va[$i]=$ex[$i]*$user[$i]->claim_value_for_Acre*$user[$i]->rate+$ra[$i];
                }
            else{
                    $va[$i]=$ra[$i];
                }
            }
              
             $res['me']=$va;
             return response($res);
        } 
        else
        {
                $res['status'] = false;
                $res['message'] = 'Cannot find user!';

            return response($res);
        }
    }

    public function showfarmersPolicySanasa($policyid,$companyid)
    {
           
     $crop=Policyfarmer::where('policyfarmers.id', $policyid)->where('company_id', $companyid)->where('policyfarmers.status', 'active')
                ->join('insurances','insurances.id','policyfarmers.policy_id')->select('Crop')->get();
                
                $cr=array();
                $len=count($crop); 
                for($i=0;$i<$len;$i++){
                    $cr[$i]=$crop[$i]->Crop;
                }  
                $res['cr']=$cr;       
      $user=Policyfarmer::where('policyfarmers.id', $policyid)->where('company_id', $companyid)
        ->join('insurances','insurances.id','policyfarmers.policy_id')
        ->join('policycrops','policycrops.insurance_id','insurances.id')
        ->join('crops','crops.id','policycrops.crop_id')->where('crops.name','=' ,$cr)
        ->select('policyfarmers.id','status','policyfarmers.risk_type','size','insurances.Name',
        'policycrops.claim_value_for_Acre','crop_id','policycrops.rate')->distinct()->get();
           
        if ($user)
        {
                $res['status'] = true;
                $res['message'] = $user;
            
                $le= count($user);
                $va=array();
            for($i=0;$i<$le;$i++){
                $va[$i]=$user[$i]->claim_value_for_Acre*$user[$i]->rate;
            }  
                $res['me']=$va; 
                return response($res);
        } 
        else{
                $res['status'] = false;
                $res['message'] = 'Cannot find user!';
    
                return response($res);
         }
    }
            
   
             
    public function showwithoutrisk($policyid,$companyid)
    {
      $user=Policyfarmer::where('policyfarmers.id', $policyid)->where('company_id', $companyid)->where('policyfarmers.status', 'active')
        ->where('policyfarmers.risk_type',NULL)
        ->join('insurances','insurances.id','policyfarmers.policy_id')
        ->join('policyrisks','insurance_id','insurances.id')->join('policycrops','policycrops.insurance_id','insurances.id')
        ->join('crops','crops.name','policyfarmers.Crop')->select('policyfarmers.id','status','policyfarmers.risk_type',
        'size','insurances.Name','policyfarmers.Crop','policycrops.claim_value_for_Acre','policycrops.rate')
        ->distinct()->get();
                
      if ($user)
      {
                $res['status'] = true;
                $res['message'] = $user;
                    
                $le= count($user);
                $va=array();
                $ex=array();
                   
        for($i=0;$i<$le;$i++){
            if($user[$i]->size>5 && $user[$i]->Crop=='Paddy'){
                    $ex[$i]=$user[$i]->size-5;
                    $va[$i]=$ex[$i]*$user[$i]->claim_value_for_Acre*$user[$i]->rate;
            }
                       
            if($user[$i]->size>3 && ($user[$i]->Crop=='Maize' || $user[$i]->Crop=='Big Onion' || $user[$i]->Crop=='Potato')){
                    $ex[$i]=$user[$i]->size-3;
                    $va[$i]=$ex[$i]*$user[$i]->claim_value_for_Acre*$user[$i]->rate;
            }

        }
                $res['me']=$va;
                return response($res);
      } 
      else
      {
                $res['status'] = false;
                $res['message'] = 'Cannot find user!';
            
                return response($res);
      }
                
    }   
        
}

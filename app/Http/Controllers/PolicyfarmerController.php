<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;

use App\Policyfarmer;
use App\Insurance;
class PolicyfarmerController extends Controller
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

   
    public function showfarmersPolicy($va1,$va2)
    {
        //return response()->json(Insurance::find($companies_id));
       $user=Policyfarmer::where('NIC', $va1)->where('company_id', $va2)->join('insurances',
       'insurances.id','policy_id')
       ->select('policyfarmers.id','status','Name')->get();

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

    public function addpremium(Request $request, $id)
        {
            $user= Policyfarmer::findOrFail($id);

            $user->premium= $request->input('premium');
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
    public function showPolicy($id)
    {
          
        try{
            $user= Policyfarmer::where('policyfarmers.id',$id)->join('insurances','insurances.id','policyfarmers.policy_id')
            ->select('policyfarmers.id','policyfarmers.premium','policyfarmers.agent_verification','policyfarmers.Crop','policyfarmers.start_date',
            'policyfarmers.end_date','documents','NIC','risk_type','land_number','agent_reply','company_reply','Size')->get();
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
    
    public function showAllPolicy($nic)
    {
          
        try{
            $user= Policyfarmer::where('policyfarmers.NIC',$nic)->where('policyfarmers.status',['ACTIVE','CLOSED'])
            ->join('insurances','insurances.id','policyfarmers.policy_id')->join('insurancecoms','insurancecoms.id','insurances.company_id')
            ->select('policyfarmers.id','insurances.Name','policyfarmers.status','insurancecoms.name')->get();
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
    public function showActivepremium($nic,$companyid)
    {
          
        try{
            $user= Policyfarmer::where('policyfarmers.NIC',$nic)->where('insurances.company_id',$companyid)->where('policyfarmers.status','ACTIVE')
            ->where('policyfarmers.premium','>',0)->join('insurances','insurances.id','policyfarmers.policy_id')
            ->select('policyfarmers.id','policyfarmers.premium','policyfarmers.agent_verification','policyfarmers.Crop','policyfarmers.PaidAmount','policyfarmers.start_date','policyfarmers.end_date','documents','NIC','risk_type')
            ->get();
                $le=count($user);
                $arr=array();
                for($i=0;$i<$le;$i++){
                    $arr[$i]=$user[$i]->premium-$user[$i]->PaidAmount;
                }
                
                $res['amount']=$arr;
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

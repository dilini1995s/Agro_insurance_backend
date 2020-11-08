<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;
use App\Insurancecom;
use App\Agent;
use App\PolicyFarmer;
class AgentController extends Controller
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

    public function showRequestPolicies($com){

        //$user1=Insurance::select('companies_id','insurances.Name')->get();
       
        /*$user=Agent::where('agents.company_id',$com)->join('farmeragents','farmeragents.id','agents.id')->join('farmers','farmers.NIC','farmeragents.NIC')
            ->join('policyfarmers','policyfarmers.NIC','farmers.NIC')->select('policyfarmers.id')->get(); */ 
        //return response()->json(Insurancecom::all());
        $user=Agent::where('agents.company_id',$com)->where('policyfarmers.agent_verification',NULL)->join('insurancecoms','insurancecoms.id','agents.company_id')->join('insurances','insurances.company_id','insurancecoms.id')
            ->join('policyfarmers','policyfarmers.policy_id','insurances.id')->select('policyfarmers.id','insurances.Name')->get();
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

    public function getAgentId($District,$Gramasewa,$com)
    {
        //return response()->json(Insurance::find($companies_id));
       $user=Agent::where('District', $District)->where('Gramaseva_division', $Gramasewa)
       ->where('company_id', $com)->select('id')->get();
       if ($user){
            $res['status'] = true;
            $res['message'] = $user;

        return response($res);
        }else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';

         return response($res);
        }
        
    }
    public function agentverification(Request $request, $id)
        {
            $user= Policyfarmer::findOrFail($id);

            $user->agent_verification= $request->input('verify');
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
}

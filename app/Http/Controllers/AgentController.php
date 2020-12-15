<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Insurancecom;
use App\Agent;
use App\Farmeragent;
use App\PolicyFarmer;
use App\PolicyCrop;
use App\Crop;
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

    public function showRequestPolicies($id,$com){

        //$user1=Insurance::select('companies_id','insurances.Name')->get();
       
        /*$user=Agent::where('agents.company_id',$com)->join('farmeragents','farmeragents.id','agents.id')->join('farmers','farmers.NIC','farmeragents.NIC')
            ->join('policyfarmers','policyfarmers.NIC','farmers.NIC')->select('policyfarmers.id')->get(); */ 
        //return response()->json(Insurancecom::all());
        // $user=Agent::where('agents.company_id',$com)->where('policyfarmers.agent_verification',NULL)->join('insurancecoms','insurancecoms.id','agents.company_id')
        // ->join('insurances','insurances.company_id','insurancecoms.id')->join('policyfarmers','policyfarmers.policy_id','insurances.id')
        // ->select('policyfarmers.id','insurances.Name')->get();

        $user=Farmeragent::where('policyfarmers.agent_verification',NULL)->where('farmeragents.id',$id)
        ->join('farmers','farmers.NIC','farmeragents.NIC')->join('policyfarmers','policyfarmers.NIC','farmers.NIC')
        ->where('insurances.company_id',$com)->join('insurances','insurances.id','policyfarmers.policy_id')
        ->select('policyfarmers.id','insurances.Name')->get();
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

    public function showhistory($id,$company_id){

        $user=Farmeragent::whereIn('policyfarmers.agent_verification',[1,0])->where('farmeragents.id',$id)->join('farmers','farmers.NIC','farmeragents.NIC')->
        join('policyfarmers','policyfarmers.NIC','farmers.NIC')->where('insurances.company_id',$company_id)->
        join('insurances','insurances.id','policyfarmers.policy_id')->select('policyfarmers.id','policyfarmers.status',
        'policyfarmers.agent_verification','risk_type','Size','company_reply','agent_reply','land_number','policyfarmers.NIC','Crop')->get();
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

    public function showApplyAll($id,$company_id){

        $user=DB::table('farmeragents')->where('farmeragents.id',$id)->join('farmers','farmers.NIC','farmeragents.NIC')->
        join('policyfarmers','policyfarmers.NIC','farmers.NIC')->where('insurances.company_id',$company_id)->
        join('insurances','insurances.id','policyfarmers.policy_id') ->select('policyfarmers.Crop', DB::raw('count(policyfarmers.id) as total'))
        ->groupBy('policyfarmers.Crop')->get();
        if ($user)
        {
            $le= count($user);
            $arr1=array();
            $arr2=array();

            for($i=0;$i<$le;$i++){
                $arr1[$i]=$user[$i]->Crop;
                $arr2[$i]=$user[$i]->total;
            }

            $res['status'] = true;
            $res['label'] = $arr1;
            $res['data'] = $arr2;
        
            return response($res);
        } 
        else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
    
             return response($res);
         }
    }
    public function showRejectPolicy($id,$company_id){

    $user=DB::table('farmeragents')->where('farmeragents.id',$id)->where('policyfarmers.status','reject')
        ->join('farmers','farmers.NIC','farmeragents.NIC')->join('policyfarmers','policyfarmers.NIC','farmers.NIC')
        ->where('insurances.company_id',$company_id)->join('insurances','insurances.id','policyfarmers.policy_id')
        ->select('policyfarmers.Crop', DB::raw('count(policyfarmers.id) as total'))->groupBy('policyfarmers.Crop')->get();
        if ($user)
        {
            $le= count($user);
            $arr1=array();
            $arr2=array();

            for($i=0;$i<$le;$i++){
                $arr1[$i]=$user[$i]->Crop;
                $arr2[$i]=$user[$i]->total;
            }

            $res['status'] = true;
            $res['label'] = $arr1;
            $res['data'] = $arr2;
           
            return response($res);
           
        } 
        else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
    
             return response($res);
         }
    }
    public function showActivePolicy($id,$company_id){

      
    $user=DB::table('farmeragents')->where('policyfarmers.status','active')->where('farmeragents.id',$id)
    ->join('farmers','farmers.NIC','farmeragents.NIC')->join('policyfarmers','policyfarmers.NIC','farmers.NIC')
    ->where('insurances.company_id',$company_id)->join('insurances','insurances.id','policyfarmers.policy_id')
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
    public function getAgentId($District,$Gramasewa,$com){
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
    public function agentverification(Request $request, $id){
            $user= Policyfarmer::findOrFail($id);

            $user->agent_verification= $request->input('verify');
            $user->agent_reply= $request->input('issue');
            $user->status= $request->input('status');
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

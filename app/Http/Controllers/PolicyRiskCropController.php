<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;

use App\Policycrop;
use App\Policyrisk;
use App\Policyfarmer;
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

    
    public function showfarmersPolicyrisks($va1,$va2)
    {
        //return response()->json(Insurance::find($companies_id));
     // $user=Policyfarmer::where('NIC', $va1)->where('companies_id', $va2)->join('insurances','insurances.id','policy_id')
      //->join('policycrops','policy_id','insurances.id')->select('policyfarmers.id','status','Name')->get();

      $user=Policyfarmer::where('policyfarmers.NIC', $va1)->where('companies_id', $va2)->join('insurances','insurances.id','policy_id')
       ->join('policyrisks','insurance_id','insurances.id')->join('risks','risks.risk_type','policyfarmers.risk_type')->join('lands','lands.NIC','policyfarmers.NIC')->select('policyfarmers.id','status','policyfarmers.risk_type','lands.size','Name','rate')->distinct()->get();
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
}

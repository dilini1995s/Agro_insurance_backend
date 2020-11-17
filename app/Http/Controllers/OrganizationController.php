<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;
use App\Insurancecom;
use App\Organization;
use App\Farmeragent;
use App\PolicyFarmer;
class OrganizationController extends Controller
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

   
    public function getOrganizationId($District,$Gramasewa)
    {
        //return response()->json(Insurance::find($companies_id));
       $user=Organization::where('District', $District)->where('Gramaseva_division', $Gramasewa)
      ->select('id')->get();
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

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

    /*public function add(Request $request)
    {
       /* $rules = [
            
            
            'land_num' => 'required',
            'district' => 'required',
            'gramasewa_division' => 'required',
            'size' => 'required',
            'crop' => 'required',
            'nic' => 'required',
            'owership' => 'required'
         ];
 
        $customMessages = [
             'required' => 'Please fill attribute :attribute'
        ];
        $this->validate($request, $rules, $customMessages);*/
 
       /* try {
          
          

            $fa=new Policyfarmer;
            $fa->start_date=$request->input('Start_date');
            $fa->end_date=$request->input('End_date');
            $fa->save();
            /*$save = Land::create([
               
                'land_number'=> $land,
                'Gramaseva_division' =>  $gra,
                'District'=> $dis,
                'Owership'=> $own,
                'Size' =>  $size,
                'Crop'=>$crop,
                'NIC'=> $ni,
               // 'api_token'=> ''
            ]);*/
           /* $res['status'] = true;
            $res['message'] = 'insert success!';
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
}*/
    public function showfarmersPolicy($va1,$va2)
    {
        //return response()->json(Insurance::find($companies_id));
       $user=Policyfarmer::where('NIC', $va1)->where('companies_id', $va2)->join('insurances',
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
}

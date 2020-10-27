<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\ValidationException;
use App\Land;
use App\Agent;
use App\Farmer;
use App\PolicyFarmer;
use App\Farmeragent;
class LandController extends Controller
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

    public function add(Request $request,$id)
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
        $n=$request->input('nic');
        $i=$request->input('id');
       $us=Farmeragent::where('NIC', $n)->where('id', $i)->get();
        try {
            /*$user= $request->input('id');
            DB::table('farmers')
            ->where("NIC", '=',  $id)
            ->update(['Agent_id'=> $user]);*/
            //$user= Farmer::find('NIC', '=', $id);

            $ag=new Farmeragent;
           $land=new Land;
            
          // $user->save();
            $fa=new PolicyFarmer;
            $a=$ag->NIC;
            $g=$ag->id;
           if($us=="[]"
            ){
                $ag->NIC = $request->input('nic');
                $ag->id = $request->input('id');
                $ag->save();
            }    
                
               
        if( $request->input('selectland')==""){
            $land->land_number = $request->input('land_num');
            $land->Gramaseva_division = $request->input('gramasewa_division');
            $land->District = $request->input('district');
            $land->Owership = $request->input('owership');
            $land->NIC= $request->input('nic');
            $land->save();
        }

            $fa->start_date=$request->input('Start_date');
            $fa->end_date=$request->input('End_date');
            $fa->risk_type=$request->input('risk');
            $fa->Size= $request->input('size');
            $fa->Crop= $request->input('crop');
            $fa->policy_id=$request->input('type');
            $fa->NIC= $request->input('nic');
            
        if( $request->input('selectland')==""){
                $fa->land_number = $request->input('land_num');
        }
        else if($request->input('land_num')==""){
            $fa->land_number = $request->input('selectland');
        }
            
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
            $res['status'] = true;
            $res['message'] = 'insert success!';
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }
 
   
    public function getland($nic)
    {
        //return response()->json(Insurance::find($companies_id));
       $user=Land::where('NIC', $nic)->get();
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

   
}

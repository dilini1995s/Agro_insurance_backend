<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;
use App\Land;
use App\PolicyFarmer;
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

    public function add(Request $request)
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
 
        try {
          
           $land=new Land;
            $land->land_number = $request->input('land_num');
            $land->Gramaseva_division = $request->input('gramasewa_division');
            $land->District = $request->input('district');
            $land->Size= $request->input('size');
            $land->Crop= $request->input('crop');
            $land->Owership = $request->input('owership');
            $land->NIC= $request->input('nic');
            $land->save();

            $fa=new PolicyFarmer;
            $fa->start_date=$request->input('Start_date');
            $fa->end_date=$request->input('End_date');
            $fa->risk_type=$request->input('risk');
            $fa->policy_id=$request->input('type');
            $fa->NIC= $request->input('nic');
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
 
   
}

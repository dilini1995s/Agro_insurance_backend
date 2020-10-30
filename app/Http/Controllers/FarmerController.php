<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Farmer;
use App\Check;
class FarmerController extends Controller
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
    public function find(Request $request){

            $check=new Check;
            $check->id=$request->input('id');
            $check->name=$request->input('name');
            $check->crop=$request->input('crop');
            $check->save();

    }
    public function updateFarmer(Request $request,$nic){

       try{
           $f=new Farmer;
           $f->NIC=$nic;
           $na=$request->input('name');
           $ph=$request->input('phone');
           $ad=$request->input('address');
            DB::table('farmers')->where('NIC',$nic)->update(['Name'=>$na,'Phone'=>$ph,'Address'=>$ad]);
      
      
        //$us=Farmer::where('NIC',$nic)->update();
       // $us->Name=$request->input('name');
        //$us->Phone=$request->input('phone');
        //$us->Address=$request->input('address');
        //$us->save();
           $res['status'] = true;
            $res['message'] = 'insert success!';
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
        
        

}

    public function register(Request $request)
    {
        $rules = [
            
            
            'NIC' => 'required',
            'Name' => 'required',
            'Phone' => 'required',
            'Password' => 'required',
         ];
 
        $customMessages = [
             'required' => 'Please fill attribute :attribute'
        ];
        $this->validate($request, $rules, $customMessages);
 
        try {
            $hasher = app()->make('hash');
           
            $NIC = $request->input('NIC');
            $Name = $request->input('Name');
            $Phone = $request->input('Phone');
            $password = $hasher->make($request->input('Password'));
 
            $save = Farmer::create([
               
                'NIC'=> $NIC,
                'Name' =>  $Name,
                'Phone'=>$Phone,
                'Password'=> $password,
               // 'api_token'=> ''
            ]);
            $res['status'] = true;
            $res['message'] = 'Registration success!';
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }
 
    public function get_user()
    {
        $user = Farmer::all();
        if ($user) {
            $res['status'] = true;
            $res['message'] = $user;
 
          return response($res);
        }else{
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
 
          return response($res);
        }
       console.log("hello");
    }
}

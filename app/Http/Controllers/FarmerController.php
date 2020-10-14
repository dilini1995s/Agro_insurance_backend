<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Farmer;
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

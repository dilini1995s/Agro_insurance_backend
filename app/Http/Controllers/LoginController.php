<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Farmer;
use App\Insurancecom;
use App\Agent;
use App\Organization;
class LoginController extends Controller
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
    public function officerlogin(Request $request){

        $rules= [
            'username' => 'required|regex:/^([A-Za-z0-9 ])+$/',
            'Password' => 'required'
        ];
            $customMessages = [
               'required' => ':require correct format attribute '
          ];
           
                 $this->validate($request, $rules, $customMessages);

                 $username = $request->input('username');
                 $pass= $request->input('Password');
                 $login1 = Insurancecom::where('username', $username)->where('password', $pass)->first();
                 $login2 = Agent::where('username', $username)->where('password', $pass)->first();
                 $login3 = Organization::where('username', $username)->where('password', $pass)->first();
                 try{

                    if($login1){
                        $res['data1'] =  $login1;
                        $res['message'] = 'Success loginCompany';
                        return response($res, 200);
                        }
        
                if($login2){
                            $res['data2'] =  $login2;
                            $res['message'] = 'Success login Agent';
                            return response($res, 200);
                            }
                 
                if($login3){
                    $res['data3'] =  $login3;
                    $res['message'] = 'Success login Organization';
                    return response($res, 200);         
                 }
            } catch (\Illuminate\Database\QueryException $ex) {
                    $res['success'] = false;
                    $res['message'] = $ex->getMessage();
                    return response($res, 500);
                }     
               
    }
    public function login(Request $request)
    {
 
      $rules = [
          'NIC' => 'required|regex:/^[0-9]{9}[A-Za-z]$/',
          'Password' => 'required'
      ];
      //|regex:/^[0-9]{9}[A-Za-z]$/
     
        $customMessages = [
           'required' => ':require correct format attribute '
      ];
       
             $this->validate($request, $rules, $customMessages);
        
         $NIC = $request->input('NIC');
        //  $pass= $request->input('Password');
        //  $login1 = Insurancecom::where('username', $NIC)->where('password', $pass)->first();
        //  $login2 = Agent::where('NIC', $NIC)->where('password', $pass)->first();
        //  $login3 = Organization::where('NIC', $NIC)->where('password', $pass)->first();
        // if($login1){
        //         $res['data1'] =  $login1;
        //         $res['message'] = 'Success loginCompany';
        //         return response($res, 200);
        //         }

        // if($login2){
        //             $res['data2'] =  $login2;
        //             $res['message'] = 'Success login Agent';
        //             return response($res, 200);
        //             }
         
        // if($login3){
        //     $res['data3'] =  $login3;
        //     $res['message'] = 'Success login Organization';
        //     return response($res, 200);
        //     }                         
       try {
            $login = Farmer::where('NIC', $NIC)->first();
            
            if ($login) {
                if ($login->count() > 0) {
                    if (Hash::check($request->input('Password'), $login->Password)) {
                        try {
                            //$api_token = sha1($login->id_user.time());
 
                             // $create_token = Farmer::where('id', $login->id_user)->update(['api_token' => $api_token]);
                              $res['status'] = true;
                              $res['message'] = 'Success login';
                              $res['data'] =  $login;
                             // $res['api_token'] =  $api_token;
                             //$res['data1'] =  $login1;
                              return response($res, 200);
 
 
                        } catch (\Illuminate\Database\QueryException $ex) {
                            $res['status'] = false;
                            $res['message'] = $ex->getMessage();
                            return response($res, 500);
                        }
                    } else {
                        $res['success'] = false;
                        $res['message'] = 'Username / email / password not found';
                        return response($res, 401);
                    }
                } else {
                    $res['success'] = false;
                    $res['message'] = 'Username / email / password  not found';
                    return response($res, 401);
                }
            } else {
                $res['success'] = false;
                $res['message'] = 'Username / email / password not found';
                return response($res, 401);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['success'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }
}

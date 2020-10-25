<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;
use App\Insurancecom;
use App\Insurance;
use App\PolicyFarmer;
class CompanyController extends Controller
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

    public function showcompanies(){

        //$user1=Insurance::select('companies_id','insurances.Name')->get();
       
        $user=Insurancecom::all();  
        //return response()->json(Insurancecom::all());
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
}

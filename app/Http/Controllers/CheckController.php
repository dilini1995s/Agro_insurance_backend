<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Validation\ValidationException;
//use App\Farmer;
use App\Check;
class CheckController extends Controller
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
    public function fin(Request $request){

            $check=new Check;
            $check->id=$request->input('id');
            $check->name=$request->input('name');
            $check->crop=$request->input('crop');
           $check->save();

    }

    
}

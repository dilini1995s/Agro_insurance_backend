<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\ValidationException;

use App\Insurance;
class PolicyController extends Controller
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

    
    public function showPolicy($va)
    {
        //return response()->json(Insurance::find($companies_id));
       $user= Insurance::where('companies_id', $va)->get();
       if ($user) {
        $res['status'] = true;
        $res['message'] = $user;

        return response($res);
  }else{
    $res['status'] = false;
    $res['message'] = 'Cannot find user!';

    return response($res);
  }
        //return response()->json(Insurance::all());
    }
    public function showPolicyId($id)
    {
        return response()->json(Insurance::find($id));
      
    }
}

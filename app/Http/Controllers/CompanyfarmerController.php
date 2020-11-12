<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Companyfarmer;

class CompanyfarmerController extends Controller
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
   
    public function postfarmersIssues(Request $request){

       try{
           $fa=new Companyfarmer;
           $fa->NIC=$request->input('NIC');
           $fa->company_id=$request->input('company_id');
            
                $fa->issues=$request->input('issues');
                $fa->suggestions=$request->input('suggestions');
                $fa->save();  
      
            $res['status'] = true;
            $res['message'] = 'insert success!';
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
        
        

    }
    public function showrequestIssues($nic,$company_id){

        try{
            $user= Companyfarmer::where('NIC',$nic)->where('company_id',$company_id)->get();
                $res['status'] = true;
                $res['message'] = $user;
                return response($res, 200);
            }
            
        catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
            return response($res, 500);
        }
    }
    public function showrallrequestIssues(){

        try{
            $user= Companyfarmer::where('status','pending')->get();
                $res['status'] = true;
                $res['message'] = $user;
                return response($res, 200);
            }
            
        catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = 'Cannot find user!';
            return response($res, 500);
        }
    }

    
    public function postcompanyReply(Request $request){

        try{
          
           $id=$request->input('id');
           $answer=$request->input('answer');
             
                 
            DB::table('companyfarmers')->where('id',$id)->update(['answers'=>$answer,'status'=>'replied']);
             
       
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

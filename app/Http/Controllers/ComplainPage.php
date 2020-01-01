<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use App\User;
class ComplainPage extends Controller
{
     protected function add_complain(Request $request)
     {
    
    	$validator = Validator::make($request->all(),[
       
         'complain' => 'required',
        ]);
 $token  = $request->header('token');
           
        if($validator->fails()||empty($token))
        {
        	return response()->json(['stat'=>304, 'msg'=>"empty data"]);   
        }
	   
		else
		{
        	$id=User::select()->where('token',$token)->first();
        	if ($id) {
        				if(DB::table('complains')->insert(
        					['user_id'=>$id->id,'complain'=>$request->complain]))
	                     {
	                         $data["id"]=$id->id;
	                         $data["complain"]=$request->complain;
	    		 return response()->json(['stat'=>200 ,'msg'=>"success","user"=>$data]);
				    }
        	}

        	return response()->json(['stat'=>304, 'msg'=>"empty Data"]);
		}

	}
}

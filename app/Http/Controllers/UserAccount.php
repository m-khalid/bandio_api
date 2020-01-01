<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Str;
use Hash;
use App\User;

class UserAccount extends Controller
{
    public function register(Request $request)
    {
            $request['token']=Str::random(100);
    	$validator = Validator::make($request->all(),[
         'username' => 'required|min:5|max:20|unique:users',
         'email' => 'required|max:80|email|unique:users',
         'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
		 'password_confirmation' => 'required|min:6',
		 'birthdate' => 'required|before:5 years ago',
         'token'=>'unique:users',
        ]);
    unset($request['password_confirmation']); 

   	$request['password']=md5($request['password']);
   
	    if ($validator->fails()) 
	    {      
	   		return response()->json(['stat'=>304, 'msg'=>$validator->messages()->first()]);      
		}

		else if(DB::table('users')->insert($request->all()))
	    {
	        $data=User::select("id","username","email","birthdate","token")
            ->where('username', $request->username)->first();

	    	 return response()->json(['stat'=>200 ,'msg'=>"success","user"=>$data]);
    	}
    	else
    	{
    		return response()->json(['stat'=>304, 'msg'=>"empty Data"]);
    	}
    }

    public function login(Request $request)
    {
    	 $data=User::select("id","username","email","birthdate","token")->where([
        ['password',md5($request->password)],
        ['username',$request->username]
        ])->first();
    	
    	 if ($data) {
    	 	 

    		return response()->json(['stat'=>200 , 'msg'=>"success",'user'=>$data]);
    	 }
    	 else
    	 {
    	 	return response()->json(['stat'=>304, 'msg'=>"empty Data"]);
    	 }
    	 

    }
}

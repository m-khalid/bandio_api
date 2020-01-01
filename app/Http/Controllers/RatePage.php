<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Rate;
use App\User;
use App\Product;
use DB;
class RatePage extends Controller
{
    protected function add_rate(Request $request)
    {
    	 $validator = Validator::make($request->all(),[
         'product_id' => 'required', 
         'rate' => 'numeric|min:1|max:5', 
        ]);
      $token  = $request->header('token');
           
        if($validator->fails()||empty($token))
        {
        	return response()->json(['stat'=>304, 'msg'=>"empty data"]);   
        }
        else
        {
        	$id=User::select()->where('token',$token)->first();
        	$products_id=Product::select('id')->where('id',$request->product_id)->first();
        	
        	if($products_id&&$id)
        	{   
	        	$check=Rate::select('id')->where([
		        ['user_id',$id->id],
		        ['product_id',$request->product_id]
		        ])->first();
	        	if($check)
	        	{
			         DB::table('rates')
		            ->where('id', $check->id)
		            ->update(['rate' => $request->rate]);
	        	}
	        	else
	        	{
	        		DB::table('rates')->insert([
    ['user_id' =>$id->id, 'rate' => $request->rate ,'product_id'=>$request->product_id]
]);
	        	}
	        return response()->json(['stat'=>200, 'msg'=>"success"]);
        	}
        	else
        	{
        		return response()->json(['stat'=>304, 'msg'=>"empty Data"]);
        	}


        }
    }
}

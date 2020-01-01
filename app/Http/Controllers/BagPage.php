<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Product;
use App\Bag;
use App\Detail;
use DB;

class BagPage extends Controller
{
    protected function add_bag(Request $request)
    {
     	 $validator = Validator::make($request->all(),[
         'product_id' => 'required', 
         
         'size'=>'required',
         'product_count'=>'required',
        ]);
        
     	   $token  = $request->header('token');
           
        if($validator->fails()||empty($token))
        {
        	return response()->json(['stat'=>304, 'msg'=>"empty data"]);   
        }
        else
        {
        	$id=User::select()->where('token',$token)->first();
        	$product_id=Detail::select('product_id')->where('product_id',$request->product_id)->first();
        	$product_size=Detail::select('max_count')->where([['product_id',$request->product_id],['size',$request->size]])->first();
        	$detail_id=Detail::select('id')->where([['product_id',$request->product_id],['size',$request->size]])->first();
        	if($id&&$product_id&&$product_size)
        	{
        		$bag = new Bag;
        		 $bag->user_id=$id->id;
        		 $bag->detail_id=$detail_id->id;
        		 $bag->size=$request->size;
        		 $bag->product_count=$request->product_count;
         DB::table('bags')->where([['user_id',$id->id],['detail_id',$detail_id->id]])->delete();
        		 
        		if($bag->save())
        		{

        			return response()->json(['stat'=>200, 'msg'=>"success"]); 
        		}

        	}
        	else
        	{
        		return response()->json(['stat'=>304, 'msg'=>"empty Data"]);
        	}
        	
   		 
    	}
    }
}

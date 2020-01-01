<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Product;
use App\User;
use App\Favorite;
use DB;

class FavouritePage extends Controller
{
    public function favorite(Request $request)

    {
    
    	$validator = Validator::make($request->all(),[
      
         'product_id' => 'required',
        ]);

         $token  = $request->header('token');
           
        if($validator->fails()||empty($token))
        {
        	return response()->json(['stat'=>304, 'msg'=>"empty data"]);   
        }
		else
		{
		    $id=User::select('id')->where('token',$token)->first();
		    if(empty($id))
		    {
		        	return response()->json(['stat'=>304, 'msg'=>"empty data"]);  
		    }
		    $id_favourite=Favorite::select('id')->where('user_id',$id->id)->first();
			$check_product_favourite=DB::table('favorites')->where('product_id',$request->product_id)->first();
	
			if($id_favourite && $check_product_favourite)
			{
			    
			    Favorite::where([['user_id',$id->id],['product_id',$request->product_id]])->delete();
			       return response()->json(['stat'=>200, 'msg'=>"success"]); 
			}
			else{
			
			$check_product=DB::table('products')->where('id',$request->product_id)->first();
		
			 if ($id && $check_product) {
			 	$account = new Favorite;
			 	$account->user_id=$id->id;
			 	$account->product_id=$request->product_id;
			 	DB::table('favorites')->where([['user_id',$id->id],['product_id',$request->product_id]])->delete();
			 	if($account->save())
			 	{
			 	    return response()->json(['stat'=>200, 'msg'=>"success"]); 
			 	}
			 }
			}
			 	
	
		}
			return response()->json(['stat'=>304, 'msg'=>"empty Data"]); 

    }



}

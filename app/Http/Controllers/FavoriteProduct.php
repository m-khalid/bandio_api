<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Product;
use App\User;
use App\Favorite;
use DB;

class FavoriteProduct extends Controller
{
    public function favorites(Request $request)

    {
         $token  = $request->header('token');
           
        if(empty($token))
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
		    $id_favorites=Favorite::select('product_id')->where('user_id',$id->id)->get();
	
	foreach ($id_favorites as $id_favourite)
	{
	   	 $data[]=Product::select("id","category_id","img","offer","price","old_price","Favorite")->where('id',$id_favourite->product_id)->first(); 
	}

         if(empty($data[0])||empty($id->id))
         {
         	return response()->json(['stat'=>304, 'msg'=>"empty Data"]);
         }

        elseif(!empty($data)){

            $fav=Favorite::select('product_id')->where('user_id',$id->id)->get();

         foreach ($data as $index => $value) {
  $num_fav =Favorite::select()->where('product_id',$value->id)->count();
  $value->num_favourit=$num_fav;

    		#edit to url
    		$value->img="https://bandiooo.000webhostapp.com/public/".$value->img; 
            foreach($fav as $fav_product)
            {
                if($fav_product->product_id==$value->id)
                {
                    $value->Favorite="1";   
                }
               
            }
      	}

    	return response()->json(['stat'=>200, 'msg'=>"success","product"=>$data]);    
    }

		    
		}
			return response()->json(['stat'=>304, 'msg'=>"empty Data"]); 

    }



}

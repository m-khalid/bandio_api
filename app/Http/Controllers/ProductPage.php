<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Product;
use App\User;
use App\Favorite;
class ProductPage extends Controller
{
    public function product (Request $request)
    {
    	$validator = Validator::make($request->all(),[
         'category_id' => 'required', 
        
        ]);
            $token  = $request->header('token');
           
        if($validator->fails()||empty($token))
        {
        	return response()->json(['stat'=>304, 'msg'=>"empty data"]);   
        }
         $id=User::select('id')->where('token',$token)->first();

         $data=Product::select("id","category_id","img","offer","price","old_price","Favorite")->where('category_id',$request->category_id)->get();
        
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Bag;
use DB;
use App\Product;
use App\Detail;

class BasketPage extends Controller
{
    protected function basket(Request $request)
    {
   	$token  = $request->header('token');
           
        if(empty($token))
        {
        	return response()->json(['stat'=>304, 'msg'=>"empty data"]);   
        }
        else
        {
        	$id=User::select()->where('token',$token)->first();
        	if($id)
        	{	
            $check=Bag::select("id")->where('user_id',$id->id)->first();

        		if($check)
        		{
        			 $data= DB::table('details')
            ->join('products', 'details.product_id', '=', 'products.id')
            ->join('bags', 'details.id', '=', 'bags.detail_id')
            ->select('products.text', 'products.price','details.size','details.id','products.img','details.max_count')->where('user_id',$id->id)
            ->get();
            foreach($data as $basket)
            {
                $basket->img="https://bandiooo.000webhostapp.com/public/".$basket->img;
            }
            	return response()->json(['stat'=>200, 'msg'=>"success","basket"=>$data]);   
        		}
        		else
        		{
        			return response()->json(['stat'=>304, 'msg'=>"empty Data"]);		
        		}
        	}
        	else
        	{
        		 	return response()->json(['stat'=>304, 'msg'=>"empty Data"]); 
        	}
        }	
       
    }


    protected function buy(Request $request)
    {
    	$validator = Validator::make($request->all(),[
         'product_id' => 'required', 
         'product_count'=>'required',
         'total'=>'required',
        ]);
     	 $token  = $request->header('token');
           
        if($validator->fails()||empty($token))
        {
        	return response()->json(['stat'=>304, 'msg'=>"empty data"]);   
        }
        else
        {


            $id=User::select()->where('token',$token)->first();
            $products_orders=$request->input('product_id');
                $counts_orders=$request->input('product_count');

            if($id&&$products_orders[0]&&$counts_orders[0])
            {
                foreach ($products_orders as  $value) {
              if($data_product=Detail::select('id')->where('id',$value)->first()){
                    continue;
              }
              else
              {
               return response()->json(['stat'=>304, 'msg'=>"empty Data"]);    
              }

                }
                
               
                foreach ($products_orders as $index=>$product) {
             $data= Detail::select('max_count')->where('id',$product)->first();

                    if($data->max_count-$counts_orders[$index]>=0)
                    {
                        continue;
                    }
                    else
                    {
                      return(response()->json(['stat'=>304 , 'msg'=>"Wrong Data"]));
                    }
            }
          
        $id_product = serialize(array($products_orders)); 
        $count_of_product=serialize(array($counts_orders));
  
       DB::table('baskets')->insert(
    ['product_id' => $id_product, 'total' => $request->total,'product_count'=>$count_of_product,'user_id'=>$id->id]);          
     

for( $i=0; $i<count($products_orders); $i++) {
            DB::table('details')->where('id',$products_orders[$i])->decrement('max_count', $counts_orders[$i]);
            Bag::where([['detail_id',$products_orders[$i]],['user_id',$id->id]])->delete();


        }
        return response()->json(['stat'=>200, 'msg'=>"success"]);    
    }

            
             return response()->json(['stat'=>304, 'msg'=>"empty Data"]);    
            

        
        
   	
    }
}

}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Product;
use App\Detail;
use App\Rate;
use App\User;
class DetailPage extends Controller
{
    protected function detail(Request $request)
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
          $id=User::select()->where('token',$token)->first();
          $data_product=Product::select()->where('id',$request->product_id)->first(); 
        	if($id&&$data_product){
         
       $data_details_img=Detail::select('img')->where('product_id',$request->product_id)->get();
     $data_details_size=Detail::select('size')->where('product_id',$request->product_id)->get();
     $data_details_rate=Rate::where('product_id',$request->product_id)->avg('rate');
     $data_num_rate=Rate::where('product_id',$request->product_id)->count('rate');
     foreach ($data_details_img as $index => $value) {


    		#edit to url
    		$value->img="https://bandiooo.000webhostapp.com/public/".$value->img; 
     }     
          $data=(["id"=>$data_product->id,
              "img"=>$data_details_img,
          "text"=>$data_product->text,
          "price"=>$data_product->price,
          "old_price"=>$data_product->old_price,
          "offer"=>$data_product->offer,
          "size"=>$data_details_size,
          "rate"=>$data_details_rate,
          "num_rate"=>$data_num_rate]);
         return response()->json(['stat'=>200, 'msg'=>"success","product"=>$data]);
        }
        return response()->json(['stat'=>304, 'msg'=>"empty Data"]);
      }
		    
		    

		 }   

     }


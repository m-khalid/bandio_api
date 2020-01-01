<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class HomePage extends Controller
{
    public function home()
    {
    	$slider=DB::table('homes')->select('*')->where('type', 1)->get();
    	$home=DB::table('homes')->select('*')->where('type', 2)->get();
    	foreach ($slider as $index => $value) {
    		#edit to url
    		$home[$index]->img="https://bandiooo.000webhostapp.com/public/".$home[$index]->img;
    		$value->img="https://bandiooo.000webhostapp.com/public/".$value->img; 
    	}


    	return response()->json(['stat'=>200 ,'msg'=>"success","slider"=>$slider,"home"=>$home]);
    }
}

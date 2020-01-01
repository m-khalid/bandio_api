<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AboutusPage extends Controller
{
   protected function about()
   {
       	return response()->json(['stat'=>200, 'msg'=>"success","aboutus"=>"Bnadio, Egypt's no. 1 online mall was established in december 2019 with the aim and vision to become the one-stop shop in Egypt with implementation of best practices both online and offline.
Bandio is the largest online mall store in Egypt."]); 
   }
}

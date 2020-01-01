<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->post('/register','UserAccount@register');
Route::middleware('api')->post('/login','UserAccount@login');
Route::middleware('api')->get('/home','HomePage@home');
Route::middleware('api')->post('/product','ProductPage@product');
Route::middleware('api')->post('/favorite','FavouritePage@favorite');
Route::middleware('api')->post('/unfavorite','FavouritePage@unfavorite');
Route::middleware('api')->post('/details','DetailPage@detail');
Route::middleware('api')->post('/rate','RatePage@add_rate');
Route::middleware('api')->post('/bag','BagPage@add_bag');
Route::middleware('api')->post('/basket','BasketPage@basket');
Route::middleware('api')->post('/checkout','BasketPage@buy');
Route::middleware('api')->post('/complain','ComplainPage@add_complain');
Route::middleware('api')->get('/aboutus','AboutusPage@about');
Route::middleware('api')->post('/favoriteproduct','FavoriteProduct@favorites');



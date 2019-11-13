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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function(){
    Route::post('/users', 'UserController@store');
    Route::post('/login', 'Auth\\LoginJwtController@login')->name('login');
    
Route::group(['middleware' => ['jwt.auth']], function()	{
    Route::prefix('users')->group(function(){
        Route::get('/', 'UserController@index');
        Route::get('/{id}', 'UserController@show');
        Route::put('/{id}', 'UserController@update');
        Route::delete('/{id}', 'UserController@destroy');
    });

    Route::name('refunds.')->group(function(){   
        Route::resource('/refunds', 'RefundController');
        Route::post('/refunds/photos/{id}', 'RefundController@uploadPhoto');
        Route::post('/refunds/relatorio', 'RefundController@relatorio');
        
    });
});



    

    


});
<?php
//use Illuminate\Http\Request;





Route::group(['prefix' => 'products'] , function ($r){
    Route::get('/','ProductController@index');
    Route::get('/{id}','ProductController@show')->where('id' , '[0-9]+');
    Route::post('/','ProductController@store');
    Route::put('/{id}','ProductController@update')->where('id' , '[0-9]+');
    Route::delete('/{id}','ProductController@delete')->where('id' , '[0-9]+');
});

Route::group(['prefix' => 'categories'] , function ($r){
    Route::get('/','CategoryController@index');
    Route::get('/{id}','CategoryController@show')->where('id' , '[0-9]+');
    Route::post('/','CategoryController@store');
    Route::put('/{id}','CategoryController@update')->where('id' , '[0-9]+');
    Route::delete('/{id}','CategoryController@delete')->where('id' , '[0-9]+');
});

Route::group(['middleware'=>'auth:api','prefix' => 'orders  '] , function ($r){
    Route::get('/','OrderController@index');
    Route::get('/{id}','OrderController@show')->where('id' , '[0-9]+');
    Route::post('/','OrderController@store');
    Route::put('/{id}','OrderController@update')->where('id' , '[0-9]+');
    Route::delete('/{id}','OrderController@delete')->where('id' , '[0-9]+');
});

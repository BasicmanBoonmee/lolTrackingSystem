<?php

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/logout', ['as' => 'logout', 'uses' => 'LoginController@doLogout']);

    Route::group(['prefix' => 'client'],function(){
        Route::get('/',['as' => 'client.index', 'uses' => 'ClientController@index']);
        Route::get('/add',['as' => 'client.add', 'uses' => 'ClientController@addClient']);
        Route::get('/edit/{id}',['as' => 'client.edit', 'uses' => 'ClientController@editClient']);
        Route::post('/',['as' => 'client.store', 'uses' => 'ClientController@store']);
        Route::post('/update',['as' => 'client.update', 'uses' => 'ClientController@update']);
        Route::get('/delete/{id}',['as' => 'client.delete', 'uses' => 'ClientController@delete']);
        Route::post('/ajax',['as' => 'client.ajax', 'uses' => 'ClientController@ajax']);
        Route::post('/rateajax',['as' => 'client.rateajax', 'uses' => 'ClientController@rateajax']);
        Route::post('/saveajax',['as' => 'client.saveajax', 'uses' => 'ClientController@saveajax']);
        Route::post('/getedit',['as' => 'client.getrate', 'uses' => 'ClientController@getRate']);
        Route::post('/deleterate',['as' => 'client.deleterate', 'uses' => 'ClientController@deleteRate']);
        Route::post('/search',['as' => 'client.search', 'uses' => 'ClientController@search']);
    });

    Route::group(['prefix' => 'client-rate'],function(){
        Route::get('/',['as' => 'clientrate.index', 'uses' => 'ClientRateController@index']);
        Route::get('/add',['as' => 'clientrate.add', 'uses' => 'ClientRateController@add']);
        Route::get('/edit/{id}',['as' => 'clientrate.edit', 'uses' => 'ClientRateController@edit']);
        Route::post('/',['as' => 'clientrate.store', 'uses' => 'ClientRateController@store']);
        Route::post('/update',['as' => 'clientrate.update', 'uses' => 'ClientRateController@update']);
        Route::get('/delete/{id}',['as' => 'clientrate.delete', 'uses' => 'ClientRateController@delete']);
        Route::post('/ajax',['as' => 'clientrate.ajax', 'uses' => 'ClientRateController@ajax']);
    });

    Route::group(['prefix' => 'linguist'],function(){
        Route::get('/',['as' => 'linguist.index', 'uses' => 'LinguistsController@index']);
        Route::get('/add',['as' => 'linguist.add', 'uses' => 'LinguistsController@addLinguist']);
        Route::get('/edit/{id}',['as' => 'linguist.edit', 'uses' => 'LinguistsController@editLinguist']);
        Route::post('/',['as' => 'linguist.store', 'uses' => 'LinguistsController@store']);
        Route::post('/update',['as' => 'linguist.update', 'uses' => 'LinguistsController@update']);
        Route::get('/delete/{id}',['as' => 'linguist.delete', 'uses' => 'LinguistsController@delete']);
        Route::post('/ajax',['as' => 'linguist.ajax', 'uses' => 'LinguistsController@ajax']);
        Route::post('/search',['as' => 'linguist.search', 'uses' => 'LinguistsController@search']);
        Route::post('/ratelevel',['as' => 'linguist.ratelevel', 'uses' => 'LinguistsController@ratelevel']);
    });

    Route::group(['prefix' => 'linguist-level'],function(){
        Route::get('/',['as' => 'linguistlevel.index', 'uses' => 'LinguistlevelController@index']);
        Route::get('/add',['as' => 'linguistlevel.add', 'uses' => 'LinguistlevelController@add']);
        Route::get('/edit/{id}',['as' => 'linguistlevel.edit', 'uses' => 'LinguistlevelController@edit']);
        Route::post('/',['as' => 'linguistlevel.store', 'uses' => 'LinguistlevelController@store']);
        Route::post('/update',['as' => 'linguistlevel.update', 'uses' => 'LinguistlevelController@update']);
        Route::get('/delete/{id}',['as' => 'linguistlevel.delete', 'uses' => 'LinguistlevelController@delete']);
        Route::post('/ajax',['as' => 'linguistlevel.ajax', 'uses' => 'LinguistlevelController@ajax']);
    });

    Route::group(['prefix' => 'project'],function(){
        Route::get('/',['as' => 'project.index', 'uses' => 'ProjectController@index']);
        Route::get('/add',['as' => 'project.add', 'uses' => 'ProjectController@add']);
        Route::get('/edit/{id}',['as' => 'project.edit', 'uses' => 'ProjectController@edit']);
        Route::post('/',['as' => 'project.store', 'uses' => 'ProjectController@store']);
        Route::post('/update',['as' => 'project.update', 'uses' => 'ProjectController@update']);
        Route::get('/delete/{id}',['as' => 'project.delete', 'uses' => 'ProjectController@delete']);
        Route::post('/ajax',['as' => 'project.ajax', 'uses' => 'ProjectController@ajax']);
        Route::post('/lgajax',['as' => 'project.lgajax', 'uses' => 'ProjectController@lgajax']);
        Route::post('/getlg',['as' => 'project.getlg', 'uses' => 'ProjectController@getProjectLg']);
        Route::post('/deletelg',['as' => 'project.dellg', 'uses' => 'ProjectController@deleteProjectLg']);
        Route::post('/saveajax',['as' => 'project.saveajax', 'uses' => 'ProjectController@saveajax']);
    });

    Route::get('/', ['as' => 'dashboard', 'uses' => 'HomeController@dashboard']);
});


Route::get('/login',['as' => 'login', 'uses' => 'LoginController@index'] );
Route::post('/login',['as' => 'login', 'uses' => 'LoginController@doLogin']);



<?php

use Illuminate\Support\Facades\Route;

// Https://Docs.TrixCMS.Eu

Route::group(['namespace' => 'Admin'], function() {
    Route::get('roulette', ['as' => 'admin.roulette', 'uses' => 'HomeController@index']);
    Route::post('roulette_configure', ['as' => 'admin.roulette.configure', 'middleware' => 'permissions:DASHBOARD_ROULETTE_CONFIGURE|admin', 'uses' => 'HomeController@configure']);
    Route::post('roulette_add', ['as' => 'admin.roulette.add', 'middleware' => 'permissions:DASHBOARD_ROULETTE_CONFIGURE|admin', 'uses' => 'HomeController@add']);
    Route::post('roulette_edit', ['as' => 'admin.roulette.edit', 'middleware' => 'permissions:DASHBOARD_ROULETTE_CONFIGURE|admin', 'uses' => 'HomeController@edit']);
    Route::get('roulette_delete_{id}', ['as' => 'admin.roulette.delete', 'middleware' => 'permissions:DASHBOARD_ROULETTE_CONFIGURE|admin', 'uses' => 'HomeController@delete']);

});
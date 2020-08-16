<?php

use Illuminate\Support\Facades\Route;

// Https://Docs.TrixCMS.Eu

Route::get('roulette', ['as' => 'roulette', 'uses' => 'RouletteController@index']);
Route::get('roulette/getPrice', ['as' => 'roulette.getPrice', 'uses' => 'RouletteController@getPrice']);
Route::post("roulette/ajax_beforeSpin", ['as' => 'roulette.ajax_beforeSpin', 'uses' => 'RouletteController@ajax_beforeSpin']);
Route::post("roulette/ajax_roulette", ['as' => 'roulette.ajax_roulette', 'uses' => 'RouletteController@ajax_roulette']);

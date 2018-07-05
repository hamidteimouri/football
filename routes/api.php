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

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function () {

    Route::apiResource('team','TeamController');
    Route::apiResource('player','PlayerController');
    /*
    Route::get('/team', ['as' => 'api.team.index', 'uses' => 'TeamController@index']);
    Route::get('/team/{team}', ['as' => 'api.team.show', 'uses' => 'TeamController@show']);
    */
});

Route::post('/login', ['as' => 'api.auth.login', 'uses' => 'Api\AuthController@login']);
Route::post('/register', ['as' => 'api.auth.register', 'uses' => 'Api\AuthController@register']);
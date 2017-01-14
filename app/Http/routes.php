<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(array('prefix'=>'api/v1.0'), function(){
    Route::resource('vehiculos','VehiculoController', ['only' => ['index', 'show']]); //Solo necesitamos index y show
    Route::resource('fabricantes','FabricanteController');
    Route::resource('fabricantes.vehiculos','FabricanteVehiculoController',['except' => 'show']); //recurso anidado
//Route::get('/','VehiculoController@showAll'); //Muestra todos los vehiculos
});


Route::pattern('inexistente', '.*');
Route::any('/{inexistente}', function()
{
	return response()->json(['mensaje' => 'Ruta o metodos incorrectos.', 'codigo' => 400],400);
});

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('contenido/contenido');
});

//Route::post('/categoria/desactivar', function () {
   // return "HOAL";
//});



//Route::resource('/categorias','Categoria\CategoriaController');
//Route::put('/categoria/activar','Categoria\CategoriaController@activar');
Route::get('/categorias', 'Categoria\CategoriaController@index');
Route::post('/categoria/registrar', 'Categoria\CategoriaController@store');
Route::post('/categoria/actualizar', 'Categoria\CategoriaController@update');
Route::post('/categoria/desactivar', 'Categoria\CategoriaController@desactivar');
Route::post('/categoria/activar','Categoria\CategoriaController@activar');


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
use Illuminate\Http\Request;
use App\Http\Middleware\CheckLogin;

Route::get('/', function () {
    return view('admin.login');
});

Route::get('welcome', function () {
    return view('email');
});



Route::post('login', 'Auth\LoginController@getLogin');
Route::get('login', 'Auth\LoginController@getLogin');
Route::get('logout', 'Auth\LoginController@logout');
Route::post('UpdatePwd', 'Auth\LoginController@UpdatePwd');
//Route::get('admin/test', 'AdminController@test');

Route::middleware(['auth'])->group( function() { 

});

Route::get('/{controller}/{action?}', function($controller, $action = 'index' , Request $request) {
    $controller = ucfirst(strtolower($controller) . "Controller");
    $action = "get" . ucfirst(strtolower($action));
    $name = "\App\Http\Controllers\\" . $controller;
    $class = new $name();
    return $class->{$action}('', $request);
})->middleware(CheckLogin::class);

Route::get('/{controller}/{action}/{id?}', function($controller, $action = 'index', $id='', Request $request) {
    $controller = ucfirst(strtolower($controller) . "Controller");
    $action = "get" . ucfirst(strtolower($action));
    $name = "\App\Http\Controllers\\" . $controller;
    $class = new $name();
    return $class->{$action}($id, $request);
})->middleware(CheckLogin::class);


Route::post('/{controller}/{action?}', function($controller, $action = 'index', Request $request) {    
    $controller = ucfirst($controller . "Controller");
    $action = "get" . ucfirst($action);
    $name = "\App\Http\Controllers\\" . $controller;
    $class = new $name('url');
    return $class->{$action}('',  $request);   
})->middleware(CheckLogin::class);


Route::post('/{controller}/{action}/{id?}', function($controller, $action = 'index', $id='', Request $request) {    
    $controller = ucfirst($controller . "Controller");
    $action = "get" . ucfirst($action);
    $name = "\App\Http\Controllers\\" . $controller;
    $class = new $name('url');
    return $class->{$action}($id,  $request);   
})->middleware(CheckLogin::class);








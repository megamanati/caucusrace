<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
    return view('welcome');
});

// #Ruta de login
// Route::view('/login', 'login')->name('login');

#pasa a la vista test un arreglo de parametros
Route::view('/test', 'test', ['name' => null]);
Route::view('/gfg', 'gfg');

Route::get('/greeting', 
    function () {
        return 'Hello World';
    }
);

// use App\Http\Controllers\UserController;

// Route::get('/user', [UserController::class, 'index']);

use Illuminate\Http\Request;

// Route::post('/users', 
//     function(Request $request) {
//         $param1 = 'hola';
//         $param2 = 'adios'; 
//         return $param1.$param2;
// });

#/user/##CUALQUIER ID QUE PONGAS SE RESUELVE##
Route::get('/user/{id}', function (Request $request, $id) {
    
    return 'User '.$id;
}); 
    
#localhost/users?&asdf=&asdfsd=
Route::get('/users', 
    function (Request $request) {
        $param1 = $request->asdf;
        $param2 = $request->asdfsd;
        return "{$param1} y {$param2}";
        // return $request;
});

#localhost/users/asdf/asdfsd/
// Route::get('/users/{asdf}/{asdfsd}', 
//     function ($param1, $param2) {
//         // $param_1 = $_GET['asdf'];
//         // $param_2 = $_GET['asdfsd'];
//         return "{$param1} y {$param2}";
//         // return $request;
// });

// Route::get($uri, $callback);

#Cuando puede o no tener la URI algun dato como el nombre
Route::get('/users/{asdf?}/asdfsd?', function ($param1 = null, $param2 = null) {
    return "{$param1} y {$param2}";
});

// Route::get('/user/{name?}', function ($name = 'John') {
//     return $name;
// });

#Redireccion de rutas localhost/here a localhost/there
Route::redirect('/here', '/there');

#redireccionar a otro dominio
Route::get('/there', 
    function () {
        // return 'Llegue de...';
        return redirect('http://www.google.com');
    }
);



Route::get('/dominio/{id?}', 
    function($id) {
        //$route = Route::current(); // Illuminate\Routing\Route


    $users = DB::select('select * from dominio');

    foreach ($users as $user) {
        echo $user->name;
    }
        $name = Route::currentRouteName(); // string
        $action = Route::currentRouteAction(); 
        return $id.' '.' '.$name.' '.$action;
});



Route::post('/dominio/{id?}', 
    function(Request $request) { 
        //$route = Route::current(); // Illuminate\Routing\Route
        $name = Route::currentRouteName(); // string
        $action = Route::currentRouteAction(); 
        return $name.' '.$action;
})->name('domain');


Route::get('/user/{id}/profile', function ($id) {
    $url = $id;
    return 'Numero de perfil: '.$url;
})->name('profile');

#Se puede forzar una expresion regular sobre la URI
Route::get('/user/{name?}', function ($name) {
    return 'problema 1';
})->where('name', '[A-Za-z]+');

Route::get('/user/{id?}', function ($id) {
    return 'problema 2';
})->where('id', '[0-9]+');

Route::get('/user/{id}/{name?}', function ($id, $name) {
    return 'problema 3';
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);

#Existen otros metodos como ->whereNumber('id')->whereAlpha('name') o ->whereAlphaNumeric('name'); o ->whereUuid('id');
#Tambien se puede forzar a todos los parametros globalmente
#En metodo boot de la clase App\Providers\RouteServiceProvider

// /**
//  * Define your route model bindings, pattern filters, etc.
//  *
//  * @return void
//  */
// public function boot()
// {
//     Route::pattern('id', '[0-9]+');
// }


Route::get('/profile', function () {
    //
})->middleware('auth');


Route::fallback(function () {
    //
    return redirect('/');
});
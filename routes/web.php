<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DominiosController;
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
use Illuminate\Support\Facades\App;

// Route::domain('{subdomain}.localhost')->group(function(){
//     Route::get('subdomain/{subdomain}' ,  [DominiosController::class, 'subdomain'])->name('subdomain');
// });


Route::domain('{subdomain}.localhost')->group(function () {
    Route::get('/',  [DominiosController::class, 'subdomain'])->where('subdomain', '(.*)');
});

Route::domain('{subdomain}.caucusrace.org')->group(function () {
    Route::get('/',  [DominiosController::class, 'subdomain'])->where('subdomain', '(.*)');
        //return view('home', ['name' => null]);
});

Route::domain('{subdomain}.and.republic')->group(function () {
    Route::get('/',  [DominiosController::class, 'subdomain'])->where('subdomain', '(.*)');
        //return view('home', ['name' => null]);
});

Route::domain('{subdomain}.and.democrat')->group(function () {
    Route::get('/',  [DominiosController::class, 'subdomain'])->where('subdomain', '(.*)');
        //return view('home', ['name' => null]);
});

Route::get('/home', function(){
    return view('home', ['name' => null]);
})->name('home');

Route::get('/', function () {

    return redirect('/home');
    // return view('welcome');
});

Route::get('/home', function(){
    return view('home', ['name' => null]);
})->name('home');


// #Ruta de login
// Route::view('/login', 'login')->name('login');

#pasa a la vista test un arreglo de parametros
Route::view('/test', 'test', ['name' => null]);
Route::view('/gfg', 'gfg');

// Route::get('/greeting',     function () {        return 'Hello World';    });
Route::view('midominio.lista', 'midominio.lista')->name('midominio.lista');

// use App\Http\Controllers\UserController;

// Route::get('/user', [UserController::class, 'index']);

use Illuminate\Http\Request;


Route::get('/midominio', [DominiosController::class, 'index'])->name('midominio.index');
Route::post('/midominio/{domainName?}', [DominiosController::class, 'getdominio'])->name('midominio.midominio');

// Route::post('/users', 
//     function(Request $request) {
//         $param1 = 'hola';
//         $param2 = 'adios'; 
//         return $param1.$param2;
// });

#/user/##CUALQUIER ID QUE PONGAS SE RESUELVE##
// Route::get('/user/{id}', function (Request $request, $id) { return 'User '.$id; }); 
    
#localhost/users?&asdf=&asdfsd=
// Route::get('/users', 
//     function (Request $request) {
//         $param1 = $request->asdf;
//         $param2 = $request->asdfsd;
//         return "{$param1} y {$param2}";
//         // return $request;
// });

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
// Route::get('/users/{asdf?}/asdfsd?', function ($param1 = null, $param2 = null) {
//     return "{$param1} y {$param2}";
// });

#Redireccion de rutas localhost/here a localhost/there
//Route::redirect('/here', '/there');

#redireccionar a otro dominio
// Route::get('/there', 
//     function () {
//         // return 'Llegue de...';
//         return redirect('http://www.google.com');
//     }
// );


Route::get('/user/{id}/profile', function ($id) {
    $url = $id;
    return 'Numero de perfil: '.$url;
})->name('profile');

Route::get('welcome', function() { return 'Welcome';})->name('domain');

// #Se puede forzar una expresion regular sobre la URI
// Route::get('/user/{name?}', function ($name) {
//     return 'problema 1';
// })->where('name', '[A-Za-z]+');

// Route::get('/user/{id?}', function ($id) {
//     return 'problema 2';
// })->where('id', '[0-9]+');

// Route::get('/user/{id}/{name?}', function ($id, $name) {
//     return 'problema 3';
// })->where(['id' => '[0-9]+', 'name' => '[a-z]+']);

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


// Route::get('/profile', function () {
//     //
// })->middleware('auth');


Route::fallback(function () {
    //
    return redirect('/');
});
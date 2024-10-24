<?php

use App\Http\Controllers\TesteController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return response()->json(['sucess' => '200'], 200);
});

Route::group(['middleware' => 'auth'], function (Router $router) {
    $router->post('/teste', [TesteController::class, 'teste']);
});

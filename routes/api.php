<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\users;
use App\Http\Controllers\processes;
use App\Http\Controllers\offices;
use App\Http\Controllers\office_processes;

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
Route::get('get/users', [users::class, 'getUsers']);
Route::delete('delete/user/{email}', [users::class, 'deleteUser']);
Route::get('get/user/{email}', [users::class, 'login']);
Route::post('post/user', [users::class, 'postUser']);

Route::delete('delete/office/{id}', [offices::class, 'deleteOffice']);
Route::get('get/office/{id}', [offices::class, 'getOffice']);
Route::get('get/user/offices/{id}', [offices::class, 'userOffices']);
Route::post('post/office', [offices::class, 'postOffice']);
Route::put('put/office', [offices::class, 'putOffice']);


Route::get('get/offices', [offices::class, 'getOffices']);
Route::get('get/processes', [processes::class, 'getProcesses']);
Route::get('get/office/processes', [office_processes::class, 'getOfficeProcesses']);
   
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

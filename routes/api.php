<?php

use App\Http\Controllers\DTSController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('local-hr/get-directorates', [DTSController::class, 'getDirectoratesFromLocalHR']);
Route::get('local-hr/get-employees', [DTSController::class, 'getEmployeesFromLocalHR']);
Route::get('get-archive-data/docs', [DTSController::class, 'getArchiveData']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

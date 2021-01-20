<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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
})->name('welcome');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('tasks', \App\Http\Controllers\TaskController::class);

    Route::resource('users', \App\Http\Controllers\UsersController::class);

    Route::resource('videos', \App\Http\Controllers\VideoController::class);

    Route::resource('activity-logs', \App\Http\Controllers\ActivityLogsController::class);

    Route::get('/activity-logs-ajax', [\App\Http\Controllers\ActivityLogsController::class, 'indexAjax']);

    Route::get('/overviews/reporters', [\App\Http\Controllers\OverviewsController::class, 'reporters'])->name('overview.reporters');
    Route::get('/overviews/subjects', [\App\Http\Controllers\OverviewsController::class, 'subjects'])->name('overview.subjects');
});

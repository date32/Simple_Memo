<?php

use App\Http\Controllers\MemoController;
use App\Http\Controllers\TestController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});



Route::get('/memo', function () {
    return Inertia::render('Memo/Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/',[MemoController::class, 'welcome'])->name('welcome');
Route::get('/memo/login',[MemoController::class, 'login']);
Route::get('/memo/register',[MemoController::class, 'register']);
Route::get('/memo/logout',[MemoController::class, 'logout']);

Route::middleware('auth')->group(function() {
    Route::get('/memo',[MemoController::class, 'index'])->name('index');
});


// Route::get('/m',[MemoController::class, 'index'])->middleware('auth')->name('index');
// Route::get('/m',[MemoController::class, 'index'])->name('index');
// Route::post('/memo/store',[MemoController::class, 'store']);
// Route::post('/memo/delete/{id}',[MemoController::class, 'delete']);
// Route::post('/memo/update/{id}',[MemoController::class, 'update']);

// Route::get('/me',[MemoController::class, 'welcome'])->name('welcome');
// Route::get('/memo/login',[MemoController::class, 'login']);
// Route::get('/memo/register',[MemoController::class, 'register']);
// Route::get('/memo/logout',[MemoController::class, 'logout']);


Route::get('/test',[TestController::class, 'index']);

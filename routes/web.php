<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\AuthorController;
//use App\Http\Controllers\Web\AuthorController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\ArticlesWebController;
use App\Http\Controllers\Web\BeAuthorRequestsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::middleware('dashboard')->group(function () {
        Route::get('/', function(){return redirect()->route('user.index');});
        Route::resource('/user', UserController::class);
        Route::post('/user/get', [UserController::class, 'getUser'])->name('getusers');
        Route::resource('/author',AuthorController::class);

        Route::resources(['roles' => RoleController::class]);
        Route::resource('/categories', CategoryController::class);
        Route::group(['prefix' => 'requests', 'controller' => BeAuthorRequestsController::class], function(){
            Route::get('/', 'index')->name('requests.index');
            Route::get('/done', 'indexDone')->name('requests.indexDone');
            Route::get('/{id}', 'show')->name('requests.show');
            Route::get('/reject/{id}', 'reject')->name('requests.reject');
            Route::get('/accept/{id}', 'accept')->name('requests.accept');
        });
        Route::resource('articles', ArticlesWebController::class);
    });
});

Route::get('/download/pdf/{idreq}', [BeAuthorRequestsController::class, 'download_pdf'])->name('download.pdf');
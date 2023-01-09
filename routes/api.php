<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\LibProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LinkageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\AcademicBookController;

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

Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group(function () {
    Route::resource('lib-profile', LibProfileController::class);
    Route::resource('book', BookController::class);
    Route::resource('journal', JournalController::class);
    Route::resource('magazine', MagazineController::class);
    Route::resource('service', ServiceController::class);
    Route::post('service-upload', [ServiceController::class, 'serviceUpload']);
    Route::resource('user', UserController::class);
    Route::post('user-account', [UserController::class,'setAccount']);
    Route::get('user-list', [UserController::class,'userList']);
    Route::resource('event', EventController::class);
    Route::post('event-upload', [EventController::class, 'eventUpload']);
    Route::resource('academic', AcademicController::class);
    Route::get('book-list', [BookController::class, 'listBook']);
    Route::resource('academic-book', AcademicBookController::class);
    Route::post('change-password', [AuthController::class,'changePassword']);
    Route::post('update-profile', [AuthController::class,'updateProfile']);
    
    Route::resource('comment', CommentController::class);
    Route::resource('reply', ReplyController::class);
    Route::get('report', [UserController::class,'reportUser']);
    Route::get('num-logs', [UserController::class,'getNumLog']);
    
});
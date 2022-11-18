<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('Admin.Dashboard');
});
Route::name('Admin.')->group(function () {
    Route::get('login',[AuthController::class,'loginView'])->name('Login');
    Route::post('login',[AuthController::class,'store'])->middleware(array_filter([
        config('fortify.limiters.login')?'throttle:'.config('fortify.limiters.login'):null
    ]));
    Route::post('logout',[AuthController::class,'destroy'])->name('Logout');
    Route::middleware(['AdminSection','role:admin'])->group(function () {
        Route::get('dashboard',[HomeController::class,'index'])->name('Dashboard');
        Route::resource('quiz', ExamController::class);
        Route::resource('question', QuestionController::class);
    });
});

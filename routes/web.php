<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ChatLogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RuleController;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('help',[HomeController::class,'help'])->name('help');
Route::get('trtebh',[HomeController::class,'trtebh'])->name('trtebh');
Route::get('requirements',[HomeController::class,'requirements'])->name('requirements');

Route::get('calcGrade', [HomeController::class, 'calcGrade'])->name('calcGrade');
Route::post('calcGrade', [HomeController::class, 'calculateGrade'])->name('calcGrade.calculate');





Route::post('chat',[ChatLogController::class,'store'])->name('chat.ask');
Route::post('appointment/{appointment}',[ChatLogController::class,'bookAppointment'])->name('bookAppointment');


Route::middleware('academic')->group(function (){
    Route::get('academic/appointments',[AppointmentController::class,'index'])->name('academic.appointments');

});


Route::prefix('admin')->group(function (){

    Route::middleware('admin')->group(function (){
        Route::get('/',function (){
            return view('admin.index');
        })->name('admin.index');




        Route::resource('users',\App\Http\Controllers\Admin\UserController::class)->names('admin.users');
        Route::put('/users/{user}/status', [\App\Http\Controllers\Admin\UserController::class, 'updateStatus'])->name('admin.users.updateStatus');

        Route::post('logout', [App\Http\Controllers\Admin\LoginController::class,'logout'])->name('admin.logout');
    });

    Route::get('login', [App\Http\Controllers\Admin\LoginController::class,'showLoginForm'])->name('admin.showLoginForm');
    Route::post('login', [App\Http\Controllers\Admin\LoginController::class,'login'])->name('admin.login');

});


Route::get('test',function(){
   return \App\Models\User::create([
    'name' => 'test',
    'email' => 'test@test.com',
    'password' => bcrypt('12345678'),

   ]);
});


Route::get('/rule/update-embedding/{id}', [RuleController::class, 'updateEmbedding']);

Route::get('/rules/refreshEmbeddings', [RuleController::class, 'refreshEmbeddings']);




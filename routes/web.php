<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\AnswerController;
use App\Http\Controllers\User\QuestionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReproduceController;
use App\Http\Controllers\Admin\Test\AjaxController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ReController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('admin/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user',[UserController::class,'user'])->name('admin.user');
    Route::get('/question',[UserController::class,'question'])->name('admin.question');
    Route::post('/question/delete',[UserController::class,'delete'])->name('admin.delete');
    Route::get('/edit/{id}',[UserController::class,'edit'])->name('admin.edit');
    Route::get('/user/{id}',[UserController::class,'confirm'])->name('admin.confirm');
    Route::post('/user/sort',[UserController::class,'sort'])->name('admin.sort');
    Route::post('/update/{id}',[UserController::class,'questionUpdate'])->name('admin.update');
    Route::get('/import',[UserController::class,'import'])->name('admin.import');
    Route::post('/import/handle',[UserController::class,'csv_handle'])->name('admin.handle');
    Route::get('/setting',[UserController::class,'setting'])->name('admin.setting');
    Route::post('/setting/update',[UserController::class,'year_up'])->name('admin.year_up');
    Route::get('/reproduce',[ReproduceController::class,'index'])->name('admin.reproduce');
    Route::post('/output',[ReproduceController::class,'output'])->name('admin.output');
    Route::post('/copy',[ReproduceController::class,'copy'])->name('admin.copy');
    Route::post('/user_csv',[UserController::class,'user_csv'])->name('user_csv');
});

Route::get('/', function () {
    return view('testForm');
});

Route::get('/api/v_9/user/{id}',[AjaxController::class,'id']);

Route::post('index',[QuestionController::class,'index'])->name('user.index');
Route::get('/user/question',[AnswerController::class,'index'])->name('user.answer');
Route::post('/user/question/deal',[AnswerController::class,'deal'])->name('user.deal');
Route::post('/user/question/back',[AnswerController::class,'back'])->name('user.back');
Route::get('/user/question/grade',[AnswerController::class,'grade'])->name('user.grade');


Route::get('/user/restart/index',[ReController::class,'index'])->name('user.restart.index');
Route::get('/user/restart',[ReController::class,'restart'])->name('user.restart');
Route::get('/user/score',[ReController::class,'score'])->name('user.score');
Route::post('/user/first',[ReController::class,'first'])->name('user.first');
Route::post('/user/restart/deal',[ReController::class,'regrade'])->name('user.regrade');
Route::post('/user/restart/show',[ReController::class,'show'])->name('user.show');
Route::post('/user/reback',[ReController::class,'reback'])->name('user.reback');

Route::get('/tests',function() {
    return view('tests');
});
Route::post('tests/test',[ReproduceController::class,'tests'])->name('tests');


require __DIR__.'/auth.php';

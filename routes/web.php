<?php
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\HomePage\HomePageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\LogoutController;
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
});
Route::prefix('Admin')->group(function () {
    Route::get('Login',[LoginController::class,'index'])->name('admin.login');
    Route::post('Login',[LoginController::class,'store'])->name('login.store');


    Route::middleware(['auth'])->group(function(){
        Route::get('Home',[HomeController::class,'index'])->name('admin.homePage'); 

        Route::get('LogOut',[LogOutController::class,'logout'])->name('admin.logout');

        Route::prefix('Category')->group(function(){
            Route::get('/',[CategoryController::class,'index'])->name('admin.category');
            Route::get('Search',[CategoryController::class,'search'])->name('admin.category.search');
            Route::get('SearchById',[CategoryController::class,'searchById'])->name('admin.category.searchById');
            Route::get('SearchByName',[CategoryController::class,'searchByName'])->name('admin.category.searchByName');
            Route::post('Update',[CategoryController::class,'update'])->name('admin.category.update');
            Route::post('Insert',[CategoryController::class,'insert'])->name('admin.category.insert');
            Route::get('Delete',[CategoryController::class,'delete'])->name('admin.category.delete');
         
        });    

        Route::prefix('Product')->group(function(){
            Route::get("/",[ProductController::class,'index'])->name('admin.product.index');
            Route::get('/GetData',[ProductController::class,'getData'])->name('admin.product.getData');
            Route::post('/Store',[ProductController::class,'store'])->name('admin.product.store');
            Route::post('/StoreDetail',[ProductController::class,'storeDetail'])->name('admin.product.storeDetail');
        });
        
    });

    

});
Route::get('HomePage',[HomePageController::class,'index']);


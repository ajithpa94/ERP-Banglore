<?php

use Illuminate\Support\Facades\Auth;
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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/Addcategory', [App\Http\Controllers\HomeController::class, 'Addcategory'])->name('Addcategory');
Route::post('/addcategoryStore', [App\Http\Controllers\HomeController::class, 'addcategoryStore'])->name('addcategoryStore');
Route::get('/Categorylist', [App\Http\Controllers\HomeController::class, 'Categorylist'])->name('Categorylist');
Route::get('/Categoryedit/{id}', [App\Http\Controllers\HomeController::class,'Categoryedit'])->name('Categoryedit');
Route::post('/Categoryupdate/{id}', [App\Http\Controllers\HomeController::class,'Categoryupdate'])->name('Categoryupdate');
Route::delete('/destroy/{id}', [App\Http\Controllers\HomeController::class, 'destroy'])->name('destroy');
Route::get('/Addproduct', [App\Http\Controllers\HomeController::class, 'Addproduct'])->name('Addproduct');
Route::post('/addproductStore', [App\Http\Controllers\HomeController::class, 'addproductStore'])->name('addproductStore');
Route::get('/Productlist', [App\Http\Controllers\HomeController::class, 'Productlist'])->name('Productlist');
Route::get('/Productedit/{id}', [App\Http\Controllers\HomeController::class,'Productedit'])->name('Productedit');
Route::post('/Productupdate/{id}', [App\Http\Controllers\HomeController::class,'Productupdate'])->name('Productupdate');
Route::delete('/destroys/{id}', [App\Http\Controllers\HomeController::class, 'destroys'])->name('destroys');
Route::get('/addUser', [App\Http\Controllers\HomeController::class, 'addUser'])->name('addUser');
Route::post('/addUserStore', [App\Http\Controllers\HomeController::class, 'addUserStore'])->name('addUserStore');

Route::get('/stocklist', [App\Http\Controllers\HomeController::class,'stocklist'])->name('stocklist');
Route::get('/stockedit/{id}', [App\Http\Controllers\HomeController::class,'stockedit'])->name('stockedit');
Route::post('/stockUpdate/{id}', [App\Http\Controllers\HomeController::class, 'stockUpdate'])->name('stockUpdate');
Route::delete('/destroye/{id}', [App\Http\Controllers\HomeController::class, 'destroye'])->name('destroye');

Route::get('/addPurchase', [App\Http\Controllers\HomeController::class, 'addPurchase'])->name('addPurchase');
Route::post('/addPurchaseStore', [App\Http\Controllers\HomeController::class, 'addPurchaseStore'])->name('addPurchaseStore');
Route::get('/purchaselist', [App\Http\Controllers\HomeController::class,'purchaselist'])->name('purchaselist');
Route::get('/Purchaseedit/{id}', [App\Http\Controllers\HomeController::class,'Purchaseedit'])->name('Purchaseedit');
Route::post('/purchaseUpdate/{id}', [App\Http\Controllers\HomeController::class, 'purchaseUpdate'])->name('purchaseUpdate');
Route::delete('/destro/{id}', [App\Http\Controllers\HomeController::class, 'destro'])->name('destro');


//sale route
Route::get('/addsale', [App\Http\Controllers\HomeController::class, 'addsale'])->name('addsale');
Route::post('/addsaleStore', [App\Http\Controllers\HomeController::class, 'addsaleStore'])->name('addsaleStore');
Route::get('/saleedit/{id}', [App\Http\Controllers\HomeController::class,'saleedit'])->name('saleedit');
Route::post('/saleUpdate/{id}', [App\Http\Controllers\HomeController::class, 'saleUpdate'])->name('saleUpdate');

Route::get('/salelist', [App\Http\Controllers\HomeController::class,'salelist'])->name('salelist');
Route::delete('/saledestroy/{id}', [App\Http\Controllers\HomeController::class, 'saledestroy'])->name('saledestroy');
// saleprodestroy

Route::get('/stock_count/{id}', [App\Http\Controllers\HomeController::class, 'stock_count'])->name('stock_count');
Route::get('/getProducts/{id}', [App\Http\Controllers\HomeController::class, 'getProducts'])->name('getProducts');
Route::get('/getProduct/{id}', [App\Http\Controllers\HomeController::class, 'getProduct'])->name('getProduct');
Route::get('/getItem/{id}', [App\Http\Controllers\HomeController::class, 'getItem'])->name('getItem');
Route::get('/purchasereport', [App\Http\Controllers\HomeController::class,'purchasereport'])->name('purchasereport');
Route::get('/salereport', [App\Http\Controllers\HomeController::class,'salereport'])->name('salereport');
Route::get('/stockreport', [App\Http\Controllers\HomeController::class,'stockreport'])->name('stockreport');

//item add
Route::get('/Additem', [App\Http\Controllers\HomeController::class, 'Additem'])->name('Additem');
Route::post('itemStore', [App\Http\Controllers\HomeController::class, 'itemStore'])->name('itemStore');
Route::get('/Itemlist', [App\Http\Controllers\HomeController::class, 'Itemlist'])->name('Itemlist');
//quantity type
Route::get('/Addquantitytype', [App\Http\Controllers\HomeController::class, 'Addquantitytype'])->name('Addquantitytype');
Route::post('/QuantitytypeStore', [App\Http\Controllers\HomeController::class, 'QuantitytypeStore'])->name('QuantitytypeStore');
Route::get('/Quantitytypelist', [App\Http\Controllers\HomeController::class, 'Quantitytypelist'])->name('Quantitytypelist');

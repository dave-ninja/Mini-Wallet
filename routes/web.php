<?php

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
use App\Product;
use App\Wallet;
Route::get('/', function () {
    return view('welcome');
});
Route::get('locale/{locale}', function($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('web')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/{provider}', 'Auth\LoginController@redirectToProvider');
        Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
    });
    
    Route::resource('wallets', 'WalletController');
    Route::prefix('wallets')->group(function () {
    	Route::post('/{wallet}/update', 'WalletController@update');
    	Route::post('/{wallet}/amount', 'WalletController@amount');
    });
    
    Route::prefix('transfers')->group(function () {
    	Route::get('/', 'TransferController@index');
    	Route::get('/create', 'TransferController@create');
    	Route::post('/', 'TransferController@store');
    	Route::post('/getExistsTypes', 'TransferController@getExistsTypes');
    });
    
    Route::get('/products', function () {
        
        $products = Product::paginate(1);
        $total_sum = Wallet::where('user_id',Auth::user()->id)->sum('amount');
		return view('products.index')->with(compact('products','total_sum'));
    });
    
    Route::prefix('carts')->group(function () {
    	Route::get('/', 'CartController@index');
    	Route::post('/add_to_cart', 'CartController@add_to_cart');
    	Route::post('/', 'CartController@store');
    });
});
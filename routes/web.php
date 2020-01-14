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

use SKAgarwal\GoogleApi\PlacesApi;

// Route::get('/role', function () {
//      $admin=User::find(1);
//      $user=User::find(2);
//      $userRole=Role::find(2);
//      $adminRole=Role::find(1);


$api = 'AIzaSyC0tPLEFW6qNBFB9_7vEAs7IakWblvY020';
Route::get('/google', function () {
    $googlePlaces = new PlacesApi('AIzaSyC0tPLEFW6qNBFB9_7vEAs7IakWblvY020');
//    dd($googlePlaces->placeAutocomplete('cairo'));
    $ns = $googlePlaces->nearbySearch('30.033333, 31.233334',10);
    return $ns;
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', 'PharmacistController@index');
    Route::resource('pharmacists', 'PharmacistController');
    Route::resource('medicines', 'MedicineController');
    Route::resource('stores', 'StoreController');
});


Route::group(['middleware' => ['auth', 'role:pharmacist']], function () {
    Route::get('/', 'OrderController@index');
    Route::post('/orders/save-bill', 'OrderController@saveBill');
    Route::resource('medicines', 'MedicineController');
    Route::resource('orders', 'OrderController');
    Route::resource('stores', 'StoreController');
});

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


/* Public */

Route::permanentRedirect('/', '/accueil');
Route::get('/accueil', 'HomeController@show')->name('home');



/* Only guests (unregistered or not connected)*/

Route::middleware('guest')->group(function () {

 Route::get('/connexion','Auth\LoginController@showLoginForm')->name('login');
 Route::post('/connexion','Auth\LoginController@login')->name('attempt');

 Route::get('/inscription', 'Auth\RegisterController@showRegistrationForm')->name('register');
 Route::post('/inscription', 'Auth\RegisterController@register')->name('createUser');
});



/* Only registered users (basic user or admin) */

Route::middleware('auth')->group(function () {

  // RUD Profile
  Route::get('/utilisateur/{id}/profil', 'UserController@showProfile')->name('profile')->middleware('back');
  Route::put('/utilisateur/{id}/profil', 'UserController@updateProfile')->name('updateProfile');
  Route::delete('/utilisateur/{id}/profil', 'UserController@deleteProfile')->name('deleteProfile');

  // CRD their Cars + Read their Invoices and Repairs
  Route::post('/utilisateur/{id}/vehicules/ajouter', 'CarController@addCar')->name('addCar')->middleware('back');
  Route::get('/utilisateur/{id}/vehicules/{license_plate}', 'CarController@showCar')->name('car')->middleware('back');
  Route::delete('/utilisateur/{id}/vehicules/{license_plate}', 'CarController@deleteCar')->name('deleteCar');

  // Logout
  Route::post('/utilisateur/{id}/deconnexion','Auth\LoginController@logout')->name('logout');
});



/* Only basic users */

Route::middleware('client')->group(function () {

  // Contact Garage
  Route::get('/utilisateur/{id}/contacterGarage', 'UserRequestController@showRequestForm')->name('request')->middleware('back');
  Route::post('/utilisateur/{id}/contacterGarage', 'UserRequestController@sendRequest')->name('sendRequest')->middleware('back');
});



/* Only admin */

Route::middleware('admin')->group(function () {

  // Selling his cars
  Route::put('/utilisateur/{id}/vehicules/{license_plate}/enVente', 'CarController@updateCarForSale')->name('forSale')->middleware('back');
  Route::put('/utilisateur/{id}/vehicules/{license_plate}/vendre', 'CarController@updateSoldCar')->name('soldCar');

  // See client's request
  Route::get('/demandesClients', 'UserRequestController@showAllRequests')->name('allRequests');

  // CRD Invoices
  Route::post('/vehicules/{license_plate}/factures/ajouter', 'InvoiceController@createInvoice')->name('createInvoice');
  Route::delete('/vehicules/{license_plate}/factures/{idInvoice}', 'InvoiceController@deleteInvoice')->name('deleteInvoice');

  // CRUD Repairs
  Route::get('/reparations', 'RepairController@showAllRepairs')->name('allRepairs');
  Route::post('/reparation/ajouter', 'RepairController@createRepair')->name('createRepair');
  Route::put('/reparation/{idrepair}', 'RepairController@updateRepair')->name('updateRepair');
  Route::delete('/reparation/{idrepair}', 'RepairController@deleteRepair')->name('deleteRepair');

  // Search any car
  Route::get('/vehicules/recherche/{license_plate}', 'CarController@search')->name('search');
  Route::get('/vehicules/{license_plate}', 'CarController@showCar')->name('adminCar')->middleware('back');
});



// If the route doesn't exist
Route::fallback('HomeController@notFound');

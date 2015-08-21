<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('/', 'WelcomeController@index');
Route::get('adminPanel', 'AdminController@index');
Route::get('home', 'HomeController@index');
Route::get('compressor', 'CompressorController@index');
Route::get('load', 'CompressorController@load');
Route::get('loadThisOne/{id}', 'CompressorController@loadThisOne');
Route::get('dwpdf', 'HomeController@dwpdf');

Route::resource ('usermanagement', 'UsermanageController');

Route::post('mainPanelFormSubmitted', 'CompressorController@mainPanelFormSubmitted');
Route::post('inputFormSubmitted', 'CompressorController@inputFormSubmitted');
Route::post('elevationChanged', 'CompressorController@elevationChanged');
Route::post('gasInletTemperatureChanged', 'CompressorController@gasInletTemperatureChanged');
Route::post('gasInletPressureChanged', 'CompressorController@gasInletPressureChanged');
Route::post('gasDischargePressureChanged', 'CompressorController@gasDischargePressureChanged');
Route::post('flowrateChanged', 'CompressorController@flowrateChanged');
Route::post('coolantTemperatureChanged', 'CompressorController@coolantTemperatureChanged');
Route::post('saveSizing', 'CompressorController@saveSizing');
Route::post('updateSizing', 'CompressorController@updateSizing');

/*Route::resource('compressor', 'CompressorController');*/

/*Route::post('test', function(){
    // Handle the user registration
    $postedbyme = Request::input();
    foreach($postedbyme as $key => $value)
    	echo $key .' = '. $value. '<br>';
});
*/
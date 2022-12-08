<?php

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
	$vcode = rand(100000,999999);
	if(session()->has('vcode')){

	}else {
		session(['vcode'=>$vcode]);
	}
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

//section
Route::get('/Section', 'App\Http\Controllers\SectionController@index')->name('section');
Route::post('/Add/Section', 'App\Http\Controllers\SectionController@store')->name('addsection');

Route::post('/Edit/Section', 'App\Http\Controllers\SectionController@edit')->name('editsection');

Route::get('/Delete/Section','App\Http\Controllers\SectionController@destroy')->name('deletesection');

//users

Route::get('/Users', 'App\Http\Controllers\UserController@index')->name('users');
Route::post('/Add/Users', 'App\Http\Controllers\UserController@store')->name('addusers');

Route::post('/Edit/User', 'App\Http\Controllers\UserController@edit')->name('edituser');


Route::get('/Delete/User','App\Http\Controllers\UserController@destroy')->name('deleteuser');






//batch
Route::get('/Batch', 'App\Http\Controllers\BatchController@index')->name('batch');

Route::post('/Add/Batch', 'App\Http\Controllers\BatchController@store')->name('addbatch');

Route::post('/Edit/Batch', 'App\Http\Controllers\BatchController@edit')->name('editbatch');

Route::get('/Delete/Batch','App\Http\Controllers\BatchController@destroy')->name('deletebatch');


//Instructor

Route::get('/Instructors', 'App\Http\Controllers\Instructor@index')->name('instructor');

Route::post('/Add/Instructors', 'App\Http\Controllers\Instructor@store')->name('addusers');

Route::post('/Edit/Instructors', 'App\Http\Controllers\Instructor@edit')->name('editinstructor');


Route::get('/Delete/Instructors','App\Http\Controllers\Instructor@destroy')->name('deleteinstructor');

//Book

Route::get('/Books', 'App\Http\Controllers\Book@index')->name('books');

Route::get('Add/Student/Books', 'App\Http\Controllers\Book@StoreStudent')->name('addStudent');

Route::post('Submit/Student/Books', 'App\Http\Controllers\Book@store')->name('submitstudent');

Route::get('fetchallstudent','App\Http\Controllers\Book@fetchstudent')->name('fetchstudent');

Route::get('deleteStudent','App\Http\Controllers\Book@deletestudent')->name('deletestudent');

Route::post('Update/Student','App\Http\Controllers\Book@updatestudent')->name('updatestudent');

//Client
Route::get('Clients','App\Http\Controllers\Client@index')->name('client');


/* Intructor Request */
Route::get('Students','App\Http\Controllers\AllInstructorController@students')->name('students');


/* Clients Request */
Route::get('MyBook','App\Http\Controllers\AllClientsController@yearbook')->name('yearbook');




/* Prints */
Route::get('Print','App\Http\Controllers\YearbookprintController@store')->name('printyearbook');
Route::get('getchance','App\Http\Controllers\YearbookprintController@index')->name('getDownloadChance');




Route::get('verifynow','App\Http\Controllers\MailController@verify')->name('verifynow');
Route::post('checkverify','App\Http\Controllers\MailController@checkverify')->name('checkverify');




Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);



	
//['as' => 'page.section', 'uses' => 'App\Http\Controllers\SectionController@index']
});





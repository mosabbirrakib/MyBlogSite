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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {


	Route::get('/home', 'HomeController@index');


	Route::resource('users','UserController');


	Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['permission:role-list|role-create|role-edit|role-delete']]);
	Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);

 
	Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['permission:role-create']]);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['permission:role-delete']]);


	Route::get('postCRUD2',['as'=>'postCRUD2.index','uses'=>'PostCRUD2Controller@index','middleware' => ['permission:post-list|post-create|post-edit|post-delete']]);
	Route::get('postCRUD2/create',['as'=>'postCRUD2.create','uses'=>'PostCRUD2Controller@create','middleware' => ['permission:post-create']]);
	Route::post('postCRUD2/create',['as'=>'postCRUD2.store','uses'=>'PostCRUD2Controller@store','middleware' => ['permission:post-create']]);
	Route::get('postCRUD2/{id}',['as'=>'postCRUD2.show','uses'=>'postCRUD2Controller@show']);
	Route::get('postCRUD2/view/{id}',['as'=>'postCRUD2.view','uses'=>'PostCRUD2Controller@view']);
	Route::get('postCRUD2/{id}/edit',['as'=>'postCRUD2.edit','uses'=>'PostCRUD2Controller@edit','middleware' => ['permission:post-edit']]);
	Route::patch('postCRUD2/{id}',['as'=>'postCRUD2.update','uses'=>'PostCRUD2Controller@update','middleware' => ['permission:post-edit']]);
	Route::delete('postCRUD2/{id}',['as'=>'postCRUD2.destroy','uses'=>'PostCRUD2Controller@destroy','middleware' => ['permission:post-delete']]);
});

Route::get('/category', 'CategoryController@category');
Route::get('/categories/create', 'CategoryController@create');
Route::post('/categories/store', 'CategoryController@store')->name('category.store');
Route::get('/categories/edit/{id}', 'CategoryController@edit')->name('category.edit');
Route::post('/categories/update/{id}', 'CategoryController@update')->name('category.update');
Route::get('/categories/show/{id}', 'CategoryController@show')->name('category.show');
Route::post('/categories/delete/{id}', 'CategoryController@destroy')->name('category.delete');
Route::get('/profile', 'ProfileController@profile');
Route::post('/profile/store', 'ProfileController@store')->name('profile.store');
Route::get('category/{id}', 'PostCRUD2Controller@category');
Route::get('like/{id}', 'PostCRUD2Controller@like');
Route::get('dislike/{id}', 'PostCRUD2Controller@dislike');
Route::post('comment/{id}', 'PostCRUD2Controller@comment')->name('comment');
Route::post('/search', 'PostCRUD2Controller@search');

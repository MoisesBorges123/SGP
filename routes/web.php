<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::get('/dashboard/certidao-batismo/{filter}','Painel\Certidoes\CertidaoBatismoController@filter')->name('certidao-batismo.filter');
Route::resource('/certidao-batismo','Painel\Certidoes\CertidaoBatismoController');
Route::resource('/notificacao-certidao-batismo','Painel\Certidoes\NotificacaoCertidaoBatismoController');
Route::resource('/finalidades-certidao','Painel\Certidoes\FinalidadesCertController');
Route::get('/certidao/{certidao}/{id}/{finalidade?}/{obs?}','Painel\Certidoes\ActionsCertidao@emitir')->name('certidao.emitir');


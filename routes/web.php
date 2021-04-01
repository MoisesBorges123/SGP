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

Route::get('/home', 'Painel\DashboardController@index')->name('home');
//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

//Route::get('/sacramentos','Painel\SacramentosController@index')->name('sacramentos.index');

//Rotas para crição e emissão de registros de batismo
Route::get('/dashboard/certidao-batismo/{filter}','Painel\Certidoes\CertidaoBatismoController@filter')->name('certidao-batismo.filter');
Route::resource('/certidao-batismo','Painel\Certidoes\CertidaoBatismoController');
Route::resource('/notificacao-certidao-batismo','Painel\Certidoes\NotificacaoCertidaoBatismoController');
Route::resource('/finalidades-certidao','Painel\Certidoes\FinalidadesCertController');
Route::get('/certidao/{certidao}/{id}/{finalidade?}/{obs?}','Painel\Certidoes\ActionsCertidao@emitir')->name('certidao.emitir');

//Rotas para digitalizar e registrar livros de sacramentos
Route::resource('/paginas','Painel\Livros\PaginasController');
Route::resource('/upload-livros','Painel\Livros\FotosController');
//Route::get('/paginas/list/{livro?}','Painel\Livros\PaginasController@list')->name('paginas.list');
Route::resource('/livros','Painel\Livros\LivrosController');

//Rotas para crição e emissão de registros de crisma
Route::resource('/certidao-crisma','Painel\Certidoes\CertidaoCrismaController');
Route::get('/certidao-crisma/export/{id}','Painel\Certidoes\ActionsCertidao@emitirCertCrisma')->name('certidao-crisma.export');
//Rotas para crição e emissão de registros de casamento
Route::resource('/certidao-casamento','Painel\Certidoes\CertidaoCasamentoController');
Route::get('/certidao-casamento/export/{id}','Painel\Certidoes\ActionsCertidao@emitirCertCasamento')->name('certidao-casamento.export');

//Rotas Inteçoes
Route::get('/intentions/print','Painel\Celebracoes\IntencaoController@printer')->name('intentions.print');
Route::resource('/intentions','Painel\Celebracoes\IntencaoController');

//Rotas Agenda de Missas
Route::resource('/schedule-celebrations','Painel\Celebracoes\ScheduleCelebrationController');
Route::resource('/notice-intentions','Painel\Celebracoes\AvisosIntencoesController');

//Rotas Dizimistas
Route::resource('/tithe/tither','Painel\Tithe\Tither\TitherController');
Route::match(array('GET', 'POST'),'/tithe/devolution/save/{dizmista?}','Painel\Tithe\Devolution\TitherDevolutionsController@save')->name('devolution.save');
Route::resource('/tithe/devolution','Painel\Tithe\Devolution\TitherDevolutionsController');

//Rotas Endereço
Route::post('/address/seach/cep','Painel\Endereco\LogradouroController@search_cep')->name('search_cep');

//Rotas Contagem
Route::resource('/contagem','Painel\Contagem\ContagemController');

//Rotas Estacionamento
Route::post('/parking/report/daily-cashier','Painel\Estacionamento\Analyse\ReportController@reportDaily')->name('report.reportDaily');
Route::post('/table-price/fetch','Painel\Estacionamento\TablePrice\TablePriceController@fetch')->name('table-price.fetch');
Route::post('parking/out','Painel\Estacionamento\Fluxo\Out_ParkingController@store')->name('parking-out.store');
Route::get('/parking/out/{id?}','Painel\Estacionamento\Fluxo\Out_ParkingController@show')->name('parking-out.show');
Route::get('/parking/fech/header','Painel\Estacionamento\Fluxo\ParkingController@fetchHeader')->name('parking.fetch.header');
Route::post('/time-parking','Painel\Estacionamento\Time\TimeParkingController@update')->name('time.update');
Route::post('/parking/delete','Painel\Estacionamento\Fluxo\ParkingController@delete')->name('parking.delete');
Route::resource('/parking','Painel\Estacionamento\Fluxo\ParkingController');
Route::resource('/monthly','Painel\Estacionamento\Monthly\MonthlyController');
Route::get('/monthly-pay/printer','Painel\Estacionamento\Monthly\MonthlyPaysController@print')->name('monthly-pay.print');
Route::resource('/monthly-pay','Painel\Estacionamento\Monthly\MonthlyPaysController');
Route::resource('/table-price','Painel\Estacionamento\TablePrice\TablePriceController');

//Rotas System
Route::get('/homens-trabalhando','Painel\System\SystemController@mensWorking')->name('system.mensWorking');

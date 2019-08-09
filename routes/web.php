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
 
// Login
Route::get('/', function () {
    return view('/auth/login');
});

// Auth - Controller Autenticacao
Auth::routes();

// HomeController - Dashboard - Painel Inicial
Route::get('home', 'HomeController@index')->name('home');

// Área de erros
Route::get('erro', 'ErroController@index')->name('erro');

// ContatoController
Route::resource('contato', 'ContatoController');
Route::post('contato/enviar', 'ContatoController@enviar');

// RoleController - Regras - Papeis
Route::resource('roles', 'RoleController');
Route::post('roles/busca', 'RoleController@busca');
Route::get('role/{id}/permissions', 'RoleController@permissions');
Route::post('role/permissionUpdate', 'RoleController@permissionUpdate');
Route::post('role/permissionDestroy', 'RoleController@permissionDestroy');

// PermissionController - Permissoes
Route::resource('permissions', 'PermissionController');
Route::post('permissions/busca', 'PermissionController@busca');
Route::get('permission/{id}/roles', 'PermissionController@roles');

Route::get('permission/createAuto', 'PermissionController@createAuto');
Route::post('permission/storeAuto', 'PermissionController@storeAuto');

// UserController - Permissoes
Route::resource('/users', 'UserController');
Route::post('users/busca', 'UserController@busca');
Route::post('users/updateActive', 'UserController@updateActive');
Route::get('user/{id}/roles', 'UserController@roles');
//Route::get('user/{id}/userroles', 'UserController@createUserRole');
Route::post('user/roleUpdate', 'UserController@roleUpdate');
Route::post('user/roleDestroy', 'UserController@roleDestroy');
//Setor User
Route::get('user/{id}/setors', 'UserController@setors');
Route::post('user/setorUpdate', 'UserController@setorUpdate');
Route::post('user/setorDestroy', 'UserController@setorDestroy');

//TEST
//Route::get('user/roleUpdateTest', 'UserController@roleUpdateTest');

Route::post('equipamentos/busca', 'EquipamentoController@busca');
Route::get('equipamentos/dashboard', 'EquipamentoController@dashboard');
Route::get('equipamentos/dashboard/{id}', 'EquipamentoController@dashboardSistema');
Route::get('equipamentos/status/{id}/{status}/{sistema}', 'EquipamentoController@status');
Route::resource('equipamentos', 'EquipamentoController');


// TicketController
Route::resource('tickets', 'TicketController');
Route::post('tickets/busca', 'TicketController@busca');
Route::get('tickets/{id}/acao', 'TicketController@acao');
Route::post('tickets/storeAcao', 'TicketController@storeAcao');
Route::get('tickets/{id}/encerrar', 'TicketController@encerrar');
Route::post('tickets/storeEncerrar', 'TicketController@storeEncerrar');
Route::get('tickets/{status}/status', 'TicketController@status');
//Route::get('tickets/{id}/reabrir', 'TicketController@reabrir');
//Route::post('tickets/storeReabrir', 'TicketController@storeReabrir');

//Setor Ticket
Route::get('tickets/{id}/setors', 'TicketController@setors');
Route::post('tickets/setorUpdate', 'TicketController@setorUpdate');
Route::post('tickets/setorDestroy', 'TicketController@setorDestroy');

//Route::get('tickets/{id}/setorEditCabecalho', 'TicketController@setorEditCabecalho');
//Route::post('tickets/setorUpdateCabecalho', 'TicketController@setorUpdateCabecalho');

Route::resource('setors', 'SetorController');
Route::post('setors/busca', 'SetorController@busca');
Route::get('setors/{id}/editCabecalho', 'SetorController@editCabecalho');

Route::post('setors/updateCabecalho', 'SetorController@updateCabecalho');

Route::get('setors/{id}/chefe', 'SetorController@chefe');
Route::post('setors/chefeUpdate', 'SetorController@chefeUpdate');
Route::post('setors/chefeDestroy', 'SetorController@chefeDestroy');


// ClientController
Route::get('clients/perfil', 'ClientController@perfil');
// Imagem Perfil
Route::get('clients/imagem', 'ClientController@imagem');
Route::post('clients/imagemUpdate', 'ClientController@imagemUpdate');

// ClientController
Route::resource('clients', 'ClientController');
Route::post('clients/busca', 'ClientController@busca');
Route::get('clients/{id}/encerrar', 'ClientController@encerrar');
Route::post('clients/storeAcao', 'ClientController@storeAcao');
Route::post('clients/storeEncerrar', 'ClientController@storeEncerrar');
Route::get('clients/{status}/status', 'ClientController@status');
Route::get('clients/{id}/acao', 'ClientController@acao');



// TecnicoController
//Route::resource('tecnicos/', 'TecnicoController');
Route::get('tecnicos/{setor}/{id}/edit', 'TecnicoController@edit');
Route::get('tecnicos/{setor}/{id}/show', 'TecnicoController@show');
Route::get('tecnicos/{setor}/{id}/acao', 'TecnicoController@acao');
Route::post('tecnicos/{setor}/{id}/update', 'TecnicoController@update');

//Route::get('tecnicos/update/', 'TecnicoController@update');

Route::post('tecnicos/{setor}/busca', 'TecnicoController@busca');
Route::post('tecnicos/{setor}/superBusca', 'TecnicoController@superBusca');
Route::get('tecnicos/{setor}/buscaData', 'TecnicoController@buscaData');
Route::get('tecnicos/{setor}/tickets/{equipamento_id}/{status}/equipamento', 'TecnicoController@buscaStatusIdEquipamento');
Route::get('tecnicos/{setor}/tickets/{status}/status', 'TecnicoController@status');
Route::get('tecnicos/{setor}/tickets', 'TecnicoController@index');
Route::post('tecnicos/storeAcao', 'TecnicoController@storeAcao');
Route::get('tecnicos/{setor}/{id}/encerrar', 'TecnicoController@encerrar');
Route::post('tecnicos/storeEncerrar', 'TecnicoController@storeEncerrar');
Route::get('tecnicos/{setor}/{id}/reabrir', 'TecnicoController@reabrir');
Route::post('tecnicos/storeReabrir', 'TecnicoController@storeReabrir');

//Setor Tecnico
Route::get('tecnicos/{setor}/{id}/setors', 'TecnicoController@setors');
Route::post('tecnicos/setorUpdate', 'TecnicoController@setorUpdate');
Route::post('tecnicos/setorDestroy', 'TecnicoController@setorDestroy');
Route::get('tecnicos/{setor}/dashboard', 'TecnicoController@dashboard');
Route::get('tecnicos/{setor}/alocar', 'TecnicoController@alocar');
Route::get('tecnicos/{setor}/{id}/alocarSetors', 'TecnicoController@alocarSetors');
Route::post('tecnicos/alocarSetorUpdate', 'TecnicoController@alocarSetorUpdate');

Route::get('tecnicos/{setor}/chefe', 'TecnicoController@chefe');

Route::get('tecnicos/{setor}/users', 'TecnicoController@users');
Route::post('tecnicos/userUpdate', 'TecnicoController@userUpdate');
Route::post('tecnicos/userDestroy', 'TecnicoController@userDestroy');

//LIVROS Técnicos 

Route::get('livros/{setor}/', 'LivroController@index');
Route::post('livros/{setor}/busca', 'LivroController@busca');
Route::get('livros/{setor}/{id}/show', 'LivroController@show');
Route::get('livros/{setor}/create', 'LivroController@create');
Route::post('livros/preview', 'LivroController@store');
Route::get('livros/{setor}/{id}/excluir', 'LivroController@destroy');
Route::get('livros/{setor}/{id}/aprovar', 'LivroController@aprovar');

//LOGS
//Route::resource('logs', 'LogController');
Route::get('logs/acesso', 'LogController@acesso');
Route::get('logs/', 'LogController@index');
Route::get('logs/{id}', 'LogController@show');
Route::post('logs/busca', 'LogController@busca');


//Tutoriais
Route::get('tutorials/{setor}/', 'TutorialController@index');
Route::post('tutorials/{setor}/busca', 'TutorialController@busca');

Route::get('tutorials/{setor}/create', 'TutorialController@create');
Route::post('tutorials/{setor}/store', 'TutorialController@store');
Route::get('tutorials/{setor}/busca', 'TutorialController@busca');
Route::get('tutorials/{setor}/{id}/show', 'TutorialController@show');
Route::get('tutorials/{setor}/{id}/edit', 'TutorialController@edit');
Route::post('tutorials/{setor}/{id}/update', 'TutorialController@update');
Route::get('tutorials/{setor}/{id}/excluir', 'TutorialController@destroy');
Route::get('tutorials/{setor}/{id}/setors', 'TutorialController@setors');
Route::post('tutorials/setorUpdate', 'TutorialController@setorUpdate');
Route::post('tutorials/setorDestroy', 'TutorialController@setorDestroy');


// UploadController
Route::resource('uploads', 'UploadController');
Route::post('uploads/destroy/{id}', 'UploadController@destroy');
Route::get('uploads/{id}/create/{area}', 'UploadController@create');
//Visualizar arquivos com segurança
Route::get('/storage/{fileName}', 'UploadController@fileStorageServe')
->where(['fileName' => '.*'])->name('storage.gallery.file');


// AutomacaoController
Route::get('automacao/comando/{comando}', 'AutomacaoController@comando');
Route::resource('automacao', 'AutomacaoController');

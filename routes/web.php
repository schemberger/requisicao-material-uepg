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

/*
 * Rotas padrões do pacote SGIAuthorizer para login e exibição dos usuários logados.
 */


Route::get(config('sgiauthorizer.app.loginRoute'), ['as' => 'login', 'uses' => '\Uepg\SGIAuthorizer\Auth\Controllers\LoginController@getLogin']);
Route::post(config('sgiauthorizer.app.loginRoute'), '\Uepg\SGIAuthorizer\Auth\Controllers\LoginController@login');
Route::get('/logout', ['as' => 'logout', 'uses' => '\Uepg\SGIAuthorizer\Auth\Controllers\LoginController@logout']);

Route::group(['middleware' => 'sgiauth'], function() {
    Route::any(config('sgiauthorizer.app.userInfoRoute'), ['uses' => '\Uepg\SGIAuthorizer\Auth\Controllers\DisplayUserInfoController@userInfo']);

    Route::get('/', function () {
        return view('layouts.body');
    });

    // Rotas para Requisicao de material

    Route::get('req_material/{id}/{data}/{cd_centro}/edit', 'ReqMaterialController@edit');
    Route::get('req_material/{id}/{data}/{cd_centro}/duplicar', 'ReqMaterialController@duplicar');
    Route::get('req_material/showTable/{ano}/{cd}', 'ReqMaterialController@showTable');
    Route::get('req_material/create/{id}', 'ReqMaterialController@create');
    Route::get('req_material/show/{id}/{data}/{cd_centro}', 'ReqMaterialController@show');

    Route::resource('req_material', 'ReqMaterialController');

    //Rotas para Itens da requisicao de material

    Route::get('item_req_material/{nr_rm}/{ano_rm}/{cd_centro}/createMaterial', 'ItemReqMaterialController@createMaterial');
    Route::get('item_req_material/{nr_rm}/{ano_rm}/{cd_centro}/createServico', 'ItemReqMaterialController@createServico');
    Route::get('item_req_material/{nr_rm}/{ano_rm}/{cd_centro}/{nr_item}/editMaterial', 'ItemReqMaterialController@editMaterial');
    Route::get('item_req_material/{nr_rm}/{ano_rm}/{cd_centro}/{nr_item}/editServico', 'ItemReqMaterialController@editServico');
    Route::get('item_req_material/{nr_rm}/{ano_rm}/{cd_centro}/{nr_item}/destroyMaterial', 'ItemReqMaterialController@destroyMaterial');
    Route::get('item_req_material/{nr_rm}/{ano_rm}/{cd_centro}/{nr_item}/destroyServico', 'ItemReqMaterialController@destroyServico');
    Route::get('item_req_material/{id}/{data}/{cd_centro}/showItens', 'ItemReqMaterialController@showItens');
    Route::put('item_req_material/updateMaterial/{id}', 'ItemReqMaterialController@updateMaterial');
    Route::put('item_req_material/updateServico/{id}', 'ItemReqMaterialController@updateServico');
    Route::post('item_req_material/material', 'ItemReqMaterialController@storeMaterial');
    Route::post('item_req_material/servico', 'ItemReqMaterialController@storeServico');

    Route::get('item_req_material/searchItem', 'ItemReqMaterialController@searchItem');

    Route::resource('item_req_material', 'ItemReqMaterialController');

    // Rotas para impressao de relatorios

    Route::get('relatorio/material/{id}/{data}/{cd_centro}', 'ImprimirRmController@material');
    Route::get('relatorio/servico/{id}/{data}/{cd_centro}', 'ImprimirRmController@servico');

    // Rotas para destino de itens

    Route::get('destino/{id}/{data}/{cd_centro}/{nr_item}', 'DestinoController@index');
    Route::get('destino/{id}/{data}/{cd_centro}/{nr_item}/create', 'DestinoController@create');
    Route::get('destino/{id}/{data}/{cd_centro}/{nr_item}/{nr_item_destino}/edit', 'DestinoController@edit');
    Route::put('destino/update/{id}', 'DestinoController@update');

    Route::resource('destino', 'DestinoController');

//    Requisicao ajax

    Route::get('req_material/{id}/{data}/{cd_centro}/delete', 'ReqMaterialController@destroy');

    Route::get('req_material/create/{id}/receptores', 'ReqMaterialController@receptores');

    Route::get('item_req_material/getUnidade/{codigo}', 'ItemReqMaterialController@getUnidade');

    Route::get('req_material/{id}/{data}/{cd_centro}/edit/validationEdit', 'ReqMaterialController@validationEdit');

    Route::get('destino/{id}/{data}/{cd_centro}/{nr_item}/create/validationNovo', 'DestinoController@validationNovo');

    Route::get('destino/{id}/{data}/{cd_centro}/{nr_item}/{nr_item_destino}/destroy', 'DestinoController@destroy');

});
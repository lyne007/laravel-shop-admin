<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/users', 'UsersController@index')->name('home');

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('categories', CategoryController::class);
    $router->resource('attribute-keys', AttributeKeyController::class);
    $router->resource('attribute-values', AttributeValueController::class);
    $router->resource('goods', GoodsController::class);


    $router->get('/test', 'CategoryController@test')->name('test');
    $router->get('/goods', 'GoodsController@index')->name('goods.index');

    // 公用到api
    $router->get('/api/cate/{f?}','ApiController@cate')->name('api.cate');
    $router->get('/api/attr','ApiController@attr')->name('api.attr');
});

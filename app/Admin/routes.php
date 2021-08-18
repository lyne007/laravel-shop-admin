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
    $router->resource('banners', BannersController::class);
    $router->resource('merchants', MerchantsController::class);
    $router->resource('vendors', VendorsController::class);

    $router->post('/goods/upload-sku','GoodsController@uploadSku')->name('goods.upload-sku');
    $router->post('/goods/upload-details','GoodsController@uploadDetails')->name('goods.upload-details');

    // 公用到api
    $router->get('/api/cate/{f?}','ApiController@cate')->name('api.cate');
    $router->get('/api/attr','ApiController@attr')->name('api.attr');
});

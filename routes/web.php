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
$prefixAdmin = config('zvn.url.prefix_admin');
$prefixNews = config('zvn.url.prefix_news');

Route::group(['prefix' => $prefixAdmin, 'namespace' => 'Admin', 'middleware' => 'permission.admin'], function () {

    /*============================= Dashboard =============================*/
    $prefix         = 'dashboard';
    $controllerName = 'dashboard';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('', ['as' => $controllerName, 'uses' => $controller . 'index']);
    });

    /*============================= Slider =============================*/
    $prefix         = 'slider';
    $controllerName = 'slider';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('', ['as' => $controllerName, 'uses' => $controller . 'index']);
        Route::get('form/{id?}', ['as' => $controllerName . '/form', 'uses' => $controller . 'form'])->where('id', '[0-9]+');
        Route::post('save', ['as' => $controllerName . '/save', 'uses' => $controller . 'save']);
        Route::get('delete/{id}', ['as' => $controllerName . '/delete', 'uses' => $controller . 'delete'])->where('id', '[0-9]+');
        Route::get('change-status-{status}/{id}', ['as' => $controllerName . '/status', 'uses' => $controller . 'status']);
    });

    /*============================= Category =============================*/
    $prefix         = 'category';
    $controllerName = 'category';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('', ['as' => $controllerName, 'uses' => $controller . 'index']);
        Route::get('form/{id?}', ['as' => $controllerName . '/form', 'uses' => $controller . 'form'])->where('id', '[0-9]+');
        Route::post('save', ['as' => $controllerName . '/save', 'uses' => $controller . 'save']);
        Route::get('delete/{id}', ['as' => $controllerName . '/delete', 'uses' => $controller . 'delete'])->where('id', '[0-9]+');
        Route::get('change-status-{status}/{id}', ['as' => $controllerName . '/status', 'uses' => $controller . 'status']);
        Route::get('change-isHome-{isHome}/{id}', ['as' => $controllerName . '/is_home', 'uses' => $controller . 'isHome']);
        Route::get('change-display-{display}/{id}', ['as' => $controllerName . '/display', 'uses' => $controller . 'display']);
    });

    /*============================= Article =============================*/
    $prefix         = 'article';
    $controllerName = 'article';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('', ['as' => $controllerName, 'uses' => $controller . 'index']);
        Route::get('form/{id?}', ['as' => $controllerName . '/form', 'uses' => $controller . 'form'])->where('id', '[0-9]+');
        Route::post('save', ['as' => $controllerName . '/save', 'uses' => $controller . 'save']);
        Route::get('delete/{id}', ['as' => $controllerName . '/delete', 'uses' => $controller . 'delete'])->where('id', '[0-9]+');
        Route::get('change-status-{status}/{id}', ['as' => $controllerName . '/status', 'uses' => $controller . 'status']);
        Route::get('change-type-{type}/{id}', ['as' => $controllerName . '/type', 'uses' => $controller . 'type']);
    });

    /*============================= User =============================*/
    $prefix         = 'user';
    $controllerName = 'user';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('', ['as' => $controllerName, 'uses' => $controller . 'index']);
        Route::get('form/{id?}', ['as' => $controllerName . '/form', 'uses' => $controller . 'form'])->where('id', '[0-9]+');
        Route::post('save', ['as' => $controllerName . '/save', 'uses' => $controller . 'save']);
        Route::get('delete/{id}', ['as' => $controllerName . '/delete', 'uses' => $controller . 'delete'])->where('id', '[0-9]+');
        Route::get('change-status-{status}/{id}', ['as' => $controllerName . '/status', 'uses' => $controller . 'status']);
        Route::get('change-level-{level}/{id}', ['as' => $controllerName . '/level', 'uses' => $controller . 'level']);
        Route::post('change-password', ['as' => $controllerName . '/change-password', 'uses' => $controller . 'changePassword']);
        Route::post('change-level', ['as' => $controllerName . '/change-level', 'uses' => $controller . 'changeLevel']);
    });

    /*============================= RSS =============================*/
    $prefix         = 'rss';
    $controllerName = 'rss';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('', ['as' => $controllerName, 'uses' => $controller . 'index']);
        Route::get('form/{id?}', ['as' => $controllerName . '/form', 'uses' => $controller . 'form'])->where('id', '[0-9]+');
        Route::post('save', ['as' => $controllerName . '/save', 'uses' => $controller . 'save']);
        Route::get('delete/{id}', ['as' => $controllerName . '/delete', 'uses' => $controller . 'delete'])->where('id', '[0-9]+');
        Route::get('change-status-{status}/{id}', ['as' => $controllerName . '/status', 'uses' => $controller . 'status']);
    });
});

Route::group(['prefix' => $prefixNews, 'namespace' => 'News'], function () {

    /*============================= HomePage =============================*/
    $prefix         = '';
    $controllerName = 'home';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('', ['as' => $controllerName, 'uses' => $controller . 'index']);
    });

    /*============================= Category =============================*/
    $prefix         = 'chuyen-muc';
    $controllerName = 'category';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/{category_name}-{category_id}.php', ['as' => $controllerName . '/index', 'uses' => $controller . 'index'])
            ->where('category_name', '[0-9a-zA-Z_-]+')
            ->where('category_id', '[0-9]+');
    });

    /*============================= Article =============================*/
    $prefix         = 'bai-viet';
    $controllerName = 'article';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/{article_name}-{article_id}.php', ['as' => $controllerName . '/index', 'uses' => $controller . 'index'])
            ->where('article_name', '[0-9a-zA-Z_-]+')
            ->where('article_id', '[0-9]+');
    });

    /*============================= Notify =============================*/
    $prefix         = '';
    $controllerName = 'notify';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/no-permission', ['as' => $controllerName . '/noPermission', 'uses' => $controller . 'noPermission']);
    });

    /*============================= Login =============================*/
    $prefix         = '';
    $controllerName = 'auth';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/login', ['as' => $controllerName . '/login', 'uses' => $controller . 'login'])->middleware('check.login');
        Route::post('/postLogin', ['as' => $controllerName . '/postLogin', 'uses' => $controller . 'postLogin']);
        /*============================= Logout =============================*/
        Route::get('/logout', ['as' => $controllerName . '/logout', 'uses' => $controller . 'logout']);
    });

    /*============================= Rss =============================*/
    $prefix         = '';
    $controllerName = 'rss';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/tin-tuc-tong-hop', ['as' => $controllerName . '/news', 'uses' => $controller . 'index']);
        Route::get('/get-gold', ['as' => $controllerName . '/get-gold', 'uses' => $controller . 'getGold']);
        Route::get('/get-coin', ['as' => $controllerName . '/get-coin', 'uses' => $controller . 'getCoin']);
    });
});

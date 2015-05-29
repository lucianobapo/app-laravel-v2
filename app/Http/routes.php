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

// Testes
//after filter
//Route::filter('log', function($route,$request,$response){
//    //var_dump($route);
//    //var_dump($request);
//    //var_dump($response);
//});

//Route::get('foo', 'FooController@foo');
//Route:get('foo', 'FooController@foo')->after('log');

Route::get('twitter/{query}', function($query) {
    $tweets = Twitter::search($query);
    dd($tweets);
//    return Twitter::search($query);

});

Route::get('social', function() {
    if (Auth::guest()) return 'Hi guest. <br>'.
        link_to('socialLogin/google', 'Login With Google!').'<br>'.
        link_to('socialLogin/github', 'Login With Github!');
    else return 'Welcome back, '.Auth::user()->name.' - '.link_to('auth/logout', 'Logout');
});

Route::get('github/{username}', function($username) {
    $client = new \Guzzle\Http\Client('https://api.github.com');
    $response = $client->get("users/$username")->send();
    dd($response->json());
});

// Delivery
//get('socialLogin/{provider}', ['as'=>'social.login', 'uses'=>'SocialAuthController@login']);
get('images/{file}', ['as'=>'images', 'uses'=>'ImageController@show']);

Route::group([
    'domain' => '{host}.'.config('app.domain'),
//    'prefix' => 'delivery',
    'where' => ['host' => 'laravel'],
], function(){
    get('/', ['as'=>'delivery.index', 'uses'=>'DeliveryController@index']);
    post('/addCart', ['as'=>'delivery.addCart', 'uses'=>'DeliveryController@addCart']);
    get('/emptyCart', ['as'=>'delivery.emptyCart', 'uses'=>'DeliveryController@emptyCart']);
    get('/pedido', ['as'=>'delivery.pedido', 'uses'=>'DeliveryController@pedido']);
    post('/addOrder', ['as'=>'delivery.addOrder', 'uses'=>'DeliveryController@addOrder']);
});

// ERP
//Route::get('ordens', ['as'=>'ordens.index', 'uses'=>'OrdensController@index']);
Route::resource('orders','OrdersController', [
    'names' => [
        'index'=>'orders.index',
        'show'=>'orders.show',
        'create'=>'orders.create',
        'store'=>'orders.store',
        'edit'=>'orders.edit',
        'update'=>'orders.update',
    ],
    'only'=>[
        'index',
        'show',
        'create',
        'store',
        'edit',
        'update',
    ],
]);

// Temporário
Route::get('relatorios', ['as'=>'relatorios.index', 'uses'=>'RelatoriosController@index']);

// Application core
Route::get('/', ['as'=>'index', 'uses'=>'WelcomeController@index']);

Route::get('home', ['as'=>'home.index', 'uses'=>'HomeController@index']);

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('contact', ['as'=>'contact', 'uses'=>'PagesController@contact']);

Route::get('about', ['as'=>'about', 'uses'=>'PagesController@about']);

//Route::get('articles', 'ArticlesController@index');
//Route::get('articles/create', 'ArticlesController@create');
//Route::get('articles/{id}', 'ArticlesController@show');
//Route::post('articles', 'ArticlesController@store');
//Route::get('articles/{id}/edit', 'ArticlesController@edit');

Route::resource('articles','ArticlesController', [
    'names' => [
        'index'=>'articles.index',
        'show'=>'articles.show',
        'create'=>'articles.create',
        'store'=>'articles.store',
        'edit'=>'articles.edit',
        'update'=>'articles.update',
    ],
    'only'=>[
        'index',
        'show',
        'create',
        'store',
        'edit',
        'update',
    ],
]);

Route::get('tags/{tags}', ['as'=>'tags.show', 'uses'=>'TagsController@show']);

Route::resource('sharedCurrencies','SharedCurrenciesController', [
    'names' => [
        'index'=>'sharedCurrencies.index',
        'show'=>'sharedCurrencies.show',
//        'create'=>'articles.create',
//        'store'=>'articles.store',
//        'edit'=>'articles.edit',
//        'update'=>'articles.update',
    ],
    'only'=>[
        'index',
        'show',
//        'create',
//        'store',
//        'edit',
//        'update',
    ],
]);
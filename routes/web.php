<?php

use App\Http\Controllers\Back\ShopController;
use App\Http\Controllers\HomeController;
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

Route::get('/', 'HomeController@index')->name('home');
Route::name('home.category')->get('/categorie/{category}', 'HomeController@category');

Route::get('page/{page:slug}', 'HomeController@page')->name('page');

Route::post('deconnexion', 'Auth\LoginController@logout')->name('logout');
Route::middleware('guest')->group(function () {
    Route::prefix('connexion')->group(function () {
        Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('/', 'Auth\LoginController@login');
    });
    Route::prefix('inscription')->group(function () {
        Route::get('/', 'Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('/', 'Auth\RegisterController@register');
    });
});
Route::prefix('passe')->group(function () {
    Route::get('renouvellement', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('renouvellement/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('renouvellement', 'Auth\ResetPasswordController@reset')->name('password.update');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::name('produits.show')->get('produits/{product}', 'ProductController');

Route::resource('panier', 'CartController')->only(['index', 'store', 'update', 'destroy']);

// Utilisateur authentifié
Route::middleware('auth')->group(function () {
    // Gestion du compte
    Route::prefix('compte')->group(function () {
        Route::name('account')->get('/', 'AccountController');
        Route::name('identite.edit')->get('identite', 'IdentiteController@edit');
        Route::name('identite.update')->put('identite', 'IdentiteController@update');
        Route::name('identite.rgpd')->get('rgpd', 'IdentiteController@rgpd');
        Route::name('identite.pdf')->get('rgpd/pdf', 'IdentiteController@pdf');
        Route::resource('adresses', 'AddressController')->except('show');
        Route::resource('commandes', 'OrdersController')->only(['index', 'show'])->parameters(['commandes' => 'order']);
        Route::name('invoice')->get('commandes/{order}/invoice', 'InvoiceController');
    });
    // Commandes
    Route::prefix('commandes')->group(function () {
        Route::name('commandes.details')->post('details', 'DetailsController');
        Route::name('commandes.confirmation')->get('confirmation/{order}', 'OrdersController@confirmation');
        Route::resource('/', 'OrderController')->names([
            'create' => 'commandes.create',
            'store' => 'commandes.store',
        ])->only(['create', 'store']);
        Route::name('commandes.payment')->post('paiement/{order}', 'PaymentController');
    });

    // **************** Test Paypal ***************************
    Route::get('commandes/confirm-paypal-ok/{order?}', [
        'name' => 'PayPal Express Checkout',
        'as' => 'order.paypal',
        'uses' => 'Back\PayPalController@form',
    ]);
    
    Route::post('/checkout/payment/{order}/paypal', [
        'name' => 'PayPal Express Checkout',
        'as' => 'checkout.payment.paypal',
        'uses' => 'Back\PayPalController@checkout',
    ]);
    
    Route::get('commandes/confirm-paypal-ok/{order}', [
        'name' => 'PayPal Express Checkout',
        'as' => 'paypal.checkout.completed',
        'uses' => 'Back\PayPalController@completed',
    ]);
    
    Route::name('paiement-ok.paypal')->get('commandes/confirm-paypal-ok/{order}/paypal', 'Back\PaypalController@completed');
    Route::name('paiement-cancel.paypal')->get('commandes/cancel-paypal/{order}/paypal', 'Back\PaypalController@cancelled');
    
    Route::get('/paypal/checkout/{order}/cancelled', [
        'name' => 'PayPal Express Checkout',
        'as' => 'paypal.checkout.cancelled',
        'uses' => 'Back\PayPalController@cancelled',
    ]);
 });

// Administration
Route::prefix('admin')->middleware('admin')->namespace('Back')->group(function () {
    Route::name('admin')->get('/', 'AdminController@index');
    Route::name('read')->put('read/{type}', 'AdminController@read');
    Route::name('statistics')->get('statistiques/{year}', 'StatisticsController');

    Route::name('viewusers')->get('new/users', 'AdminController@viewusers');
    Route::name('vieworders')->get('new/orders', 'AdminController@vieworders');
    // Route::name('new')->get('new/{type}', 'AdminController@view');
    // Route::name('newusers')->get('new/{type}', 'AdminController@view');
    Route::name('shop.edit')->get('boutique', 'ShopController@edit');
    Route::name('shop.update')->put('boutique', 'ShopController@update');
    Route::resource('pays', 'CountryController')->except('show')->parameters([
        'pays' => 'pays'
    ]);
    Route::name('pays.destroy.alert')->get('pays/{pays}', 'CountryController@alert');
    Route::name('plages.edit')->get('plages/modification', 'RangeController@edit');
    Route::name('plages.update')->put('plages', 'RangeController@update');
    Route::name('colissimos.edit')->get('colissimos/modification', 'ColissimoController@edit');
    Route::name('colissimos.update')->put('colissimos', 'ColissimoController@update');
    Route::resource('etats', 'StateController')->except('show');
    Route::name('etats.destroy.alert')->get('etats/{etat}', 'StateController@alert');
    Route::resource('pages', 'PageController')->except('show');
    Route::name('pages.destroy.alert')->get('pages/{page}', 'PageController@alert');
    Route::resource('categories', 'CategoryController')->except('show');
    Route::name('categories.destroy.alert')->get('categories/{category}', 'CategoryController@alert');
    Route::resource('produits', 'ProductController')->except('show');
    Route::name('produits.destroy.alert')->get('produits/{produit}', 'ProductController@alert');

    Route::resource('clients', 'UserController')->names([
        'index' => 'clients.index',
        'show' => 'clients.show',
    ])->only(['index', 'show']);

    Route::resource('adresses', 'AddressController')->names([
        'index' => 'back.adresses.index',
        'show' => 'back.adresses.show',
    ])->only(['index', 'show']);

    Route::resource('commandes', 'OrderController')->names([
        'index' => 'orders.index',
        'show' => 'orders.show',
        'update' => 'orders.update',
    ])->only(['index', 'show', 'update']);

    Route::name('orders.invoice')->post('commandes/invoice/{commande}', 'OrderController@invoice');
    Route::name('orders.updateNumber')->put('commandes/updateNumber/{commande}', 'OrderController@updateNumber');
    Route::name('maintenance.edit')->get('maintenance/modification', 'MaintenanceController@edit');
    Route::name('maintenance.update')->put('maintenance', 'MaintenanceController@update');
    Route::name('cache.update')->put('cache', 'MaintenanceController@cache');
});

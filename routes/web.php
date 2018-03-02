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

Route::get('/', 'PagesController@index');
Route::get('pretraga', 'PagesController@search');
Route::post('subscribe', 'PagesController@subscribe');

Route::get('logovanje', 'PagesController@login');
Route::get('registracija', 'PagesController@register');

Route::get('profil', 'CustomersController@profile');

Route::get('lista-zelja', 'PagesController@wishList');
Route::get('kosarica', 'PagesController@cart');
Route::post('register', 'PagesController@registerUpdate')->name('user-register');

Route::post('add-to-wishlist/{id}', 'PagesController@addToWishList');
Route::post('remove-from-wishlist/{id}', 'PagesController@removeFromWishList');

Route::post('add-to-cart/{id}', 'PagesController@addToCart');
Route::post('add-to-cart-from-wishlist/{id}', 'PagesController@addToCartFromWishList');
Route::post('remove-from-cart/{id}', 'PagesController@removeFromCart');

Route::get('eleganza', 'PagesController@eleganza');
Route::get('eleganza/shop', 'PagesController@eleganzaShop');
Route::get('eleganza/blog', 'PagesController@eleganzaBlog');
Route::get('eleganza/wish', 'PagesController@eleganzaWish');
Route::get('eleganza/cart', 'PagesController@eleganzaCart');
Route::get('eleganza/login', 'PagesController@eleganzaLogin');
Route::get('eleganza/product', 'PagesController@eleganzaProduct');
Route::get('eleganza/registration', 'PagesController@eleganzaRegistration');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('admin/pages/more', 'PagesController@more');
Route::get('atribut/{slug}/{id}', 'PagesController@attribute');
Route::get('tagovi/{slug}/{id}', 'PagesController@tags');

Route::post('products/remove-from-cart/{id}', 'PagesController@removeProductFromCart');
Route::post('listakupovine', 'PagesController@listakupovine');
Route::post('info/kontakt-form', 'PagesController@kontakt_form');
Route::get('info/servis', 'PagesController@servis');
Route::get('info/zahvalnica', 'PagesController@hvala');
Route::get('info/mapa', 'PagesController@mapa');
Route::get('info/o-nama', 'PagesController@about');
Route::get('info/prodajna-mjesta', 'PagesController@prodajna_mesta');
Route::get('info/kontakt', 'PagesController@kontakt');
Route::get('korpa', 'PagesController@korpa');
Route::post('kupovina', 'PagesController@kupovina');

Route::get('proba', 'PagesController@proba');

Route::get('shop/{slug1}/{slug2}/{slug3}/{slug4}/{slug5}/{slug6}', 'PagesController@shopCategory6');
Route::get('shop/{slug1}/{slug2}/{slug3}/{slug4}/{slug5}', 'PagesController@shopCategory5');
Route::get('shop/{slug1}/{slug2}/{slug3}/{slug4}', 'PagesController@shopCategory4');
Route::get('shop/{slug1}/{slug2}/{slug3}', 'PagesController@shopCategory3');
Route::get('shop/{slug1}/{slug2}', 'PagesController@shopCategory2');
Route::get('shop/{slug}', 'PagesController@shopCategory');

Route::get('{slug1}/{slug2}/{slug3}/{id}', 'PagesController@post2');
Route::get('{slug1}/{slug2}/{id}', 'PagesController@post');
Route::get('{slug1}/{slug2}', 'PagesController@category2');
Route::get('{slug}', 'PagesController@category');

//Auth::routes();
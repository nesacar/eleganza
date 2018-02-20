<?php

Route::post('admin/statistics/searchNewsletter', 'StatisticsController@searchNewsletter');
Route::post('admin/statistics/searchSubscribers', 'StatisticsController@searchSubscribers');
Route::get('admin/statistics/{id}/yearNewsletter', 'StatisticsController@yearNewsletter');
Route::get('admin/statistics/{id}/lastYearNewsletter', 'StatisticsController@lastYearNewsletter');
Route::get('admin/statistics/{id}/monthNewsletter', 'StatisticsController@monthNewsletter');
Route::get('admin/statistics/{id}/lastMonthNewsletter', 'StatisticsController@lastMonthNewsletter');
Route::get('admin/statistics/{id}/dayNewsletter', 'StatisticsController@dayNewsletter');
Route::get('admin/statistics/{id}/lastDayNewsletter', 'StatisticsController@lastDayNewsletter');

Route::get('admin/newsletters/removepost', 'NewslettersController@removePost');
Route::post('admin/newsletters/prepare', 'NewslettersController@prepareUpdate');
Route::get('admin/newsletters/append', 'NewslettersController@append');
Route::get('admin/newsletters/posts/{newsletter}/{post}', 'NewslettersController@post');
Route::get('admin/newsletters/products/{newsletter}/{product}', 'NewslettersController@product');
Route::resource('admin/newsletters', 'NewslettersController');
Route::get('admin/newsletters/{verification}/logout', 'NewslettersController@logout');
Route::get('admin/newsletters/{id}/delete', 'NewslettersController@delete');
Route::get('admin/newsletters/{id}/send', 'NewslettersController@send');
Route::get('admin/newsletters/{id}/preview', 'NewslettersController@preview');

Route::resource('admin/subscribers', 'SubscribersController');
Route::get('admin/subscribers/{id}/delete', 'SubscribersController@delete');
Route::post('admin/subscribers/search', 'SubscribersController@search');
Route::post('admin/subscribers/subscribe', 'SubscribersController@subscribe');
Route::get('admin/subscribers/publish/{id}', 'SubscribersController@publish');

Route::resource('admin/banners', 'BannersController');
Route::get('admin/banners/{id}/delete', 'BannersController@delete');
Route::post('admin/banners/{id}/{locale}/deleteimg', 'BannersController@deleteimg');
Route::get('admin/banners/publish/{id}', 'BannersController@publish');
Route::post('admin/banners/{id}/updateLang', 'BannersController@updateLang');
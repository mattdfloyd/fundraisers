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

Route::redirect('/', '/fundraisers');

Route::resource('fundraisers', 'FundraiserController')->only(['index', 'create', 'store', 'show']);
Route::post('fundraisers/{fundraiser}/reviews', 'FundraiserReviewsController@store')->name('fundraisers.reviews.store');

<?php

use Illuminate\Support\Facades\Route;

Route::post('signin', '\Autum\SAML\Http\Controllers\Auth\SamlController@signin')->name('signin');
Route::get('login', '\Autum\SAML\Http\Controllers\Auth\SamlController@login')->name('login');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
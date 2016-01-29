<?php

$loginRoute = Config::get('laravel-saml::saml.routes.login', 'login');
$logoutRoute = Config::get('laravel-saml::saml.routes.logout', 'logout');

Route::get($loginRoute, 'SamlController@login');
Route::get($logoutRoute, 'SamlController@logout');

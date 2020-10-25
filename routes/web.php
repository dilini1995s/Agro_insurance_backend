<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('/login', 'LoginController@login');
$router->post('/register', 'FarmerController@register');
$router->post('/finn', 'CheckController@fin');
$router->post('/premium/{id}', 'PolicyfarmerController@addpremium');
$router->post('/policy', 'LandController@add');
$router->get('/land/{nic}',['uses' =>  'LandController@getland']);
$router->get('/user', [ 'uses' => 'FarmerController@get_user']);
$router->get('/company', [ 'uses' => 'CompanyController@showcompanies']);
$router->get('/detail/{va}', [ 'uses' => 'PolicyController@showPolicy']);
$router->get('/de/{va1}/{va2}', [ 'uses' => 'PolicyfarmerController@showfarmersPolicy']);
$router->get('/risk1/{va1}/{va2}', [ 'uses' => 'PolicyRiskCropController@showfarmersPolicyrisks1']);
$router->get('/risk2/{va1}/{va2}', [ 'uses' => 'PolicyRiskCropController@showfarmersPolicySanasa']);
$router->get('/crop/{va1}/{va2}', [ 'uses' => 'PolicyRiskCropController@showcrops']);
$router->get('/wrisk/{va1}/{va2}', [ 'uses' => 'PolicyRiskCropController@showwithoutrisk']);
$router->get('/us', [ 'uses' => 'CompanyController@get_us']);
$router->get('/risktypes/{company}', [ 'uses' => 'PolicyRiskCropController@showrisks']);
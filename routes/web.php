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
$router->post('/update/{nic}', 'FarmerController@updateFarmer');
$router->post('/finn', 'CheckController@fin');
$router->post('/premium/{id}', 'PolicyfarmerController@addpremium');
$router->post('/policy/{id}', 'LandController@add');
$router->post('/agentverify/{id}', 'AgentController@agentverification');
$router->get('/land/{nic}',['uses' =>  'LandController@getland']);
$router->get('/agentId/{District}/{Gramasewa}/{com}',['uses' =>  'AgentController@getAgentId']);
$router->get('/user', [ 'uses' => 'FarmerController@get_user']);
$router->get('/company', [ 'uses' => 'CompanyController@showcompanies']);
$router->get('/getclients/{companyId}', [ 'uses' => 'CompanyController@getfamers']);
$router->post('/updateamount/{policyid}', 'CompanyController@updateAmount');
$router->post('/companypolicyverification/{policyid}', 'CompanyController@companypolicyverification');
$router->post('/updaterating/{nic}', 'CompanyController@updateRating');
$router->post('/updatepolicycrops/{policyid}', 'PolicyCropController@updatecropsdetail');
//$router->get('/updatepolicycrops/{policyid}', ['uses'=>'PolicyCropController@updatecropsdetail']);
$router->get('/onefarmer/{nic}', [ 'uses' => 'CompanyController@getselectedfarmerPolicy']);
$router->get('/farmerspolicy/{nic}', [ 'uses' => 'CompanyController@getselectedfarmerdetails']);
$router->get('/activepolicy/{nic}/{com}', [ 'uses' => 'CompanyController@showactivePolicy']);
$router->get('/getcompanypolicies/{companyid}', [ 'uses' => 'CompanyController@getselectedCompanyPolicy']);
$router->get('/getrequestpolicy/{companyid}', [ 'uses' => 'CompanyController@showRequestPolicies']);
$router->get('/getcropsdetail/{policyid}', [ 'uses' => 'CompanyController@showCropdetails']);
$router->get('/detail/{va}', [ 'uses' => 'PolicyController@showPolicy']);
$router->get('/allpolicy/{nic}', [ 'uses' => 'PolicyfarmerController@showAllPolicy']);
$router->get('/de/{va1}/{va2}', [ 'uses' => 'PolicyfarmerController@showfarmersPolicy']);
$router->get('/getactivePremium/{nic}/{companyid}', [ 'uses' => 'PolicyfarmerController@showActivepremium']);
$router->get('/getpolicy/{id}', [ 'uses' => 'PolicyfarmerController@showPolicy']);
$router->get('/risk1/{va1}/{va2}', [ 'uses' => 'PolicyRiskCropController@showfarmersPolicyrisks1']);
$router->get('/risk2/{va1}/{va2}', [ 'uses' => 'PolicyRiskCropController@showfarmersPolicySanasa']);
$router->get('/crop/{va1}/{va2}', [ 'uses' => 'PolicyRiskCropController@showcrops']);
$router->get('/wrisk/{va1}/{va2}', [ 'uses' => 'PolicyRiskCropController@showwithoutrisk']);
$router->get('/us', [ 'uses' => 'CompanyController@get_us']);
$router->get('/risktypes/{company}', [ 'uses' => 'PolicyRiskCropController@showrisks']);

$router->get('/agent/{com}', [ 'uses' => 'AgentController@showRequestPolicies']);
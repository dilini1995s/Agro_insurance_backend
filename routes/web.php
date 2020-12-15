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
//login for farmer
$router->post('/login', 'LoginController@login');
//login for officer
$router->post('/officerlogin', 'LoginController@officerlogin');
//farmer register
$router->post('/register', 'FarmerController@register');
//update farmer details
$router->put('/update/{nic}', 'FarmerController@updateFarmer');


$router->post('/premium/{id}', 'PolicyfarmerController@addpremium');

//submit policy form include the adding land
$router->post('/policy/{id}', 'LandController@add');
//agent verification
$router->post('/agentverify/{id}', 'AgentController@agentverification');
//get land details according to NIC
$router->get('/land/{nic}',['uses' =>  'LandController@getland']);
//show land acording to google map api
$router->get('/landlocation/{land}', [ 'uses' => 'LandController@showlandlocation']);

$router->get('/agentId/{District}/{Gramasewa}/{com}',['uses' =>  'AgentController@getAgentId']);
$router->get('/user', [ 'uses' => 'FarmerController@get_user']);

$router->get('/company', [ 'uses' => 'CompanyController@showcompanies']);
$router->get('/getclients/{companyId}', [ 'uses' => 'CompanyController@getfamers']);
$router->put('/updateamount/{policyid}', 'CompanyController@updateAmount');
$router->post('/companypolicyverification/{policyid}', 'CompanyController@companypolicyverification');
$router->put('/updaterating/{nic}', 'CompanyController@updateRating');
$router->put('/updatepolicycrops/{policyid}', 'PolicyCropController@updatecropsdetail');
//$router->get('/updatepolicycrops/{policyid}', ['uses'=>'PolicyCropController@updatecropsdetail']);
$router->get('/onefarmer/{nic}', [ 'uses' => 'CompanyController@getselectedfarmerPolicy']);
$router->get('/farmerspolicy/{nic}', [ 'uses' => 'CompanyController@getselectedfarmerdetails']);
$router->get('/activepolicy/{nic}/{com}', [ 'uses' => 'CompanyController@showactivePolicy']);
$router->get('/getcompanypolicies/{companyid}', [ 'uses' => 'CompanyController@getselectedCompanyPolicy']);
$router->get('/getrequestpolicy/{companyid}', [ 'uses' => 'CompanyController@showRequestPolicies']);
$router->get('/getcropsdetail/{policyid}', [ 'uses' => 'CompanyController@showCropdetails']);
$router->post('/addnewpolicytype', 'CompanyController@addnewpolicy');
$router->delete('/deletepolicy/{insurance_id}', 'CompanyController@deletepolicy');

$router->post('/addnewpolicytypedetails', 'PolicyCropController@addnewpolicydetails');
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
$router->get('/policyapplyhistory/{id}/{company_id}', [ 'uses' => 'AgentController@showhistory']);
//showhistory($id,$company_id)


$router->post('/farmerissues', 'CompanyfarmerController@postfarmersIssues');
$router->post('/companyreply', 'CompanyfarmerController@postcompanyReply');
$router->get('/getrequestissues/{nic}/{company_id}', [ 'uses' => 'CompanyfarmerController@showrequestIssues']);
$router->get('/getallrequestissues/{company_id}', [ 'uses' => 'CompanyfarmerController@showrallrequestIssues']);
$router->get('/getclaimAAIB/{companyid}', [ 'uses' => 'CompanyController@showRequestClaimAAIB']);
$router->get('/getclaimSANASA/{companyid}', [ 'uses' => 'CompanyController@showRequestClaimSanasa']);
$router->get('/getactivePolicydetails/{company_id}', [ 'uses' => 'CompanyController@showActivePolicyforCompany']);
$router->post('/companyclaimverification/{claim_id}', 'CompanyController@companyclaimverification');

$router->get('/agent/{id}/{com}', [ 'uses' => 'AgentController@showRequestPolicies']);
$router->get('/applyAll/{id}/{company_id}', [ 'uses' => 'AgentController@showApplyAll']);
$router->get('/activeAll/{id}/{company_id}', [ 'uses' => 'AgentController@showActivePolicy']);

$router->get('/organizationId/{District}/{Gramasewa}', [ 'uses' => 'OrganizationController@getOrganizationId']);
$router->post('/orgverify/{id}', 'OrganizationController@orgverification');

$router->post('/claim', 'ClaimController@postclaim');
$router->get('/claimdetail/{nic}/{company_id}', [ 'uses' => 'ClaimController@showfarmerClaim']);
$router->get('/claimOrg/{org_id}', [ 'uses' => 'ClaimController@getclaimsforOrg']);
$router->get('/allclaimsforOrg/{org_id}', [ 'uses' => 'ClaimController@getAllclaimsforOrg']);//get all requests(submit for aaib)
$router->get('/allActiveclaimsforOrg/{org_id}', [ 'uses' => 'ClaimController@getActiveclaimsforOrg']);//get active claim details(aaib)
$router->get('/allActiveclaimsforCompany/{company_id}', [ 'uses' => 'ClaimController@getAllclaimsforCompany']);//get active claim details(aaib)

$router->get('/getclaim/{id}', [ 'uses' => 'ClaimController@getclaimdetail']);
$router->get('/getclaimforafarmer/{nic}', [ 'uses' => 'ClaimController@getclaimdetailForafarmer']);//when given nic can getclaim details 
$router->get('/getclaimforcompany/{nic}/{company}', [ 'uses' => 'ClaimController@getclaimCompany']);

$router->get('/getclaimhistory/{org_id}', [ 'uses' => 'ClaimController@gethistoryforOrg']);//organization verification true or false
$router->get('/getlandforclaim/{id}/{policy_num}', [ 'uses' => 'ClaimController@getland']);

<?php

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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function (){

    Route::group(['prefix' => 'roles'], function (){
        Route::get('/listAll','RoleController@listAll')
            ->name('roles.listAll');
        Route::get('/parameters/{id}','RoleController@listRoleParameters')
            ->name('roles.listRoleParameters');
        Route::get('/parameters-search/{id}','RoleController@filterParameters')
            ->name('roles.filterParameters');
        Route::post('/activate-parameter','RoleController@updateParameter')
            ->name('roles.updateParameter');
        Route::get('/admin/{id}','RoleController@admin')
            ->name('roles.admin');
        Route::get('/edit/{id}','RoleController@edit')
            ->name('roles.edit');
        Route::get('/search','RoleController@filter')
            ->name('roles.search');
        Route::get('/help','RoleController@help')
            ->name('roles.help');
        Route::get('/create','RoleController@create')
            ->name('roles.create');
        Route::post('/store','RoleController@store')
            ->name('roles.store');
        Route::get('/edit/{id}','RoleController@edit')
            ->name('roles.edit');
        Route::put('/update/{user}','RoleController@update')
            ->name('roles.update');
        Route::put('/help','RoleController@help')
            ->name('roles.help');

    });
    Route::group(['prefix' => 'users'], function (){
        Route::get('/listAll','UserController@listAll')
            ->name('users.listAll');
        Route::get('/admin/{id}','UserController@admin')
            ->name('users.admin');
        Route::get('/parameters/{id}','UserController@listUserParameters')
            ->name('users.listUserParameters');
        Route::get('/parameters-search/{id}','UserController@filterParameters')
            ->name('users.filterParameters');
        Route::post('/activate-parameter','UserController@updateParameter')
            ->name('users.updateParameter');
        Route::get('/edit/{id}','UserController@edit')
            ->name('users.edit');
        Route::get('/search','UserController@filter')
            ->name('users.search');
        Route::get('/help','UserController@help')
            ->name('users.help');
        Route::get('/create','UserController@create')
            ->name('users.create');
        Route::post('/store','UserController@store')
            ->name('users.store');
        Route::get('/edit/{id}','UserController@edit')
            ->name('users.edit');
        Route::put('/update/{user}','UserController@update')
            ->name('users.update');
        Route::put('/help','UserController@help')
            ->name('users.help');

    });
    Route::group(['prefix' => 'opportunities'], function (){
        Route::get('/dashboard/{userDashboard?}','OpportunityController@dashboard')
            ->name('opportunities.dashboard');
        Route::get('/listAll','OpportunityController@listAll')
            ->name('opportunities.listAll');
        Route::get('/searchList','OpportunityController@filterList')
            ->name('opportunities.searchList');
        Route::get('/listCompany/{company}','OpportunityController@listCompany')
            ->name('opportunities.listCompany');
        Route::get('/listStageAjax','OpportunityController@listStageAjax')
            ->name('opportunities.listStageAjax');
        Route::get('/getStageTotalAjax','OpportunityController@getStageTotalAjax')
            ->name('opportunities.getStageTotalAjax');
        Route::get('/updateOpportunityAjax','OpportunityController@updateOpportunityAjax')
            ->name('opportunities.updateOpportunityAjax');
        Route::get('/viewOpportunity/{id}','OpportunityController@viewOpportunity')
            ->name('opportunities.viewOpportunity');
        Route::post('/store','OpportunityController@store')
            ->name('opportunities.store');
        Route::put('/update/{opportunity}','OpportunityController@update')
            ->name('opportunities.update');
        Route::get('/search/{userDashboard?}','OpportunityController@filter')
            ->name('opportunities.search');
    });
    Route::group(['prefix' => 'activities'], function (){
        Route::post('/store','ActivityController@store')
            ->name('activities.store');
    });
    Route::group(['prefix' => 'companies'], function (){
        Route::get('/search','CompanyController@filter')
            ->name('companies.search');
        Route::get('/listAll','CompanyController@listAll')
            ->name('companies.listAll');
        Route::get('/admin/{id}','CompanyController@admin')
            ->name('companies.admin');
        Route::get('/user/{id}','CompanyController@user')
            ->name('companies.user');
        Route::get('/create','CompanyController@create')
            ->name('companies.create');
        Route::post('/store','CompanyController@store')
            ->name('companies.store');
        Route::get('/edit/{id}','CompanyController@edit')
            ->name('companies.edit');
        Route::put('/update/{company}','CompanyController@update')
            ->name('companies.update');
    });
    Route::group(['prefix' => 'sampling-points'], function (){
        Route::get('/search','SamplingPointController@filter')
            ->name('samplingPoints.search');
        Route::get('/listAll','SamplingPointController@listAll')
            ->name('samplingPoints.listAll');
        Route::get('/admin/{id}','SamplingPointController@admin')
            ->name('samplingPoints.admin');
        Route::get('/getInfoAsJson','SamplingPointController@getInfoAsJson')
            ->name('samplingPoints.getInfoAsJson');
        Route::get('/user/{id}','SamplingPointController@user')
            ->name('samplingPoints.user');
        Route::get('/create','SamplingPointController@create')
            ->name('samplingPoints.create');
        Route::post('/store','SamplingPointController@store')
            ->name('samplingPoints.store');
        Route::get('/edit/{id}','SamplingPointController@edit')
            ->name('samplingPoints.edit');
        Route::put('/update/{samplingPoint}','SamplingPointController@update')
            ->name('samplingPoints.update');
        Route::get('/delete/{samplingPoint}','SamplingPointController@delete')
            ->name('samplingPoints.delete');
    });
    Route::group(['prefix' => 'parameters'], function (){
        Route::get('/search','ParameterController@filter')
            ->name('parameters.search');
        Route::get('/listAll','ParameterController@listAll')
            ->name('parameters.listAll');
        Route::get('/admin/{id}','ParameterController@admin')
            ->name('parameters.admin');
        Route::get('/create','ParameterController@create')
            ->name('parameters.create');
        Route::post('/store','ParameterController@store')
            ->name('parameters.store');
        Route::get('/edit/{id}','ParameterController@edit')
            ->name('parameters.edit');
        Route::put('/update/{parameter}','ParameterController@update')
            ->name('parameters.update');
        Route::delete('/delete','ParameterController@delete')
            ->name('ParameterController.delete');
    });
    Route::group(['prefix' => 'units'], function (){
        Route::get('/search','UnitController@filter')
            ->name('units.search');
        Route::get('/listAll','UnitController@listAll')
            ->name('units.listAll');
        Route::get('/admin/{id}','UnitController@admin')
            ->name('units.admin');
        Route::get('/create','UnitController@create')
            ->name('units.create');
        Route::post('/store','UnitController@store')
            ->name('units.store');
        Route::get('/edit/{id}','UnitController@edit')
            ->name('units.edit');
        Route::put('/update/{unit}','UnitController@update')
            ->name('units.update');
    });
    Route::group(['prefix' => 'ecas'], function (){
        Route::get('/search','EcaController@filter')
            ->name('ecas.search');
        Route::get('/listAll','EcaController@listAll')
            ->name('ecas.listAll');
        Route::get('/listParameters/{id}','EcaController@listParameters')
            ->name('ecas.listParameters');
        Route::get('/admin/{id}','EcaController@admin')
            ->name('ecas.admin');
        Route::get('/create','EcaController@create')
            ->name('ecas.create');
        Route::post('/store','EcaController@store')
            ->name('ecas.store');
        Route::get('/edit/{id}','EcaController@edit')
            ->name('ecas.edit');
        Route::put('/update/{eca}','EcaController@update')
            ->name('ecas.update');
        Route::get('/createParameter/{id}','EcaController@createParameter')
            ->name('ecas.createParameter');
        Route::post('/storeParameter','EcaController@storeParameter')
            ->name('ecas.storeParameter');
        Route::get('/editParameter/{id}','EcaController@editParameter')
            ->name('ecas.editParameter');
        Route::put('/updateParameter/{ecaParameter}','EcaController@updateParameter')
            ->name('ecas.updateParameter');
        Route::delete('/delete','EcaController@delete')
            ->name('ecas.delete');
        Route::post('/copy/{eca}','EcaController@copy')
            ->name('ecas.copy');
    });
    Route::group(['prefix' => 'samplings'], function (){
        Route::get('/search','SamplingController@filter')
            ->name('samplings.search');
        Route::get('/listAll','SamplingController@listAll')
            ->name('samplings.listAll');
        Route::get('/listPoint/{samplingPoint}','SamplingController@listPoint')
            ->name('samplings.listPoint');
        Route::get('/listSampling/{sampling}','SamplingController@listSampling')
            ->name('samplings.listSampling');
        Route::put('/updateSampling/{sampling}','SamplingController@updateSampling')
            ->name('samplings.updateSampling');
        Route::put('/deleteSampling/{sampling}','SamplingController@deleteSampling')
            ->name('samplings.deleteSampling');
        Route::post('/addSampling/{sampling}','SamplingController@addSampling')
            ->name('samplings.addSampling');
        Route::get('/admin/{id}','SamplingController@admin')
            ->name('samplings.admin');
        Route::get('/user/{id}','SamplingController@user')
            ->name('samplings.user');
        Route::get('/create/{id}','SamplingController@create')
            ->name('samplings.create');
        Route::post('/store','SamplingController@store')
            ->name('samplings.store');
        Route::get('/createParameters/{id}','SamplingController@createParameters')
            ->name('samplings.createParameters');
        Route::post('/storeParameters/{sampling_id}','SamplingController@storeParameters')
            ->name('samplings.storeParameters');
        Route::get('/edit/{id}','SamplingController@edit')
            ->name('samplings.edit');
        Route::put('/update/{company}','SamplingController@update')
            ->name('samplings.update');
        Route::put('/approve/{id}','SamplingController@approve')
            ->name('samplings.approve');
        Route::post('/alertNotification/{sampling}','SamplingController@alertNotification')
            ->name('samplings.alertNotification');
        Route::get('/delete/{sampling}','SamplingController@delete')
            ->name('samplings.delete');
    });

    Route::group(['prefix' => 'point-notes'], function (){
        Route::get('/listNotes/{point_id}','PointNoteController@list')
            ->name('pointNotes.list');
        Route::get('/admin/{id}','PointNoteController@admin')
            ->name('pointNotes.admin');
        Route::get('/customer/{id}','PointNoteController@customer')
            ->name('pointNotes.customer');
        Route::get('/search','PointNoteController@filter')
            ->name('pointNotes.search');
        Route::get('/create','PointNoteController@create')
            ->name('pointNotes.create');
        Route::post('/store','PointNoteController@store')
            ->name('pointNotes.store');
        Route::get('/modalSeeForm','PointNoteController@modalSeeForm')
            ->name('pointNotes.modalSeeForm');
        Route::get('/edit/{id}','PointNoteController@edit')
            ->name('pointNotes.edit');
        Route::put('/update/{id}','PointNoteController@update')
            ->name('pointNotes.update');
    });


    Route::group(['prefix' => 'company-contacts'], function (){
        Route::get('/search','CompanyContactController@filter')
            ->name('companyContacts.search');
        Route::get('/listAll','CompanyConactController@listAll')
            ->name('companyContacts.listAll');
        Route::get('/listCompany/{company}','CompanyContactController@listCompany')
            ->name('companyContacts.listCompany');
        Route::get('/admin/{id}','CompanyContactController@admin')
            ->name('companyContacts.admin');
        Route::get('/user/{id}','CompanyContactController@user')
            ->name('companyContacts.user');
        Route::get('/create/{company?}','CompanyContactController@create')
            ->name('companyContacts.create');
        Route::post('/store','CompanyContactController@store')
            ->name('companyContacts.store');
        Route::get('/edit/{id}','CompanyContactController@edit')
            ->name('companyContacts.edit');
        Route::put('/update/{companyContact}','CompanyContactController@update')
            ->name('companyContacts.update');
        Route::get('/getCompanyContactsAjax','CompanyContactController@getCompanyContactsAjax')
            ->name('companyContacts.getCompanyContactsAjax');
    });
    Route::group(['prefix' => 'campaigns'], function (){
        Route::get('/listAll','CampaignController@listAll')
            ->name('campaigns.listAll');
        Route::get('/search','CampaignController@filter')
            ->name('campaigns.search');
        Route::get('/admin/{id}','CampaignController@admin')
            ->name('campaigns.admin');
        Route::get('/create','CampaignController@create')
            ->name('campaigns.create');
        Route::post('/store','CampaignController@store')
            ->name('campaigns.store');
        Route::get('/edit/{id}','CampaignController@edit')
            ->name('campaigns.edit');
        Route::put('/update/{campaign}','CampaignController@update')
            ->name('campaigns.update');
    });
    Route::group(['prefix' => 'surveys'], function (){
        Route::get('/listAll','SurveyController@listAll')
            ->name('surveys.listAll');
        Route::get('/admin/{id}','SurveyController@admin')
            ->name('surveys.admin');
        Route::get('/search','SurveyController@filter')
            ->name('surveys.search');
        Route::get('/create','SurveyController@create')
            ->name('surveys.create');
        Route::post('/store','SurveyController@store')
            ->name('surveys.store');
        Route::get('/addQuestions/{id}','SurveyController@addQuestions')
            ->name('surveys.addQuestions');
        Route::get('/results/{id}','SurveyController@results')
            ->name('surveys.results');
        Route::get('/edit/{id}','SurveyController@edit')
            ->name('surveys.edit');
        Route::put('/update/{id}','SurveyController@update')
            ->name('surveys.update');
    });
    Route::group(['prefix' => 'questions'], function (){
        Route::get('/create','QuestionController@create')
            ->name('questions.create');
        Route::post('/store','QuestionController@store')
            ->name('questions.store');
        Route::get('/edit/{id}','QuestionController@edit')
            ->name('questions.edit');
        Route::put('/update/{campaign}','QuestionController@update')
            ->name('questions.update');
    });
    Route::group(['prefix' => 'service-types'], function (){
        Route::get('/listAll','ServiceTypeController@listAll')
            ->name('serviceTypes.listAll');
        Route::get('/search','ServiceTypeController@filter')
            ->name('serviceTypes.search');
        Route::get('/admin/{id}','ServiceTypeController@admin')
            ->name('serviceTypes.admin');
        Route::get('/create','ServiceTypeController@create')
            ->name('serviceTypes.create');
        Route::post('/store','ServiceTypeController@store')
            ->name('serviceTypes.store');
        Route::get('/edit/{id}','ServiceTypeController@edit')
            ->name('serviceTypes.edit');
        Route::put('/update/{serviceType}','ServiceTypeController@update')
            ->name('serviceTypes.update');
        Route::put('/addAdditional/{id}','ServiceTypeController@addAdditional')
            ->name('serviceTypes.addAdditional');
    });
    Route::group(['prefix' => 'additionals'], function (){
        Route::get('/listAll/{id}','AdditionalController@listAll')
            ->name('additionals.listAll');
        Route::get('/search/{id}','AdditionalController@filter')
            ->name('additionals.search');
        Route::get('/admin/{id}','AdditionalController@admin')
            ->name('additionals.admin');
        Route::get('/create/{id}','AdditionalController@create')
            ->name('additionals.create');
        Route::post('/store/{id}','AdditionalController@store')
            ->name('additionals.store');
        Route::get('/edit/{id}','AdditionalController@edit')
            ->name('additionals.edit');
        Route::put('/update/{additional}','AdditionalController@update')
            ->name('additionals.update');
    });


    //TEST ROUTES//
    Route::group(['prefix' => 'documents'], function (){
        Route::get('/quickstart','DocumentController@quickstart')
            ->name('documents.quickstart');
        Route::get('/testQuotation','DocumentController@testQuotation')
            ->name('documents.testQuotation');
        Route::get('/createOpportunityDocument/{opportunity}/{type}/{documentType}','DocumentController@createOpportunityDocument')
            ->name('documents.createOpportunityDocument');
        Route::get('/editDocument/{opportunity}/{type}/{documentType}','DocumentController@editDocument')
            ->name('documents.editDocument');
        Route::get('/downloadDocument/{opportunity}/{type}','DocumentController@downloadDocument')
            ->name('documents.downloadDocument');
    });


    //TEST ROUTES//
    Route::group(['prefix' => 'reports'], function (){
        Route::get('/dashboard/{year?}/{months?}','ReportController@dashboard')
            ->name('reports.dashboard');
        //WON DATA
        Route::get('/totalWon/{year?}/{months?}','ReportController@totalWon')
            ->name('reports.usersWon');
        Route::get('/usersWon/{year?}/{months?}','ReportController@usersWon')
            ->name('reports.usersWon');
        Route::get('/servicesWon/{year?}/{months?}','ReportController@servicesWon')
            ->name('reports.servicesWon');
        Route::get('/servicesWonPrice/{year?}/{months?}','ReportController@servicesWonPrice')
            ->name('reports.servicesWonPrice');
        Route::get('/companiesWon/{year?}/{months?}','ReportController@companiesWon')
            ->name('reports.companiesWon');
        //OPEN
        Route::get('/usersOpen','ReportController@usersOpen')
            ->name('reports.usersOpen');
        Route::get('/companiesOpen','ReportController@companiesOpen')
            ->name('reports.companiesOpen');
        //BY STAGE
        Route::get('/stagesTotal/{year?}/{months?}','ReportController@stagesTotal')
            ->name('reports.stagesTotal');

        Route::get('/usersOpportunitiesSum/{year?}/{months?}','ReportController@usersOpportunitiesSum')
            ->name('reports.usersOpportunitiesSum');
    });
    Route::group(['prefix' => 'tests'], function (){
        Route::get('/maps','TestController@maps')
            ->name('tests.maps');
        Route::get('/mapsReports','TestController@mapsReports')
            ->name('tests.mapsReports');
        Route::get('/samplingResults','TestController@samplingResults')
            ->name('tests.samplingResults');
        Route::get('/getSamplingParameterData','TestController@getSamplingParameterData')
            ->name('tests.getSamplingParameterData');
        Route::get('/getSamplingParameterDataComparisson','TestController@getSamplingParameterDataComparisson')
            ->name('tests.getSamplingParameterDataComparisson');
    });

});

Route::group(['prefix' => 'surveys'], function (){
    Route::get('/vote/{uid}','SurveyController@vote')
        ->name('surveys.vote');
    Route::post('/storeVote','SurveyController@storeVote')
        ->name('surveys.storeVote');
});

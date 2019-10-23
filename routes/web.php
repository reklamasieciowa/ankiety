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




Route::get('/', function () {
    return redirect(app()->getLocale());
});

Route::group([
  'prefix' => '{locale}', 
  'where' => ['locale' => '[a-zA-Z]{2}'],
  'middleware' => 'setlocale'
], function() {
	Route::get('/', 'FrontController@index')->name('front.index'); //id ankiety + język

	Route::middleware('surveyactive')->group(function () {
		Route::get('/ankieta/{survey}/', 'SurveyController@show')->name('survey.start');

		Route::get('/ankieta/{survey}/dane', 'SurveyController@personalInfo')->name('survey.personal.info');
		
		Route::post('/ankieta/{survey}/dane', 'PersonController@store')->name('person.store');

		Route::get('/ankieta/{survey}/ankietowany/{person}/kategoria/{currentCategory}', 'SurveyController@showCategory')->name('survey.category');

		Route::get('/ankieta/{survey}/dziekujemy', 'SurveyController@finish')->name('survey.finish');

		Route::post('/ankieta/{survey}/ankietowany/{person}/kategoria/{currentCategory}', 'answerController@store')->name('answer.store');

		//Route::get('/ankieta/{survey}/all', 'SurveyController@showAll')->name('survey.all');
	});

});

Route::group([
  'prefix' => 'zaplecze', 
  'middleware' => 'auth'
], function() {
	Route::get('/', 'SurveyAdminController@index')->name('admin.index');

	Route::get('/ankieta/dodaj/', 'SurveyAdminController@create')->name('admin.survey.create');
	Route::put('/ankieta/dodaj/', 'SurveyAdminController@store')->name('admin.survey.store');
	Route::get('/ankieta/{survey}/', 'SurveyAdminController@show')->name('admin.survey.show');
	Route::get('/ankieta/{survey}/edytuj/', 'SurveyAdminController@edit')->name('admin.survey.edit');
	Route::patch('/ankieta/{survey}/edytuj/', 'SurveyAdminController@update')->name('admin.survey.update');
	Route::get('/{survey}/status', 'SurveyAdminController@statusChange')->name('admin.survey.status.change');
	Route::get('/ankieta/{survey}/pytania/', 'SurveyAdminController@attachQuestionsForm')->name('admin.survey.attachQuestionsForm');
	Route::post('/ankieta/{survey}/pytania/', 'SurveyAdminController@attachQuestions')->name('admin.survey.attachQuestions');
	Route::delete('/ankieta/{survey}/usuń/', 'SurveyAdminController@destroy')->name('admin.survey.destroy');


	Route::get('/firma/', 'CompanyController@index')->name('admin.company.index');
	Route::get('/firma/dodaj', 'CompanyController@create')->name('admin.company.create');
	Route::put('/firma/dodaj', 'CompanyController@store')->name('admin.company.store');
	Route::get('/firma/edytuj/{company}', 'CompanyController@edit')->name('admin.company.edit');
	Route::patch('/firma/edytuj/{company}', 'CompanyController@update')->name('admin.company.update');
	Route::delete('/firma/usun/{company}', 'CompanyController@destroy')->name('admin.company.destroy');

	Route::get('/kategoria/', 'CategoryController@index')->name('admin.category.index');

	Route::put('/kategoria/', 'CategoryController@store')->name('admin.category.store');

	Route::get('/pytania/', 'QuestionController@index')->name('admin.questions.index');
	Route::get('/pytania/dodaj', 'QuestionController@create')->name('admin.questions.create');
	Route::put('/pytania/dodaj/', 'QuestionController@store')->name('admin.questions.store');
	Route::get('/pytania/edytuj/{question}', 'QuestionController@edit')->name('admin.questions.edit');
	Route::patch('/pytania/aktualizuj/{question}', 'QuestionController@update')->name('admin.questions.update');
	Route::delete('/pytania/usun/{question}', 'QuestionController@destroy')->name('admin.questions.destroy');

	Route::get('/pytania/odepnij/{question}/{survey}', 'QuestionController@detach')->name('admin.questions.detach');

	
	


});


Auth::routes(['register' => false]);
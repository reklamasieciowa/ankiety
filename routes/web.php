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
	Route::get('/', 'FrontController@index')->name('front.index');
	Route::get('/polityka-prywatnosci', 'FrontController@rodo')->name('front.rodo');

	Route::middleware('surveyactive')->group(function () {
		Route::get('/{survey_uuid}/', 'SurveyController@show')->name('survey.start');

		Route::get('/{survey_uuid}/dane', 'SurveyController@personalInfo')->name('survey.personal.info');
		
		Route::post('/{survey_uuid}/dane', 'PersonController@store')->name('person.store');

		Route::get('/{survey_uuid}/{person}/{currentCategory}', 'SurveyController@showCategory')->name('survey.category');

		Route::post('/{survey_uuid}/{person}/{currentCategory}', 'AnswerController@store')->name('answer.store');

		Route::get('/{survey_uuid}/dziekujemy', 'SurveyController@finish')->name('survey.finish');

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
	Route::delete('/ankieta/{survey}/usun/', 'SurveyAdminController@destroy')->name('admin.survey.destroy');

	Route::get('/ankieta/{survey}/kategorie/', 'SurveyAdminController@attachCategoriesForm')->name('admin.survey.attachCategoriesForm');
	Route::post('/ankieta/{survey}/kategorie/', 'SurveyAdminController@attachCategories')->name('admin.survey.attachCategories');

	Route::delete('/ankieta/{survey}/usunpuste/', 'SurveyAdminController@destroyEmptyPeople')->name('admin.survey.destroy.empty.people');

	Route::get('/firma/', 'CompanyController@index')->name('admin.company.index');
	Route::get('/firma/dodaj', 'CompanyController@create')->name('admin.company.create');
	Route::put('/firma/dodaj', 'CompanyController@store')->name('admin.company.store');
	Route::get('/firma/edytuj/{company}', 'CompanyController@edit')->name('admin.company.edit');
	Route::patch('/firma/edytuj/{company}', 'CompanyController@update')->name('admin.company.update');
	Route::delete('/firma/usun/{company}', 'CompanyController@destroy')->name('admin.company.destroy');

	Route::get('/kategoria/', 'CategoryController@index')->name('admin.category.index');
	Route::put('/kategoria/', 'CategoryController@store')->name('admin.category.store');
	Route::get('/kategoria/edytuj/{category}', 'CategoryController@edit')->name('admin.category.edit');
	Route::patch('/kategoria/edytuj/{category}', 'CategoryController@update')->name('admin.category.update');
	Route::delete('/kategoria/usun/{category}', 'CategoryController@destroy')->name('admin.category.destroy');

	Route::get('/pytanie/', 'QuestionController@index')->name('admin.questions.index');
	Route::get('/pytanie/dodaj', 'QuestionController@create')->name('admin.questions.create');
	Route::put('/pytanie/dodaj/', 'QuestionController@store')->name('admin.questions.store');
	Route::get('/pytanie/edytuj/{question}', 'QuestionController@edit')->name('admin.questions.edit');
	Route::patch('/pytanie/aktualizuj/{question}', 'QuestionController@update')->name('admin.questions.update');
	Route::delete('/pytanie/usun/{question}', 'QuestionController@destroy')->name('admin.questions.destroy');
	Route::get('/pytanie/odepnij/{question}/{survey}', 'QuestionController@detach')->name('admin.questions.detach');

	Route::get('/opcja/', 'QuestionOptionController@index')->name('admin.questions.options.index');
	Route::put('/opcja/', 'QuestionOptionController@store')->name('admin.questions.options.store');
	Route::get('/opcja/{questionOption}/edytuj', 'QuestionOptionController@edit')->name('admin.questions.options.edit');
	Route::patch('/opcja/{questionOption}/edytuj', 'QuestionOptionController@update')->name('admin.questions.options.update');
	Route::delete('/opcja/{questionOption}/destroy', 'QuestionOptionController@destroy')->name('admin.questions.options.destroy');

	Route::get('/skala/', 'ScaleController@index')->name('admin.scale.index');
	Route::put('/skala/dodaj', 'ScaleController@store')->name('admin.scale.store');
	Route::get('/skala/{scale}/edytuj', 'ScaleController@edit')->name('admin.scale.edit');
	Route::patch('/skala/{scale}/edytuj', 'ScaleController@update')->name('admin.scale.update');
	Route::delete('/skala/{scale}/usun', 'ScaleController@destroy')->name('admin.scale.destroy');

	Route::put('/skala/{scale}/wartosc/dodaj', 'ScaleValueController@store')->name('admin.scale.value.store');
	Route::get('/skala/{scale}/wartosc/{scaleValue}/edytuj', 'ScaleValueController@edit')->name('admin.scale.value.edit');
	Route::patch('/skala/{scale}/wartosc/{scaleValue}/edytuj', 'ScaleValueController@update')->name('admin.scale.value.update');
	Route::delete('/skala/{scale}/wartosc/usun/{scaleValue}', 'ScaleValueController@destroy')->name('admin.scale.value.destroy');

	Route::get('/ankietowany/', 'PersonController@index')->name('admin.people.index');
	Route::delete('/ankietowany/{person}/destroy', 'PersonController@destroy')->name('admin.people.destroy');

	Route::get('/ankietowany/maile', 'PersonController@emails')->name('admin.people.emails');

	Route::get('/odpowiedzi/{person}', 'PersonController@show')->name('admin.people.show');

	Route::get('/stanowisko/', 'PostController@index')->name('admin.post.index');
	Route::put('/stanowisko/dodaj', 'PostController@store')->name('admin.post.store');
	Route::get('/stanowisko/{post}/edytuj', 'PostController@edit')->name('admin.post.edit');
	Route::patch('/stanowisko/{post}/edytuj', 'PostController@update')->name('admin.post.update');
	Route::delete('/stanowisko/{post}/usun', 'PostController@destroy')->name('admin.post.destroy');

	Route::get('/dzial/', 'DepartmentController@index')->name('admin.department.index');
	Route::put('/dzial/dodaj', 'DepartmentController@store')->name('admin.department.store');
	Route::get('/dzial/{department}/edytuj', 'DepartmentController@edit')->name('admin.department.edit');
	Route::patch('/dzial/{department}/edytuj', 'DepartmentController@update')->name('admin.department.update');
	Route::delete('/dzial/{department}/usun', 'DepartmentController@destroy')->name('admin.department.destroy');

	Route::get('/branza/', 'IndustryController@index')->name('admin.industry.index');
	Route::put('/branza/dodaj', 'IndustryController@store')->name('admin.industry.store');
	Route::get('/branza/{industry}/edytuj', 'IndustryController@edit')->name('admin.industry.edit');
	Route::patch('/branza/{industry}/edytuj', 'IndustryController@update')->name('admin.industry.update');
	Route::delete('/branza/{industry}/usun', 'IndustryController@destroy')->name('admin.industry.destroy');

	Route::get('/uzytkownik/', 'UserController@index')->name('admin.user.index');
	Route::get('/uzytkownik/dodaj', 'Auth\RegisterController@showRegistrationForm')->name('admin.user.create');
	Route::post('/uzytkownik/dodaj', 'Auth\RegisterController@register')->name('admin.user.store');
	Route::get('/uzytkownik/{user}/edytuj', 'UserController@edit')->name('admin.user.edit');
	Route::post('/uzytkownik/{user}/edytuj', 'UserController@update')->name('admin.user.update');
	Route::delete('/uzytkownik/{user}/usun', 'UserController@destroy')->name('admin.user.destroy');

	Route::get('/wyniki/', 'ResultsController@index')->name('admin.result');
	Route::get('/wyniki/stanowiska', 'ResultsController@PostListChart')->name('admin.result.post');
	Route::get('/wyniki/branze', 'ResultsController@IndustryListChart')->name('admin.result.industry');
	Route::get('/wyniki/dzialy', 'ResultsController@DepartmentListChart')->name('admin.result.department');
	Route::get('/wyniki/kategorie', 'ResultsController@AllCategoriesChart')->name('admin.result.categories');
	Route::get('/wyniki/kategoria/{category_id}', 'ResultsController@CategoryChart')->name('admin.result.category');
	Route::get('/wyniki/kategoria/rozklad/{category_id}', 'ResultsController@CategoryValuesChart')->name('admin.result.category.values');
	Route::get('/wyniki/top5/{order}', 'ResultsController@topFive')->name('admin.result.top5');

	Route::get('/porownanie/', 'ResultsCompareController@select')->name('admin.compare.select');
	Route::get('/porownanie/{survey}', 'ResultsCompareController@index')->name('admin.compare');
	Route::get('/porownanie/{survey}/kategorie', 'ResultsCompareController@AllCategoriesChart')->name('admin.result.compare.categories');
	Route::get('/porownanie/{survey}/kategoria/{category_id}', 'ResultsCompareController@CategoryChart')->name('admin.result.compare.category');
	Route::get('/porownanie/{survey}/kategoria/rozklad/{category_id}', 'ResultsCompareController@CategoryValuesChart')->name('admin.result.compare.category.values');

	Route::get('/wynikidzialow/', 'ResultsByDepartmentController@selectSurvey')->name('admin.resultbydepartment.select.survey');

	Route::get('/wynikidzialow/{survey}', 'ResultsByDepartmentController@selectDepartment')->name('admin.resultbydepartment.select.department');
	Route::get('/wynikidzialow/{survey}/{department}', 'ResultsByDepartmentController@index')->name('admin.resultbydepartment');
	Route::get('/wynikidzialow/{survey}/{department}/stanowiska', 'ResultsByDepartmentController@PostListChart')->name('admin.resultbydepartment.post');
	Route::get('/wynikidzialow/{survey}/{department}/kategorie', 'ResultsByDepartmentController@AllCategoriesChart')->name('admin.resultbydepartment.categories');
	Route::get('/wynikidzialow/{survey}/{department}/kategoria/{category}', 'ResultsByDepartmentController@CategoryChart')->name('admin.resultbydepartment.category');
	Route::get('/wynikidzialow/{survey}/{department}/kategoria/rozklad/{category}', 'ResultsByDepartmentController@CategoryValuesChart')->name('admin.resultbydepartment.category.values');

	Route::get('/wynikidzialow/{survey}/{department}/top5/{order}', 'ResultsByDepartmentController@topFive')->name('admin.resultbydepartment.top5');

});


Auth::routes(['register' => false]);
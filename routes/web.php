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

Route::get('billplz/response', 'PaymentController@response_billplz')->name('payment-response');
Route::post('billplz/callback', 'PaymentController@callback_billplz')->name('payment-callback');

Route::get('/', function () {
    return view('index');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/tinkaleadership', function () {
    return view('tinkaleadership');
});
Route::get('/tinkaeducentre', function () {
    return view('tinkaeducentre');
});
Route::get('/tinkaapp', function () {
    return view('tinkaapp');
});
Route::get('/tuitionfees', function () {
    return view('tuitionfees');
});

Route::get('/contact', 'ContactController@contact')->name('contact');
Route::post('/contact', 'ContactController@contactPost')->name('contactPost');

Route::get('/aqliah', function () {
    return view('aqliah');
});
Route::get('/dato', function () {
    return view('dato');
});
Route::get('/faisal', function () {
    return view('faisal');
});
Route::get('/soheil', function () {
    return view('soheil');
});
Route::get('/emeritus', function () {
    return view('emeritus');
});
Route::get('/rozhan', function () {
    return view('rozhan');
});
Route::get('/faq', function() {
    return view('faq');
});
Route::get('/teachers', function() {
    return view('teachers');
});
Route::get('profile', function(){
    return view('profile');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/{id}', 'ProfileController@profile')->name('view-profile');
    Route::get('/profile/change-password/{id}', 'ProfileController@change_password')->name('change-password');
    Route::post('/profile/reset-password', 'ProfileController@reset_password')->name('reset-password');
    Route::get('/profile/create-profile/{id}', 'ProfileController@create_profile')->name('create-profile');
    Route::get('/dashboard', function () {
        return view('index');
    });
});

/*Route::get('/register/teacher', function() {
    return view('coming-soon');
});
Route::get('/register/student', function() {
    return view('coming-soon');
});*/

Route::get('/register/teacher', 'TeacherController@create')->name('register-teacher');
Route::get('/register/student', 'StudentController@create')->name('register-student');

Route::post('/create/teacher', 'TeacherController@store')->name('create-teacher');
Route::post('/create/student', 'StudentController@store')->name('create-student');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('faqs', FaqController::class);
Route::resource('subscription', SubscriptionController::class);
Route::get('subscription/book', 'SubscriptionController@store')->name('create-subscription');
Route::resource('plan', PlanController::class);
Route::post('plan/checkout', 'PlanController@checkout')->name('plan-checkout');
Route::resource('payment', PaymentController::class);
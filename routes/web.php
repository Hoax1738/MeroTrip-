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

use Illuminate\Support\Facades\Route;
use App\Image;
use App\Packages;
use App\Itinerary;

Route::get('/', 'PackagesController@home')->name('homePage');
Route::any('/packages', 'PackagesController@show')->name('packages');
Route::get('/p/{slug}', 'PackagesController@showsingle')->name('singlePackage');
Route::get('/contact', 'PackagesController@contactPage')->name('contact');
Route::any('/search','PackagesController@searchPackage')->name('search.package');
Route::get('/about','PackagesController@aboutPage')->name('about');
// Route::get('/testimonial','PackagesController@testimonialPage')->name('testimonial');
Route::get('/terms','PackagesController@termsPage')->name('terms');
Route::get('/policy','PackagesController@policyPage')->name('policy');
Route::get('/faq','PackagesController@faqPage')->name('faq');

Route::get('/gallery','PackagesController@galleryPage')->name('gallery');
Route::get('/tag/{tag}','PackagesController@tagPage')->name('tag');


Route::get('/saveWishList/{id}/{status}','PackagesController@saveWishList')->name('saveWishList');


Route::post('/sendenquiry', 'PackagesController@sendEnquiry')->name('sendenquiry');
Route::post('/ajaxDestination','PackagesController@getAjaxDestination');
Route::post('/ajaxAllDestination','PackagesController@getAllAjaxDestination');


Route::any('esewa/success', 'EsewaController@success')->name('esewa.success');
Route::any('esewa/fail', 'EsewaController@fail')->name('esewa.fail');
Route::get('payment/response', 'EsewaController@payment_response')->name('payment.response');


Route::any('esewa/generalSuccess','EsewaController@generalSuccess')->name('esewa.generalSuccess');
Route::any('esewa/generalFail','EsewaController@generalFail')->name('esewa.generalFail');

Route::any('esewa/bookSuccess','EsewaController@bookSuccess')->name('esewa.bookSuccess');
Route::any('esewa/bookFail','EsewaController@bookFail')->name('esewa.bookFail');
Route::get('/gallery/{slug}', 'PackagesController@singleGallery')->name('singleGallery');


Auth::routes(['verify'=>'true']);
Route::group(['middleware' => ['customer','verified']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/commitments', 'UserController@commits')->name('MyCommitments');
    Route::any('/payments', 'UserController@payments')->name('myPayments');

    Route::get('/account', 'UserController@account')->name('account');

    Route::get('/pay', 'UserController@pay')->name('makePayment');
    Route::post('/pay', 'UserController@pay')->name('postPayment');

    Route::get('/emi/{id}', 'UserController@viewEmi')->name('viewEMI');
    Route::post('/book/{trip}/{date}', 'UserController@book')->name('calculateEMI');

    Route::get('/wishlist','UserController@showWishList')->name('wishlist');
    Route::post('/update-profile','UserController@updateProfile')->name('update-profile');

    Route::get('/removePhoto','UserController@removeUserPhoto');

    Route::get('/review','PackagesController@showAddReview');
    Route::post('/saveReview','PackagesController@saveReview');

    Route::get('/userGuide/{value}','UserController@updateUserGuide')->name('guide');

    Route::get('/payments-pdf', 'UserController@paymentsPdf')->name('payments-pdf');
    Route::get('/single-payment/{id}', 'UserController@singlePayment')->name('single-payment');


    Route::any('/referFriend','UserController@referFriend');
    Route::any('/refer', 'UserController@refers')->name('refer');

    Route::post('/updatepassword','UserController@update_password')->name('update-user-password');

});

Route::group(['middleware' => ['admin','verified']], function(){
    Route::get('/croom', 'AdminController@index')->name('croom.home');
    Route::get('/croom/packages', 'AdminController@packages')->name('croom.packages');
    Route::get('/croom/packages/new', 'AdminController@newPackages')->name('croom.packages.new');
    Route::post('/croom/packages/new', 'AdminController@newPackageSave')->name('croom.packages.new.save');
    Route::get('/itinerary', 'AdminController@packageItinerary')->name('itinerary');
    Route::get('/itinerary/add/{id}', 'AdminController@addItinerary')->name('itinerary.add');
    Route::post('/add-edit-itinerary', 'AdminController@saveItinerary')->name('add-edit-itinerary');

    Route::get('/croom/packages/edit/{id}', 'AdminController@editPackage')->name('croom.packages.edit');
    Route::post('/croom/packages/edit/{id}', 'AdminController@editPackageSave')->name('croom.packages.edit.save');

    Route::get('/croom/hotels', 'AdminController@hotels')->name('croom.hotels');
    Route::get('/croom/hotels/new', 'AdminController@newHotels')->name('croom.hotels.add');
    Route::post('/croom/hotels/new', 'AdminController@newHotelSave')->name('croom.hotels.add.save');

    Route::get('/croom/users', 'AdminController@user')->name('croom.users');
    Route::get('/croom/payments', 'AdminController@packages')->name('croom.payments');
    Route::get('/croom/packages', 'AdminController@packages')->name('croom.packages');
    Route::get('/croom/ajax/hotels/{q}', 'AdminController@hotelAjax');

    Route::get('/croom/packages/deleteCommenceDate/{id}','AdminController@deleteCommenceDate')->name('croom.packages.deleteCommenceDate');
    Route::get('/croom/packages/deleteAddInfo/{id}','AdminController@deleteAddInfo')->name('croom.packages.deleteAddInfo');
    Route::get('/croom/packages/deleteAddIt/{id}','AdminController@deleteIt')->name('croom.packages.deleteAddIt');
    Route::get('/croom/packages/deleteImages/{id}/{key}','AdminController@removeOldImages')->name('croom.packages.removeImages');

    Route::get('/itinerary/removeImg/{id}/{key}','AdminController@removeItineraryImages')->name('itinerary.removeImages');

    Route::get('/customers', 'AdminController@customers')->name('customers');

    Route::get('/commit/{id}', 'AdminController@viewCustomer')->name('commit');
    Route::any('/payment/{id}', 'AdminController@customerPayments')->name('payment');
    Route::get('/customer_emi/{c_id}/{user_id}', 'AdminController@customerEMI')->name('customer_emi');

    Route::get('/enquiries', 'AdminController@viewEnquiries')->name('enquiries');

    Route::post('/updateGeneralEmi','AdminController@updateGeneralEmi')->name('updateGeneralEmi');

    Route::get('/booking','AdminController@makeBooking')->name('makeBooking');

    Route::post('/getSlug','AdminController@getSlug'); // ajax to get slug

    Route::post('/bookFirst','AdminController@bookFirst')->name('bookFirst');

    Route::post('/checkReviseEmi','AdminController@checkReviseEmi');

    Route::match(['get','post'],'/cancel/{id}','AdminController@cancelCommit');
    Route::match(['get','post'],'/completed/{id}','AdminController@concludeCommit');

    Route::get('/settings','AdminController@settings')->name('settings');
    Route::match(['get', 'post'], '/add-edit-settings/{id?}','AdminController@newSettings')->name('add-edit-settings');
    Route::get('/menu-items','AdminController@listMenu')->name('menu-items');
    Route::match(['get', 'post'], '/add-edit-menu/{id?}','AdminController@addEditMenu')->name('add-edit-menu');

    Route::get('/changepassword','AdminController@change_admin_password')->name('change_admin_password');
    Route::post('/adminupdatepassword','AdminController@update_admin_password')->name('update-admin-password');

});

Route::get('/clear','PackagesController@clear')->name('clear');

Route::get('/abc','PackagesController@check');

Route::get('/check','ImePayController@check');

Route::any('ime/bookSuccess','ImePayController@bookSuccess')->name('ime.bookSuccess');
Route::any('ime/fail','ImePayController@fail')->name('ime.fail');

Route::any('ime/advancePayment','ImePayController@advancePayment')->name('ime.advancePayment');

// Route::post('/api/sent','ImePayController@verifyPayment');


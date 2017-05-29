<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => ['web']],function () {

    Route::group(['middleware' => ['authredirect']], function() {
        Route::get('/login', "AuthController@showLogin");
        Route::post('/login', "AuthController@login");
        Route::get('/register', "AuthController@showRegister");
        Route::post('/register', "AuthController@register");

        Route::get('/user/{user_id}/sendCheckLetter', "AuthController@sendCheckLetter");
        Route::get('/user/checkEmail/{token}', "AuthController@checkEmail");

        Route::get('/iforgotit', "AuthController@showPasswordForget");
        Route::post('/iforgotit', "AuthController@sendPasswordResetMail");
        Route::get('/passwordReset/{token}', "AuthController@showPasswordReset");
        Route::post('/passwordReset/{token}', "AuthController@resetPassword");
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::post('/user/{user_id}/edit/account', "UserController@editAccount");
        Route::get('/user/userinfo/edit/{userinfo_id}', "UserController@editUserInfo");
        Route::post('/user/userinfo/update', "UserController@updateUserInfo");
        Route::post('/user/userinfo/delete', "UserController@deleteUserInfo");
    });

    Route::get('/logout', "AuthController@logOut")->middleware('auth');

    Route::get('/register/2', "UserController@showCompleteUser")->middleware('auth');
    Route::post('/register/2', "UserController@completeUser")->middleware('auth');
    Route::get('/register/3', "UserController@regUserInfo")->middleware('auth');

    Route::get('user/userinfo', "UserController@userInfo")->middleware('auth');
    Route::get('/user/userinfo/create', "UserController@createUserInfo")->middleware('auth');
    Route::post('user/userinfo', "UserController@storeUserInfo")->middleware('auth');

    Route::get('/user/fav', "UserController@getFavlist")->middleware('auth');
    Route::get('/user/fav/edit', "UserController@editFavlist")->middleware('auth');
    Route::delete('/user/fav/del', "UserController@delFavlist")->middleware('auth');

    Route::get('/avatar/{user_id}', "UserController@getSimpleAvatar");
    Route::get('/avatar/{user_id}/{width}/{height}', "UserController@getAvatar");

    Route::get('/good', "GoodController@getList");

    Route::get('/good/add', "GoodController@showAddGood")->middleware('auth');
    Route::post('/good/add', "GoodController@addGood")->middleware('auth');

    Route::get('/good/{good_id}', "GoodController@getInfo");
    Route::get('/good/{good_id}/edit', "GoodController@showEditGood")->middleware('auth');
    Route::post('/good/{good_id}/edit', "GoodController@editGood")->middleware('auth');

    Route::delete('/good/{good_id}/delete', "GoodController@deleteGood")->middleware('auth');

    Route::get('/good/{good_id}/titlepic', "GoodController@getSimpleTitlePic");
    Route::get('/good/{good_id}/titlepic/{width}/{height}', "GoodController@getTitlePic");

    Route::post('/good/{good_id}/add_favlist', "GoodController@addFavlist")->middleware('auth');
    Route::delete('/good/{good_id}/del_favlist', "GoodController@delFavList")->middleware('auth');

    Route::get('/message', "MessageController@getMessage")->middleware('auth');
    Route::get('/test/sendmessagepage', "MessageController@sendMessagepage")->middleware('su');
    Route::post('/message', "MessageController@sendMessage")->middleware('auth');
    Route::get('/message/num', "MessageController@getUnreadMsgNum")->middleware('auth');
    Route::put('/message/{id}', "MessageController@readMessage")->middleware('auth');
    Route::delete('/message/{id}', "MessageController@deleteMessage")->middleware('auth');

    Route::get('/user/sell', "UserController@mygoods")->middleware('auth');
    Route::get('/user/sell/trans', "UserController@sellerTrans")->middleware('auth');
    Route::get('/user/sell/tickets', "UserController@tickets")->middleware('auth');
    Route::get('/user/trans', "UserController@buyer")->middleware('auth');
    Route::post('/good/{good_id}/buy', "TransactionController@add")->middleware('auth');

    //------Above are tested function

    Route::get('/user/{user_id}/edit', [
        "uses" => "UserController@showEditPage",
        "middleware" => "auth"
    ]);

    Route::post('/user/{user_id}/edit/middle', [
        "uses" => "UserController@editList",
        "middleware" => "auth"
    ]);

    Route::get('/user/{user_id}', [
        "uses" => "UserController@getList",
        "middleware" => "auth"
    ]);

    Route::get('/', [
        "uses" => "ContentController@Mainpage",
    ]);

    Route::get('/announcement/{announcement_id}', [
        "uses" => "ContentController@announcementPage",
    ]);

    Route::match(['post', 'get'], '/good/check', [
        "uses" => "GoodController@check",
        "middleware" => "auth"
    ]);

    Route::match(['post', 'get'], '/good/end', [
        "uses" => "GoodController@end",
        "middleware" => "auth"
    ]);

    Route::post('/good/{trans_id}/allow', [
        "uses" => "GoodController@allow",
        "middleware" => "auth"
    ]);

    Route::get('/good/{good_id}/check', [
        "uses" => "AdminController@checkGood",
        "middleware" => "admin"
    ]);

    Route::get('/admin', [
        "uses" => "AdminController@adminIndex",
        "middleware" => "admin"
    ]);

    Route::post('/user/{user_id}/updatePriv', [
        "uses" => "AdminController@updateUserPriv",
        "middleware" => "su"
    ]);

    Route::post('/user/{user_id}/updateRole', [
        "uses" => "AdminController@updateUserRole",
        "middleware" => "admin"
    ]);

    Route::post('/cat/{cat_id}/edit', [
        "uses" => "AdminController@editCategory",
        "middleware" => "admin"
    ]);

    Route::delete('/cat/{cat_id}/delete', [
        "uses" => "AdminController@deleteCategory",
        "middleware" => "admin"
    ]);

    Route::match(['post','get'],'/sendannouncement',[
        "uses" => "AdminController@sendAnnouncement",
        "middleware" => "admin"
    ]);

    Route::match(['post','get'],'/sendannouncement/send',[
        "uses" => "AdminController@checkAnnouncement",
        "middleware" => "admin"
    ]);

    Route::match(['post','get'],'/announcement',[
        "uses" => "AdminController@getAnnouncement",
        "middleware" => "auth"
    ]);
});

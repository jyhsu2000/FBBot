<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//首頁
Route::get('/', 'HomeController@index')->name('index');
//隱私權政策
Route::get('privacy', function () {
    return view('static.privacy');
})->name('privacy');
//服務條款
Route::get('terms', function () {
    return view('static.terms');
})->name('terms');

//會員（須完成信箱驗證）
Route::group(['middleware' => ['auth', 'email']], function () {
    //會員管理
    //權限：user.manage、user.view
    Route::resource('user', 'UserController', [
        'except' => [
            'create',
            'store',
        ],
    ]);
    //角色管理
    //權限：role.manage
    Route::group(['middleware' => 'permission:role.manage'], function () {
        Route::resource('role', 'RoleController', [
            'except' => [
                'show',
            ],
        ]);
    });
    //會員資料
    Route::group(['prefix' => 'profile'], function () {
        //查看會員資料
        Route::get('/', 'ProfileController@getProfile')->name('profile');
        //編輯會員資料
        Route::get('edit', 'ProfileController@getEditProfile')->name('profile.edit');
        Route::put('update', 'ProfileController@updateProfile')->name('profile.update');
    });
    //FB訊息機器人除錯面板
    Route::group(['middleware' => 'permission:fb-bot.manage'], function () {
        Route::get('fb-messenger/debug', '\Casperlaitw\LaravelFbMessenger\Controllers\DebugController@index')
            ->name('fb-bot.debug');
    });
});

//會員系統
//將 Auth::routes() 複製出來自己命名
Route::group(['namespace' => 'Auth'], function () {
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::post('logout', 'LoginController@logout')->name('logout');
    // Registration Routes...
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register')->name('register');
    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');
    //修改密碼
    Route::get('password/change', 'PasswordController@getChangePassword')->name('password.change');
    Route::put('password/change', 'PasswordController@putChangePassword')->name('password.change');
    //驗證信箱
    Route::get('resend', 'RegisterController@resendConfirmMailPage')->name('confirm-mail.resend');
    Route::post('resend', 'RegisterController@resendConfirmMail')->name('confirm-mail.resend');
    Route::get('confirm/{confirmCode}', 'RegisterController@emailConfirm')->name('confirm');
});

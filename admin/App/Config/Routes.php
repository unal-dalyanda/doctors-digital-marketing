<?php

use System\Libs\Router\Router as Route;

Route::set404(function () {
    header('HTTP/1.1 404 Not Found');
    header('Content-Type: application/json; charset=utf-8');

    $content = [
        'status' => 'error',
        'message' => 'The page you requested was not found!'
    ];

    echo json_encode($content);
});

Route::prefix('auth')->namespace('backend')->group(function () {
    Route::get('/login', 'AuthController@login')->name('login');
    Route::post('/login', 'AuthController@loginAction')->name('login_action');
    Route::get('/logout', 'AuthController@logout')->name('logout');
});

Route::prefix('admin')->namespace('backend')->middleware(['auth'])->group(function () {
    Route::get('/', 'AdminController@index')->name('admin_dashboard');
    Route::get('/dashboard', 'AdminController@index');
    Route::get('/settings', 'AdminController@settings')->name('settings');
    Route::post('/settings/save/{type}', 'AdminController@settingsSave')
        ->where([
            'type' => '([a-zA-Z]+)'
        ])->name('settings_save');
    Route::get('/profile-edit', 'AdminController@profileEdit')->name('profile_edit');
    Route::post('/profile/save/{userId}', 'AdminController@profileEditSave')
        ->where([
            'userId' => '(\d+)'
        ])
        ->name('profile_edit_save');
    Route::post('/image-upload', 'AdminController@contentImageUpload')->name('image_upload');
    Route::get('/image-gallery', 'AdminController@imageGallery')->name('image_gallery');

    /* Applications Route */
    Route::get('/applications/{applicationType}', 'ApplicationController@applicationList')
        ->where(['applicationType' => '([a-zA-Z]+)'])
        ->name('application_list');
    Route::get('/application/{applicationId}', 'ApplicationController@detail')
        ->where(['applicationId' => '(\d+)'])
        ->name('application_detail');
    Route::get('/application/mark/{markType}/{applicationId}', 'ApplicationController@markApplication')
        ->where([
            'markType' => '([a-zA-Z]+)',
            'applicationId' => '(\d+)'
        ])
        ->name('application_mark');
    Route::get('/application/delete/{applicationId}', 'ApplicationController@delete')
        ->where(['applicationId' => '(\d+)'])
        ->name('application_delete');
    Route::post('/application/save/{applicationId}', 'ApplicationController@save')
        ->where(['applicationId' => '(\d+)'])
        ->name('application_admin_save');

    /* Pages Route */
    Route::get('/pages', 'PageController@index')->name('pages');
    Route::get('/page/edit/{pageId}', 'PageController@edit')
        ->where(['pageId' => '(\d+)'])
        ->name('page_edit');
    Route::post('/page/edit/save/{pageId}', 'PageController@editAction')
        ->where(['pageId' => '(\d+)'])
        ->name('page_edit_action');

    /* Blog Route */
    Route::get('/blogs', 'BlogController@index')->name('blogs');
    Route::get('/blog/add', 'BlogController@add')->name('blog_add');
    Route::post('/blog/save', 'BlogController@save')->name('blog_add_action');
    Route::get('/blog/edit/{blogId}', 'BlogController@edit')
        ->where(['blogId' => '(\d+)'])
        ->name('blog_edit');
    Route::post('/blog/edit/save/{blogId}', 'BlogController@editAction')
        ->where(['blogId' => '(\d+)'])
        ->name('blog_edit_action');
    Route::get('/blog/delete/{blogId}', 'BlogController@delete')
        ->where(['blogId' => '(\d+)'])
        ->name('blog_delete');

    Route::get('/categories', 'BlogController@categories')->name('categories');
    Route::post('/category/add', 'BlogController@categoryAdd')->name('category_add');
    Route::get('/category/delete/{categoryId}', 'BlogController@categoryDelete')
        ->where(['categoryId' => '(\d+)'])
        ->name('category_delete');

    /* Services Route */
    Route::get('/services', 'ServiceController@index')->name('services');
    Route::post('/service/add', 'ServiceController@add')->name('service_add');
    Route::get('/service/delete/{serviceId}', 'ServiceController@delete')
        ->where(['serviceId' => '(\d+)'])
        ->name('service_delete');

    /* FAQ Route */
    Route::get('/faq', 'FaqController@index')->name('faq');
    Route::get('/faq/edit/{faqId}', 'FaqController@edit')
        ->where(['faqId' => '(\d+)'])
        ->name('faq_edit');
    Route::post('/faq/add', 'FaqController@add')->name('faq_add');
    Route::post('/faq/update/{faqId}', 'FaqController@update')
        ->where(['faqId' => '(\d+)'])
        ->name('faq_update');
    Route::get('/faq/delete/{faqId}', 'FaqController@delete')
        ->where(['faqId' => '(\d+)'])
        ->name('faq_delete');
});

Route::prefix('api')->namespace('api')->group(function () {
    Route::get('/home', 'PageController@index')->name('api_home');
    Route::get('/blogs', 'BlogController@blogs')->name('api_blogs');
    Route::get('/blogs/{pageNum}', 'BlogController@blogs')
        ->where(['pageNum' => '(\d+)'])
        ->name('api_blogs');
    Route::get('/blogs/{categoryId}/{pageNum}', 'BlogController@blogsWithCategory')
        ->where([
            'categoryId'    => '(\d+)',
            'pageNum'       => '(\d+)'
        ])
        ->name('api_blogs');
    Route::get('/blog/detail/{blogId}', 'BlogController@blogDetail')
        ->where(['blogId' => '(\d+)'])
        ->name('api_blog');
    Route::post('/action/contact', 'ActionController@formPost')->name('contact_post');
});

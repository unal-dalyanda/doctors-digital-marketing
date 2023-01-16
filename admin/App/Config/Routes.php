<?php

use System\Libs\Router\Router as Route;

Route::set404(function () {
    header('HTTP/1.1 404 Not Found');
    View::render('errors.404');
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

    /* Services Route */
    Route::get('/services', 'ServiceController@index')->name('services');
    Route::post('/service/add', 'ServiceController@add')->name('service_add');
    Route::get('/service/delete/{serviceId}', 'ServiceController@delete')
        ->where(['serviceId' => '(\d+)'])
        ->name('service_delete');

    /* Team Route */
    Route::get('/members', 'TeamController@index')->name('members');
    Route::get('/member/add', 'TeamController@add')->name('member_add');
    Route::post('/member/add/save', 'TeamController@addAction')->name('member_add_action');
    Route::get('/member/edit/{memberId}', 'TeamController@edit')
        ->where(['memberId' => '(\d+)'])
        ->name('member_edit');
    Route::post('/member/edit/save/{memberId}', 'TeamController@editAction')
        ->where(['memberId' => '(\d+)'])
        ->name('member_edit_action');
    Route::get('/member/delete/{memberId}', 'TeamController@delete')
        ->where(['memberId' => '(\d+)'])
        ->name('member_delete');
    Route::get('/team/departments', 'TeamController@departments')->name('departments');
    Route::post('/team/department/add', 'TeamController@departmentAdd')->name('department_add');
    Route::get('/team/department/delete/{departmentId}', 'TeamController@departmentDelete')
        ->where(['departmentId' => '(\d+)'])
        ->name('department_delete');
});

Route::namespace('frontend')->group(function () {
    Route::get('/', 'PageController@index')->name('home');
    Route::get('/index.html', 'PageController@index');
    Route::get('/about.html', 'PageController@about')->name('about');
    Route::get('/contact.html', 'PageController@contact')->name('contact');
    Route::get('/appointment.html', 'PageController@appointment')->name('appointment');
    Route::get('/service.html', 'PageController@service')->name('service');
    Route::get('/team.html', 'PageController@team')->name('team');

    Route::get('/blogs.html', 'BlogController@blogs')->name('fr_blogs');
    Route::get('/blogs.html/{blogPage}', 'BlogController@blogs')
        ->where(['blogPage' => '(\d+)'])
        ->name('blog_page');

    Route::get('/blog/{blogSlug}', 'BlogController@blogDetail')
        ->where(['blogSlug' => '([a-z0-9-]+)'])
        ->name('blog_detail');

    Route::post('/action/appointment-post', 'ActionController@formPost')->name('appointment_post');
});

<?php

namespace App\Controllers\Backend;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use View, Session, Model, Upload, Request, Response, Hash;

class AdminController extends BaseController
{

    private $directory;
    private $images = array();
    private $valid_extensions = array("jpg", "jpeg", "png", "webp");

    public function index()
    {
        $this->pageData['title'] = 'Panel | Core-Page';
        $this->pageData['appointment_count'] = Model::run('application')->getApplicationCount();
        $this->pageData['blog_count'] = Model::run('blog')->getBlogCount();
        $this->pageData['recent_applications'] = Model::run('application')->getRecentApplications(5);
        $this->pageData['today_applications'] = Model::run('application')->getTodayApplications(5);

        View::theme($this->appTheme)->render('pages.dashboard', $this->pageData);
    }

    public function settings()
    {
        $this->pageData['title'] = 'Settings | Core-Page';
        $this->pageData['page_title'] = 'Settings';
        $this->pageData['general_settings'] = json_decode(Model::run('base')->getSetting('general')->settings_value);
        $this->pageData['contact_settings'] = json_decode(Model::run('base')->getSetting('contact')->settings_value);
        $this->pageData['seo_settings'] = json_decode(Model::run('base')->getSetting('seo')->settings_value);

        View::theme($this->appTheme)->render('pages.settings', $this->pageData);
    }

    public function settingsSave(string $type)
    {
        $socialArray = array();
        $settings_data = Request::post();

        $file = Request::files('site_logo');

        if (!empty($file['name'])) {
            if ($this->uploadImage($file, 'site_logo')) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $settings_data['site_logo'] = 'site_logo.' . $ext;
            } else {
                $flash['code'] = 0;
                $flash['text'] = 'The operation is invalid because the site logo is not uploaded. Error output: <br />' . Upload::errorMessage();

                Session::setFlash($flash, route('settings'));
            }
        }else{
            if($type == 'general'){
                $general_settings = json_decode(Model::run('base')->getSetting('general')->settings_value);

                if(!empty($general_settings->site_logo)){
                    $settings_data['site_logo'] = $general_settings->site_logo;
                }
            }
        }

        if ($type == 'contact') {
            $social = $_POST['social'];

            if (!empty($social)) {
                foreach (array_keys($social) as $fieldKey) {
                    foreach ($social[$fieldKey] as $key => $value) {
                        if (!empty($value))
                            $socialArray[$key][$fieldKey] = $value;
                    }
                }
            }

            $settings_data['social'] = $socialArray;
        }

        $update_settings = Model::run('base')->saveSettings($type, $settings_data);

        if ($update_settings) {
            $flash['code'] = 1;
            $flash['text'] = 'Settings saved.';
        } else {
            $flash['code'] = 0;
            $flash['text'] = 'Settings could not be saved.';
        }

        Session::setFlash($flash, route('settings'));
    }

    public function profileEdit()
    {
        $this->pageData['title'] = 'Profile Edit | Core-Page';

        if (Session::has('6c6f67696e5f757365725f6964')) {
            $login_user_id = Session::get('6c6f67696e5f757365725f6964');
            $user_data = Model::run('base')->getUser($login_user_id);

            if ($user_data) {
                $this->pageData['user'] = $user_data;

                View::theme($this->appTheme)->render('pages.profile', $this->pageData);
            } else {
                redirect('/auth/logout');
            }
        } else {
            redirect('/auth/logout');
        }
    }

    public function profileEditSave(int $userId)
    {
        $session_key = config('app.session.encryption_key');
        $user_data = Model::run('base')->getUser($userId);
        $update_data = [];

        if ($user_data) {

            $update_data['user_email'] = Request::post('user_email');

            if (!empty(Request::post('old_password'))) {
                if (Hash::check(Request::post('old_password') . '|' . $session_key, $user_data->user_pass)) {
                    if (!empty(Request::post('user_pass'))) {
                        $update_data['user_pass'] = Hash::make(Request::post('user_pass') . '|' . $session_key);
                    } else {
                        $flash['code'] = 0;
                        $flash['text'] = 'Type new password and try again.';

                        Session::setFlash($flash, route('profile_edit'));
                    }
                } else {
                    $flash['code'] = 0;
                    $flash['text'] = 'The old password does not match.';

                    Session::setFlash($flash, route('profile_edit'));
                }
            }

            $update_user = Model::run('base')->updateUser($userId, $update_data);

            if ($update_user) {
                $flash['code'] = 1;
                $flash['text'] = 'The user has been successfully updated..';
                Session::setFlash($flash, route('logout'));
            } else {
                $flash['code'] = 0;
                $flash['text'] = 'User update failed.';
                Session::setFlash($flash, route('profile_edit'));
            }

        } else {
            redirect('/auth/logout');
        }
    }

    public function contentImageUpload()
    {
        $file = Request::files('file');

        if (!empty($file['name'])) {
            if(!file_exists(public_path('uploads') . '/' . $file['name'])){
                if ($this->uploadImage($file, null, 'uploads')) {
                    $content = [
                        'location'	=> get_asset('uploads/' . $file['name'])
                    ];

                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($content);
                } else {
                    $content = [
                        'message'	=> 'The image could not be uploaded to the server. Server Message: ' . Upload::errorMessage()
                    ];

                    header("HTTP/1.1 500 Server Error");
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($content);
                }
            }else{
                $content = [
                    'message'	=> 'This image already exists.'
                ];

                header("HTTP/1.1 400 This image already exists.");
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($content);
            }
        }else{
            $content = [
                'message'	=> 'Invalid file!'
            ];

            header("HTTP/1.1 400 Invalid file name.");
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($content);
        }
    }

    public function imageGallery()
    {
        $this->directory = public_path('uploads');
        $this->listImages();
        $this->pageData['images'] = $this->getImages();

        View::theme($this->appTheme)->render('gallery.list', $this->pageData);
    }

    private function listImages() {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->directory));
        foreach ($files as $file) {
            if ($file->isFile()) {
                $file_name = $file->getFilename();
                $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
                if (in_array($file_extension, $this->valid_extensions)) {
                    $this->images[] = [
                        'path' => str_replace($this->directory, "", $file->getPathname()),
                        'name' => $file->getFilename(),
                        'size' => $this->sizeAsKb($file->getSize())
                    ];
                    /*
                    $this->images[$index]['path'] = str_replace($this->directory, "", $file->getPathname());
                    $this->images[$index]['name'] = $file->getFilename();
                    $this->images[$index]['size'] = $this->sizeAsKb($file->getSize());*/
                }
            }
        }
    }

    private function getImages(): array
    {
        return $this->images;
    }

    private function uploadImage($file, $fileName = null, $path = 'uploads/site'): bool
    {
        Upload::allowedTypes(['jpg', 'png', 'webp']);
        Upload::maxSize(2000);
        Upload::uploadPath(public_path($path));

        if (!is_null($fileName)) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            Upload::filename($fileName . '.' . $ext);
        }

        Upload::file($file);

        if (Upload::handle()) {
            return true;
        } else {
            return false;
        }
    }

    private function sizeAsKb(int $size): string
    {
        if ($size < 1024) {
            return $size . " bytes";
        } elseif ($size < 1048576) {
            $size_kb = round($size/1024);
            return $size_kb . " KB";
        } else {
            $size_mb = round($size/1048576, 1);
            return $size_mb . " MB";
        }
    }
}

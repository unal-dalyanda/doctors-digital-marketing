<?php
namespace App\Controllers\Backend;

use Model, Request, Upload, Session, View;

class FaqController extends BaseController
{

    public function index()
    {
    }

    public function add()
    {
    }

    public function delete($serviceId)
    {
    }

    private function uploadImage($file): bool
    {
        Upload::allowedTypes(['jpg', 'png']);
        Upload::maxSize(2000);
        Upload::uploadPath(public_path('uploads/services'));
        Upload::file($file);

        if(Upload::handle()){
            return true;
        }else{
            return false;
        }
    }
}

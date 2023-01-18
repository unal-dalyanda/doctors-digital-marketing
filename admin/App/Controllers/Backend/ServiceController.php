<?php
namespace App\Controllers\Backend;

use Model, Request, Upload, Session, View;

class ServiceController extends BaseController
{

	public function index()
	{
        $this->pageData['title'] = 'Services | Core-Page';
        $this->pageData['services'] = Model::run('service')->getServices();

        View::theme($this->appTheme)->render('pages.services', $this->pageData);
	}

    public function add()
    {
        $imageName = null;
        $file = Request::files('service_image');

        if(!empty($file['name'])){
            if($this->uploadImage($file)){
                $imageName = $file['name'];
            }else{
                $flash['code'] = 0;
                $flash['text'] = 'The operation is invalid because the service image is not uploaded. Error output: <br />' . Upload::errorMessage();

                Session::setFlash($flash, route('services'));
            }
        }

        $insertData = [
            'service_name' => Request::post('service_name'),
            'service_detail' => Request::post('service_detail'),
            'service_link' => Request::post('service_link'),
            'service_image' => $imageName
        ];

        $add_service = Model::run('service')->addService($insertData);

        if($add_service){
            $flash['code'] = 1;
            $flash['text'] = 'The service has been successfully added.';
        }else{
            $flash['code'] = 0;
            $flash['text'] = 'Add service failed! Try again later.';
        }

        Session::setFlash($flash, route('services'));
    }

    public function delete($serviceId)
    {
        $service_data   = Model::run('service')->getService($serviceId);

        if(!empty($service_data)){
            if(unlink(public_path('uploads/services/' . $service_data->service_image))){
                if(Model::run('service')->deleteService($serviceId)){
                    $flash['code'] = 1;
                    $flash['text'] = 'The service was successfully deleted.';
                }else{
                    $flash['code'] = 0;
                    $flash['text'] = 'Service deletion failed. Try again later.';
                }
            }else{
                $flash['code'] = 0;
                $flash['text'] = 'The operation is invalid because the service image is not deleted.';
            }
        }

        Session::setFlash($flash, route('services'));
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

<?php
namespace App\Controllers\Api;

use System\Kernel\Controller, Request, Response, Validation, Session, Model;

class ActionController extends Controller
{
    public function formPost()
    {
        set_lang('en');

        if (Request::isMethod('POST')) {
            if(!empty(Request::post('appointment_form_submit'))){
                if (csrf_check(Request::post('_token'))) {

                    $post_data = [
                        'email'         => Request::post('email'),
                        'doctor'        => Request::post('doctor'),
                        'name'          => Request::post('name'),
                        'phoneNumber'   => Request::post('phoneNumber'),
                        'insuranceId'   => Request::post('insuranceId'),
                        'insuranceName' => Request::post('insuranceName'),
                    ];

                    $form_rules = [
                        'email'	=> [
                            'label' => 'Email',
                            'rules'	=> 'required|email'
                        ],
                        'doctor'	=> [
                            'label'	=> 'Doctor',
                            'rules'	=> 'required|alpha_space|min_len,3'
                        ],
                        'name'	=> [
                            'label'	=> 'Full Name',
                            'rules'	=> 'required|min_len,3'
                        ],
                        'phoneNumber'	=> [
                            'label'	=> 'Phone Number',
                            'rules'	=> 'required|numeric|min_len,5'
                        ],
                        'insuranceId'	=> [
                            'label'	=> 'Insurance ID',
                            'rules'	=> 'required|numeric|min_len,3'
                        ],
                        'insuranceName'	=> [
                            'label'	=> 'Insurance Name',
                            'rules'	=> 'required'
                        ]
                    ];

                    Validation::bulkData($post_data);
                    Validation::rules($form_rules);

                    if (Validation::isValid()){
                        $data['application_data'] = json_encode($post_data);
                        $data['user_agent'] = Request::headers('User-Agent');
                        $data['user_long'] = ip2long(Request::getIp());

                        $add_application = Model::run('application')->addApplication($data);

                        if($add_application){
                            $flash['code'] = 1;
                            $flash['text'] = 'Your appointment request has been successfully received.';
                        }else{
                            $flash['code'] = 0;
                            $flash['text'] = 'Appointment registration failed. Please try again.';
                        }

                    }else{
                        $flash['code'] = 0;
                        $flash['text'] = 'Check the information on the appointment form and try again.';
                        $flash['error_messages'] = Validation::errors();

                    }
                    Session::setFlash($flash, route('appointment'));
                }else {
                    $this->formStatus(401, 'Unauthorized!');
                }
            }
        }else{
            $this->formStatus(403);
        }
    }

    private function formStatus($statusCode, $statusMessage = 'Method invalid!'){
        Response::setStatusCode($statusCode);
        exit($statusMessage);
    }
}

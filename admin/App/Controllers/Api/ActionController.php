<?php
namespace App\Controllers\Api;

use System\Kernel\Controller, Request, Response, Validation, Model;

class ActionController extends Controller
{
    public function formPost()
    {
        set_lang('en');

        if (Request::isMethod('POST')) {
            $post_data = [
                'email'         => Request::post('email'),
                'name'          => Request::post('name'),
                'phoneNumber'   => Request::post('telephone'),
                'message' => Request::post('message'),
            ];

            $form_rules = [
                'email'	=> [
                    'label' => 'Email',
                    'rules'	=> 'required|email'
                ],
                'name'	=> [
                    'label'	=> 'Full Name',
                    'rules'	=> 'required|min_len,3'
                ],
                'phoneNumber'	=> [
                    'label'	=> 'Phone Number',
                    'rules'	=> 'required|numeric|min_len,5'
                ],
                'message'	=> [
                    'label'	=> 'Message',
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
                    $flash['status'] = 'success';
                    $flash['message'] = 'Your contact request has been successfully received.';
                }else{
                    $flash['code'] = 0;
                    $flash['text'] = 'Appointment registration failed. Please try again.';
                }

            }else{
                $flash['status'] = 'error';
                $flash['message'] = 'Check the information on the contact form and try again.';
                $flash['error_messages'] = Validation::errors();

            }

            if($flash['status'] == 'error'){
                header('HTTP/1.1 400 Bad Request');
            }

        }else{

            $flash['status'] = 'error';
            $flash['message'] = 'Method invalid!';

            Response::setStatusCode(403);
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($flash);
    }
}

<?php
namespace App\Controllers\Backend;

use View, Model, Session, Request, Validation, Date;

class AuthController extends BaseController
{
	public function login()
	{
        $this->pageData['title'] = 'Login | Core-Page';
        View::theme($this->appTheme)->render('auth.login', $this->pageData);
	}

    public function loginAction(){
        if(Request::isMethod('POST')){
            $signInRules = [
                'email'	=> [
                    'label'	=> 'Email',
                    'rules'	=> 'required|email'
                ],
                'password'	=> [
                    'label'	=> 'Password',
                    'rules'	=> 'required'
                ]
            ];

            Validation::rules($signInRules, request());

            if (Validation::isValid()){
                $user = Model::run('auth')
                    ->Login(
                        Request::post('email'),
                        Request::post('password'),
                        'admin'
                    );

                if($user){
                    $login_date = Date::now()->get();
                    $session_db_import = Model::run('auth')->SessionDataImportFromDb($user->ID, $login_date, 'admin');

                    if($session_db_import){
                        Session::set(
                            [
                                '757365725f6c6f67696e'      => '74727565',
                                '6c6f67696e5f757365725f6964'=> $user->ID,
                                '6c6f67696e5f737472696e67'  => $user->user_email,
                                '6c6173745f6c6f67696e'      => $login_date,
                            ]);

                        if(Session::has('757365725f6c6f67696e')){
                            redirect(route('admin_dashboard'));
                        }else{
                            $flash['code'] = 0;
                            $flash['text'] = 'Login failed!';

                            Session::setFlash($flash, route('login'));
                        }
                    }else{
                        $flash['code'] = 0;
                        $flash['text'] = 'Login failed!';

                        Session::setFlash($flash, route('login'));
                    }
                }else{
                    $flash['code'] = 0;
                    $flash['text'] = 'Check your login information and try again.';

                    Session::setFlash($flash, route('login'));
                }

            }else{
                $flash['code'] = 0;
                $flash['text'] = 'Check your login information and try again.';

                Session::setFlash($flash, route('login'));
            }
        }
    }

    public function logout()
    {
        if(Session::destroy()){
            $flash['code'] = 1;
            $flash['text'] = 'Session terminated successfully.';
        }else{
            $flash['code'] = 0;
            $flash['text'] = 'The session could not be terminated.';
        }

        Session::setFlash($flash, route('login'));
    }

}

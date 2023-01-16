<?php
namespace App\Middlewares;

use Session, Request, Date, Model;

class Auth
{
    /*
    //757365725f6c6f67696e:user_login:boolean
    //6c6173745f6c6f67696e:last_login:datetime
    //6c6f67696e5f737472696e67:login_string:string
    //6c6f67696e5f757365725f6964:login_user_id:int
    //74727565:true
    //66616c7365:false
    */
    public static function handle()
	{
        if (Session::has('757365725f6c6f67696e')){
            if(Session::get('757365725f6c6f67696e') == '74727565'){

                $login_string       = Session::get('6c6f67696e5f737472696e67');
                $sessionDataCheck   = Model::run('auth')->SessionCheckFromDB($login_string, 'admin');

                if(Session::get('6c6173745f6c6f67696e') != $sessionDataCheck->last_login){
                    $flash['code'] = 0;
                    $flash['text'] = 'Login failed!';

                    Session::setFlash($flash, route('logout'));
                }
            }else{
                $flash['code'] = 0;
                $flash['text'] = 'Login failed!';

                Session::setFlash($flash, route('logout'));
            }
        }else{
            $flash['code'] = 0;
            $flash['text'] = 'Login failed!';

            Session::setFlash($flash, route('logout'));
        }
	}

}

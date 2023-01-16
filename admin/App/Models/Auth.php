<?php
namespace App\Models;

use DB, Date, Hash;

class Auth
{
    public function Login($login_string, $password, $user_type = 'user')
    {
        $session_key = config('app.session.encryption_key');
        $user_pass = $password . '|' . $session_key;
        $user_data = DB::table($user_type)
            ->select('ID, user_email, user_pass')
            ->where('user_email', '=', $login_string)
            ->getRow();

        if($user_data){
            if(Hash::check($user_pass, $user_data->user_pass)){
                return $user_data;
            }
        }
    }

    public function SessionCheckFromDB($login_string, $user_type = 'user')
    {
        return DB::table($user_type)
            ->select('ID, user_email, last_login')
            ->where('user_email', '=', $login_string)
            ->getRow();
    }

    public function SessionDataImportFromDb($user_id, $login_date, $user_type = 'user')
    {
        $data = [
            'last_login'    => $login_date
        ];

        return DB::table($user_type)->where('ID', '=', $user_id)->update($data);
    }
}

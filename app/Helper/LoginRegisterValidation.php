<?php

namespace App\Helper;

use App\Models\User;

class LoginRegisterValidation{

    public function ValidateRegister($email)
    {
        if($model = User::where('email',$email)->first()){
            return $model;
        }
        return false;
    }

}

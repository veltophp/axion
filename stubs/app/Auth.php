<?php

namespace Velto\Axion\App;

use Velto\Axion\Models\User;

use Velto\Axion\Session;


class Auth
{

    public static function user()
    {
        $userSession = Session::get('user');
        
        if (!$userSession) {
            return null;
        }

        return User::findBy('email', $userSession->email);
    }


    public static function check()
    {
        return Session::get('user') !== null;
    }

    public static function login(User $user)
    {
        Session::set('user', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
    
    public static function logout()
    {
        // Session::destroy('user'); //Removed specific key destory.
        Session::destroy();
    }
}
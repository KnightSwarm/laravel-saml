<?php namespace KnightSwarm\LaravelSaml;


use \Saml;
use \User;
use \Auth;

class Account {


    public function userExists($id)
    {
        $user = User::find($id);

        return $user ? true : false;
    }

    public function samlLogged()
    {
        return Saml::isAuthenticated();
    }

    public function samlLogin()
    {
        Saml::requireAuth();
    }

    public function laravelLogin($id)
    {
        if ($this->userExists($id)) {
            Auth::login(User::find($id));
        } else {

        }
    }

    public function getSamlUid()
    {
        $data = Saml::getAttributes();
        return (int) $data['uid'][0];
    }

    public function laravelLogged()
    {
        return Auth::check();
    }

    public function createUser()
    {
        $data = Saml::getAttributes();
        $user = new User();
        $user->id = (int) $data['uid'][0];
        $user->name = $data['name'][0];
        $user->save();
        $this->laravelLogin($user->id);
    }

    public function logout()
    {
        Auth::logout();
        Saml::logout(\Config::get('laravel-saml::saml.logout_target', 'http://'.$_SERVER['SERVER_NAME']));
    }
} 
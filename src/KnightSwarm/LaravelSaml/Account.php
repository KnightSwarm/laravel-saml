<?php namespace KnightSwarm\LaravelSaml;


use \Saml;
use \User;
use \Auth;
use \Cookie;

class Account {

    public function EmailExists($email)
    {
        $user = User::where("email", "=", $email)->count();
        return $user === 0 ? false : true;
    }

    public function samlLogged()
    {
        return Saml::isAuthenticated();
    }

    public function samlLogin()
    {
        Saml::requireAuth();
    }

    public function laravelLogin($email)
    {
        if ($this->EmailExists($email)) {
            $userid = (int)User::where("email", "=", $email)->take(1)->get()[0]->id;
            Auth::login(User::find($userid));
        }
    }

    public function getSamlEmail()
    {
        $data = Saml::getAttributes();
        return $data['email'][0]; //for non-numeric uids
    }

    public function getSamlName()
    {
        $data = Saml::getAttributes();
        return $data['SAML_FIRST_NAME'][0] . ' ' . $data['SAML_LAST_NAME'][0];
    }

    public function laravelLogged()
    {
        return Auth::check();
    }

    public function createUser()
    {
        $data = Saml::getAttributes();
        $user = new User();
        $user->email = $this->getSamlEmail();
        $user->save();
        $this->laravelLogin($user->email);
    }

    public function logout()
    {
        Auth::logout();
        $auth_cookie = Cookie::forget('SimpleSAMLAuthToken');
        return $auth_cookie;
    }
}

<?php namespace KnightSwarm\LaravelSaml;


use \Saml;
use \User;
use \Auth;
use \Cookie;

class Account {

    public function UIDExists($uid)
    {
        $user = User::where("uid", "=", $uid)->count();
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

    public function laravelLogin($uid)
    {
        if ($this->UIDExists($uid)) {
            $userid = (int)User::where("uid", "=", $uid)->take(1)->get()[0]->id;
            Auth::login(User::find($userid));
        }
    }

    public function getSamlUid()
    {
        $data = Saml::getAttributes();
        //return (int) $data['uid'][0];
        return $data['uid'][0]; //for non-numeric uids
    }

    public function getSamlName()
    {
        $data = Saml::getAttributes();
        return $data['cn'][0];
    }

    public function laravelLogged()
    {
        return Auth::check();
    }

    public function createUser()
    {
        $data = Saml::getAttributes();
        $user = new User();
        $user->uid = $data['uid'][0];
        $user->name = $data['cn'][0];
        $user->save();
        $this->laravelLogin($user->id);
    }

    public function logout()
    {
        Auth::logout();
        $auth_cookie = Cookie::forget('SimpleSAMLAuthToken');
        return $auth_cookie;
    }
}

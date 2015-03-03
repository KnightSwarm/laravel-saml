<?php namespace KnightSwarm\LaravelSaml;


use \Saml;
use \Auth;
use \Cookie;
use \Config;

class Account {

    private $userClass;

    public function __construct()
    {
        $this->userClass = Config::get('laravel-saml::saml.sp_user_model_class');
    }

    protected function getUserIdProperty() {
        return Config::get('laravel-saml::saml.internal_id_property', 'email');
    }

    protected function getSamlIdProperty() {
        return Config::get('laravel-saml::saml.saml_id_property', 'email');
    }

    /**
     * Check if the id exists in the specified user property.
     * If no property is defined default to 'email'.
     */
    public function IdExists($id)
    {
        $property = $this->getUserIdProperty();

        $user = call_user_func(array($this->userClass, 'where'), $property, "=", $id)->count();

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

    public function laravelLogin($id)
    {
        if ($this->IdExists($id)) {
            $property = $this->getUserIdProperty();

            $user = call_user_func(array($this->userClass, 'where'), $property, "=", $id)->first();

            Auth::login($user);
        }
    }

    public function getSamlAttribute($attribute)
    {
        $data = Saml::getAttributes();
        return $data[$attribute][0];
    }

    public function getSamlUniqueIdentifier()
    {
        return $this->getSamlAttribute($this->getSamlIdProperty()); 
    }

    public function getSamlName()
    {
        return $data['SAML_FIRST_NAME'][0] . ' ' . $data['SAML_LAST_NAME'][0];
    }

    public function laravelLogged()
    {
        return Auth::check();
    }

    /**
     * If mapping between saml attributes and object attributes are defined
     * then fill user object with mapped values.
     */
    protected function fillUserDetails($user)
    {
         $mappings = Config::get('laravel-saml::saml.object_mappings',[]);

         foreach($mappings as $key => $mapping)
         {
             $user->{$key} = $this->getSamlAttribute($mapping);
         }
    }

    public function createUser()
    {
        $user = new $this->userClass();

        $user->{$this->getUserIdProperty()} = $this->getSamlUniqueIdentifier();

        $this->fillUserDetails($user);

        $user->save();
        
        $this->laravelLogin($user->{$this->getUserIdProperty()});
    }

    public function logout()
    {
        Auth::logout();

        $auth_cookie = Cookie::forget('SimpleSAMLAuthToken');

        return $auth_cookie;
    }

}
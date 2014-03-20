<?php namespace KnightSwarm\LaravelSaml\Saml;

use \Config;

class Boot {


    protected $path;
    protected $sp;
    protected $saml;

    public function __construct()
    {
        $this->path = Config::get('laravel-saml::saml.sp_path', public_path()."/sp/www");
        $this->sp   = Config::get('laravel-saml::saml.sp_name', 'default-sp');

        require_once($this->path.'/lib/_autoload.php');

        $this->saml = new \SimpleSAML_Auth_Simple($this->sp);


    }

    public function getAttributes()
    {

        return $this->saml->getLogoutURL();
    }
} 
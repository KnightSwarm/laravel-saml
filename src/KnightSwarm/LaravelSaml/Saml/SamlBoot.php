<?php namespace KnightSwarm\LaravelSaml\Saml;

use \Config;

class SamlBoot {


    protected $path;
    protected $sp;
    public    $saml;

    public function __construct()
    {
        $this->saml = $this->setupSimpleSaml();
    }


    protected function setupSimpleSaml()
    {
        $this->path = Config::get('laravel-saml::saml.sp_path', public_path()."/sp/www");
        $this->sp   = Config::get('laravel-saml::saml.sp_name', 'default-sp');

        require_once($this->path.'/lib/_autoload.php');

        return new \SimpleSAML_Auth_Simple($this->sp);
    }


} 
<?php namespace KnightSwarm\LaravelSaml\Saml;

use \Config;

class SamlBoot {


    protected $path;
    protected $sp;
    protected $saml;

    public function __construct($samlSpResolver)
    {
        $this->sp_resolver = $samlSpResolver;
        $this->saml = $this->setupSimpleSaml();
    }

    public function getSimpleSaml()
    {
        return $this->saml;
    }


    protected function setupSimpleSaml()
    {
        $this->path = Config::get('laravel-saml::saml.sp_path', public_path()."/sp/www");
        $this->sp   = $this->sp_resolver;

        require_once($this->path.'/lib/_autoload.php');

        return new \SimpleSAML_Auth_Simple($this->sp);
    }


} 

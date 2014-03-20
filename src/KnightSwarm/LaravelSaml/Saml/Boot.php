<?php namespace KnightSwarm\LaravelSaml\Saml;


class Boot {


    protected $path;
    protected $sp;
    protected $saml;

    public function __construct()
    {
        $this->path = Config::get('package::saml.sp_path', public_path()."/sp1");
        $this->sp   = Config::get('package::saml.sp_name', 'default_sp');

        require_once($this->path.'/lib/_autoload.php');

        $this->saml = new SimpleSAML_Auth_Simple($this->sp);


    }

    public function getAttributes()
    {
        return $this->saml->getAttributes();
    }
} 
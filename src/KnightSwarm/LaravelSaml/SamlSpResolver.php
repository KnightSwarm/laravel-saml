<?php namespace KnightSwarm\LaravelSaml;

class SamlSpResolver {
  public function __construct($app) {
    $this->app = $app;
  }

  public function getSPName() {
    return $this->app->config->get('laravel-saml::saml.sp_name', 'default-sp');
  }
}

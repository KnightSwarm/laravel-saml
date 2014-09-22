<?php

class SamlSpResolver {
  public function getSPName() {
    return $this->app->config->get('laravel-saml::saml.sp_name', 'default-sp');
  }
}

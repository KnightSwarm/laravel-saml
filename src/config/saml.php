<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | laravel-saml config file
    |--------------------------------------------------------------------------
    |
    | Here you need to specify a working phpsimplesaml install working as
    | a Service Provider already connected (or acting like) a Identity provider
    |
    */


    /*
     * The path to the working phpsimplesaml install
     */
    'sp_path' => "/var/simplesamlphp",

    /*
     * The service provider name
     */
    'sp_name' => "default_sp",

    /*
     * The redirect destination after logging out
     */
    'logout_target' => 'http://saml.dev',
);

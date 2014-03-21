laravel-saml
============

Open Source SAML Auth Support for Laravel using simplesamlphp.


#### Requeriments
- Laravel install, of course
- Working simplesamlphp instance acting like an Service Provider


#### Instalation

First, we need this package available on Laravel, update your `composer.json` dependencies with:
    
    "knight-swarm/laravel-saml": "dev-master"
and run `composer update`

After we have this package, we need to load it on Laravel, for this, add this

    'KnightSwarm\DevTest\DevTestServiceProvider'

service provider on the `'providers'` array (`app/config/app.php`)

and the 

    'SimpleSaml'      => 'KnightSwarm\LaravelSaml\Facades\SimpleSaml'

 facade on the `'facades'` array.
 
 
 Now, we need to configure it, run
 
     php artisan config::publish knight-swarm/laravel-saml
    
 the above command will create a `saml.php` file inside `app/config/packages/knight-swarm/laravel-saml`, edit this file and be sure to insert:
 
 Your **SimpleSamlPHP** SP install path
 
     'sp_path' => app_path()."/../../sp",
     
 and your default SP id
 
     'sp_name' => 'saml.dev',
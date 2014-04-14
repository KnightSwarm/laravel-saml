laravel-saml
============

Open Source SAML Auth Support for Laravel using simplesamlphp.


#### Requeriments
- Laravel install, of course
- Working SimpleSAMLphp instance acting like an Service Provider


#### Instalation

1. Update your `composer.json` dependencies:  
    `"tmountjr/laravel-saml": "dev-master"`
2. Update Laravel by running
        composer update
3. Open `app/config/app.php` and add the following to the `providers` array:  
    `'KnightSwarm\DevTest\DevTestServiceProvider'`
4. In the `app.php` file, add the following to the `facades` array:  
    `'SimpleSaml'      => 'KnightSwarm\LaravelSaml\Facades\Saml'
5. Publish the wrapper by running
        php artisan config:publish tmountjr/laravel-saml
6. The above command will create a `saml.php` file in `app/config/poackages/tmountjr/laravel-saml`. Open the file and set the `sp_path`, `sp_name`, and `logout_target` variables.
 * `sp_path`: the path to your SimpleSAMLphp library (default: `/var/simplesamlphp`)
 * `sp_name`: the default name of your SompleSAMLphp server (default: `default_sp`)
 * `logout_target`: the URL to which the user will be redirected after logout

This Package will trigger `/login` and `/logout`

##@TODO
We need to implement custom attributes bindings on model and database, for PoC it gets only `uid` and `name` attribuites and will fail it they does not exists

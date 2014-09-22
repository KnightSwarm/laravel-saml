<?php namespace KnightSwarm\LaravelSaml;

use Illuminate\Support\ServiceProvider;

class LaravelSamlServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;



    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('knight-swarm/laravel-saml');
        include __DIR__.'/../../routes.php';
    }



    /**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind('SamlSpResolver', function() {
            return new SamlSpResolver();
        });

        $this->app->bind('Saml', function()
        {
            $sp_resolver = $this->app->make('SamlSpResolver');
            $samlboot = new Saml\SamlBoot($sp_resolver->getSPName());
            return $samlboot->getSimpleSaml();
        });
    }


	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}

<?php

namespace Alsaad\Laravel;

use Alsaad\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository as Config;

class AlsaadServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Config file
        $dist = __DIR__.'/../config/alsaad.php';

        // If we're installing in to a Lumen project, config_path
        // won't exist so we can't auto-publish the config
        if (function_exists('config_path')) {
            // Publishes config File.
            $this->publishes([
                $dist => config_path('alsaad.php'),
            ]);
        }

        // Merge config.
        $this->mergeConfigFrom($dist, 'alsaad');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind Nexmo Client in Service Container.
        $this->app->singleton(Client::class, function ($app) {
            return $this->createClient($app['config']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Client::class];
    }

    /**
     * Create a new Nexmo Client.
     *
     * @param Config $config
     *
     * @return Client
     *
     * @throws \RuntimeException
     */
    protected function createClient(Config $config)
    {
        // Check for Nexmo config file.
        if (! $this->hasAlsaadConfigSection()) {
            $this->raiseRunTimeException('Missing Alsaad configuration section.');
        }

        $options = array_diff_key($config->get('alsaad'), ['options']);

        if (! $this->alsaadConfigHas('username') || ! $this->alsaadConfigHas('password')) {
            $possibleKeys = [
                'username + password',
            ];
            $this->raiseRunTimeException(
                'Please provide Alsaad2 API credentials. Possible combinations: '
                . join(", ", $possibleKeys)
            );
        }

        $httpClient = null;
        if ($this->alsaadConfigHas('http_client')) {
            $httpClient = $this->app->make($config->get(('alsaad.http_client')));
        }

        $credentials = [
            'username' => $config->get('alsaad.username'),
            'password' => $config->get('alsaad.password'),
        ];

        return new Client($credentials, $options, $httpClient);
    }

    /**
     * Checks if has global configuration section.
     *
     * @return bool
     */
    protected function hasAlsaadConfigSection()
    {
        return $this->app->make(Config::class)
            ->has('alsaad');
    }

    /**
     * Checks if config does not
     * have a value for the given key.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function alsaadConfigHasNo($key)
    {
        return ! $this->alsaadConfigHas($key);
    }

    /**
     * Checks if config has value for the
     * given key.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function alsaadConfigHas($key)
    {
        /** @var Config $config */
        $config = $this->app->make(Config::class);

        // Check for config file.
        if (! $config->has('alsaad')) {
            return false;
        }

        return
            $config->has('alsaad.'.$key) &&
            ! is_null($config->get('alsaad.'.$key)) &&
            ! empty($config->get('alsaad.'.$key));
    }

    /**
     * Raises Runtime exception.
     *
     * @param string $message
     *
     * @throws \RuntimeException
     */
    protected function raiseRunTimeException($message)
    {
        throw new \RuntimeException($message);
    }
}

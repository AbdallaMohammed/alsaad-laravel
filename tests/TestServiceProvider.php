<?php

namespace Alsaad\Laravel\Tests;

use Alsaad\Client;

class TestServiceProvider extends AbstractTestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('alsaad.username', 'my_username');
        $app['config']->set('alsaad.password', 'my_password');
    }

    /**
     * Test that we can create the Nexmo client
     * from container binding.
     *
     * @return void
     */
    public function testClientResolutionFromContainer()
    {
        $client = app(Client::class);

        $this->assertInstanceOf(Client::class, $client);
    }
}

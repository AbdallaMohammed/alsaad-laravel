<?php

namespace Alsaad\Laravel\Tests;

use Alsaad\Client;

class TestNoAlsaadConfiguration extends AbstractTestCase
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
    }

    /**
     * Test that when we do not supply Nexmo configuration
     * a Runtime exception is generated.
     *
     * @return void
     *
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Please provide Alsaad2 API credentials. Possible combinations: username + password
     */
    public function testWhenNoConfigurationIsGivenExceptionIsRaised()
    {
        app(Client::class);
    }
}

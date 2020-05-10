<?php

namespace Alsaad\Laravel\Facade;

use Alsaad\Client;
use Illuminate\Support\Facades\Facade;

class Alsaad extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return Client::class;
    }
}

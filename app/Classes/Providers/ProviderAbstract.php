<?php

namespace App\Classes\Providers;

use App\Models\EnvironmentProvider;

abstract class ProviderAbstract implements ProviderInterface
{
    /** @var EnvironmentProvider */
    protected $env;

    /** @var array */
    protected $config;

    public function __construct(EnvironmentProvider $env)
    {
        $this->env = $env;
        $this->config = config('provider');
    }
}

<?php

namespace App\Classes\Providers;

use App\Models\Provider;
use Psr\Log\InvalidArgumentException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

final class ProviderFactory
{
    /**
     * Init provider
     *
     * @param string $name
     * @return ProviderInterface
     * @throws \Exception
     */
    public static function factory(string $name): ProviderInterface
    {
        $class = __NAMESPACE__.'\Provider'.ucfirst($name);

        if (class_exists($class)) {
            $provider = Provider::where('name', $name)->first();

            if (!$provider) {
                throw (new NotFoundResourceException(__('Provider not found')));
            }

            $envProvider = $provider->environments()->wherePivot('status', true)->first();

            if (!$envProvider) {
                throw (new NotFoundResourceException(__('Active provider environment not found')));
            }

            return new $class($envProvider->pivot);
        }

        throw (new InvalidArgumentException(__('Unknown provider given')));
    }
}

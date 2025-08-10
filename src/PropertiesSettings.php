<?php

declare(strict_types=1);

namespace Imponeer\Properties;

use Imponeer\Properties\Exceptions\NoContainerSetException;

use Psr\Container\ContainerInterface;

/**
 * Static class for working with properties in a PSR-11 compatible container.
 */
class PropertiesSettings
{
    /**
     * @var ContainerInterface|null The container instance
     */
    private static ?ContainerInterface $container = null;

    /**
     * Set the container instance to be used by the static methods.
     *
     * @param ContainerInterface $container The PSR-11 container to use
     * @return void
     */
    public static function setContainer(ContainerInterface $container): void
    {
        self::$container = $container;
    }

    /**
     * Get the underlying container instance.
     *
     * @return ContainerInterface
     * @throws NoContainerSetException When no container has been set
     */
    public static function getContainer(): ContainerInterface
    {
        if (self::$container === null) {
            throw new NoContainerSetException();
        }

        return self::$container;
    }
}

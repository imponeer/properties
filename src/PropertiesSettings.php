<?php

declare(strict_types=1);

namespace Imponeer\Properties;

use Imponeer\Properties\Exceptions\NoContainerSetException;
use Imponeer\Properties\Exceptions\RequestNotSetException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface;

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
     * @var ServerRequestInterface|null The current PSR-7 request instance
     */
    private static ?ServerRequestInterface $request = null;

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
     * Get the container instance.
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

    /**
     * Gets the current PSR-7 request
     *
     * @return ServerRequestInterface
     */
    public static function getRequest(): ServerRequestInterface
    {
        if (self::$request === null) {
            try {
                $container = self::getContainer();
                if ($container->has(ServerRequestInterface::class)) {
                    $request = $container->get(ServerRequestInterface::class);
                    if ($request instanceof ServerRequestInterface) {
                        self::$request = $request;

                        return $request;
                    }
                }
            } catch (NoContainerSetException|NotFoundExceptionInterface|ContainerExceptionInterface $e) {
				throw new RequestNotSetException(
					previous: $e,
				);
			}

			throw new RequestNotSetException();
        }
        return self::$request;
    }

    /**
     * Sets the current PSR-7 request
     *
     * @param ServerRequestInterface $request The request to set
     */
    public static function setRequest(ServerRequestInterface $request): void
    {
        self::$request = $request;
    }
}

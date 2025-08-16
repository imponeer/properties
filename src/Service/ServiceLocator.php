<?php

declare(strict_types=1);

namespace Imponeer\Properties\Service;

use GuzzleHttp\Psr7\ServerRequest;
use Imponeer\Properties\CommonProperties;
use Imponeer\Properties\Exceptions\ServiceNotFoundException;
use MetaSyntactical\Log\InMemoryLogger\InMemoryLogger;
use Psr\Container\ContainerInterface;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;
use const GuzzleHttp\Psr7\ServerRequest;

/**
 * @internal
 */
class ServiceLocator implements PsrContainerInterface
{

	private const array SERVICES = [
		// by internal name
		'properties.common_type.counter' => CommonProperties\Counter::class,
		'properties.common_type.custom_css' => CommonProperties\CustomCss::class,
		'properties.common_type.dobr' => CommonProperties\Dobr::class,
		'properties.common_type.docxode' => CommonProperties\Docxode::class,
		'properties.common_type.dohtml' => CommonProperties\Dohtml::class,
		'properties.common_type.doimage' => CommonProperties\Doimage::class,
		'properties.common_type.dosmiley' => CommonProperties\Dosmiley::class,
		'properties.common_type.doxcode' => CommonProperties\Doxcode::class,
		'properties.common_type.hierarchy_path' => CommonProperties\HierarchyPath::class,
		'properties.common_type.meta_description' => CommonProperties\MetaDescription::class,
		'properties.common_type.meta_keywords' => CommonProperties\MetaKeywords::class,
		'properties.common_type.short_url' => CommonProperties\ShortUrl::class,
		'properties.common_type.weight' => CommonProperties\Weight::class,
		// for interfaces
		LoggerInterface::class => InMemoryLogger::class,
		TranslatorInterface::class => Translator::class,
		ServerRequestInterface::class => [
			ServerRequest::class,
			'fromGlobals',
		],
	];

    /**
     * @var ContainerInterface|null The container instance
     */
    private static ?ContainerInterface $container = null;

    /**
     * Set the container instance
     *
     * @param ContainerInterface $container The PSR-11 container instance
     */
    public static function setContainer(ContainerInterface $container): void
    {
        self::$container = $container;
    }

	public static function getInstance(): self
	{
		static $instance = null;
		if ($instance === null) {
			$instance = new self();
		}

		return $instance;
	}

    public function get(string $id): mixed
    {
		static $instances = [];

        if (self::$container !== null && self::$container->has($id)) {
            return self::$container->get($id);
        }

		if (isset(self::SERVICES[$id])) {
			if (is_array(self::SERVICES[$id])) {
				[$class, $method] = self::SERVICES[$id][0];
				$instances[$id] = $class::$method();
			} else {
				$instances[$id] = new (self::SERVICES[$id])();
			}

			return $instances[$id];
		}

        if (class_exists($id)) {
            return new $id();
        }

        throw new ServiceNotFoundException($id);
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        if (self::$container !== null && self::$container->has($id)) {
            return true;
        }

		return isset(self::SERVICES[$id]) || class_exists($id);
    }

}

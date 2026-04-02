<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Service;

use Imponeer\Properties\CommonProperties\Counter;
use Imponeer\Properties\Exceptions\ServiceNotFoundException;
use Imponeer\Properties\Service\ServiceLocator;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ServiceLocatorTest extends TestCase
{
    protected function setUp(): void
    {
        ServiceLocator::setContainer(
            new class implements ContainerInterface {
                public function get(string $id): mixed
                {
                    throw new ServiceNotFoundException($id);
                }

                public function has(string $id): bool
                {
                    return false;
                }
            }
        );
        parent::setUp();
    }

    public function testHasDetectsKnownServices(): void
    {
        $locator = ServiceLocator::getInstance();
        $dummy = new class {
        };

        $this->assertTrue($locator->has('properties.common_type.counter'));
        $this->assertTrue($locator->has($dummy::class));
        $this->assertFalse($locator->has('unknown.service'));
    }

    public function testGetReturnsBuiltInServices(): void
    {
        $locator = ServiceLocator::getInstance();

        $service = $locator->get('properties.common_type.counter');

        $this->assertInstanceOf(Counter::class, $service);
    }

    public function testContainerOverrideIsHonored(): void
    {
        $expected = new \stdClass();
        $container = new class ($expected) implements ContainerInterface {
            public function __construct(private \stdClass $service)
            {
            }

            public function get(string $id): mixed
            {
                return $this->service;
            }

            public function has(string $id): bool
            {
                return $id === 'overridden';
            }
        };

        ServiceLocator::setContainer($container);

        $locator = ServiceLocator::getInstance();

        $this->assertSame($expected, $locator->get('overridden'));
    }

    public function testGetInstantiatesClassesByName(): void
    {
        $locator = ServiceLocator::getInstance();
        $dummy = new class {
        };

        $service = $locator->get($dummy::class);

        $this->assertInstanceOf($dummy::class, $service);
    }

    public function testGetThrowsWhenServiceMissing(): void
    {
        $locator = ServiceLocator::getInstance();

        $this->expectException(ServiceNotFoundException::class);
        $locator->get('missing.service');
    }
}

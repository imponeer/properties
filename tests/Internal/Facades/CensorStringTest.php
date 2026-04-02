<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Internal\Facades;

use Imponeer\Properties\Contracts\CensorStringInterface;
use Imponeer\Properties\Service\ServiceLocator;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class CensorStringTest extends TestCase
{
    protected function setUp(): void
    {
        // Reset the container to ensure clean state
        ServiceLocator::setContainer(null);
    }

    public function testCensorStringWithDefaultImplementation(): void
    {
        $text = 'This is a test string';
        /** @noinspection PhpUnhandledExceptionInspection */
        $censor = ServiceLocator::getInstance()->get(CensorStringInterface::class);
        $result = $censor($text);

        $this->assertSame($text, $result, 'Default implementation should return text unchanged');
    }

    public function testCensorStringWithCustomImplementation(): void
    {
        // Create a custom censor implementation
        $customCensor = new class implements CensorStringInterface {
            public function __invoke(string $text): string
            {
                return str_replace('bad', '***', $text);
            }
        };

        // Create a mock container
        $container = $this->createMock(ContainerInterface::class);
        $container->method('has')
            ->with(CensorStringInterface::class)
            ->willReturn(true);
        $container->method('get')
            ->with(CensorStringInterface::class)
            ->willReturn($customCensor);

        ServiceLocator::setContainer($container);

        /** @noinspection PhpUnhandledExceptionInspection */
        $censor = ServiceLocator::getInstance()->get(CensorStringInterface::class);
        $result = $censor('This is bad text');

        $this->assertSame('This is *** text', $result, 'Custom implementation should censor the text');
    }
}

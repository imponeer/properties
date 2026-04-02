<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Internal\Facades;

use Imponeer\Properties\Contracts\CensorStringInterface;
use Imponeer\Properties\Internal\Facades\CensorString;
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
        $result = CensorString::censorString($text);

        $this->assertSame($text, $result, 'Default implementation should return text unchanged');
    }

    public function testCensorStringWithCustomImplementation(): void
    {
        // Create a custom censor implementation
        $customCensor = new class implements CensorStringInterface {
            public function censorString(string $text): string
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

        $result = CensorString::censorString('This is bad text');

        $this->assertSame('This is *** text', $result, 'Custom implementation should censor the text');
    }
}
